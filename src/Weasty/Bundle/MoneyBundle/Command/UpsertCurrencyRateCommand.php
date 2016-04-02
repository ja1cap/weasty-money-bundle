<?php
namespace Weasty\Bundle\MoneyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpsertCurrencyRateCommand
 * @package Weasty\Bundle\MoneyBundle\Command
 */
class UpsertCurrencyRateCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this->setName('weasty:currency-rate:upsert');
    $this->addArgument('codes', InputArgument::IS_ARRAY | InputArgument::OPTIONAL);
    $this->addOption('upsert-default', null, InputOption::VALUE_OPTIONAL);
    $this->addOption('update-existing-from-official', null, InputOption::VALUE_OPTIONAL);
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {

    $codes = $input->getArgument('codes') ?: [];
    $upsertDefault = filter_var($input->getOption('upsert-default'), FILTER_VALIDATE_BOOLEAN);
    $updateExistingFromOfficial = filter_var($input->getOption('update-existing-from-official'), FILTER_VALIDATE_BOOLEAN);

    $em = $this->getContainer()->get('doctrine')->getManager();

    $currencyRateManager = $this->getContainer()->get('weasty_money.currency.rate.manager');
    $currencyRateManager->upsert($codes, $upsertDefault, $updateExistingFromOfficial, $output, $em);

    return;

  }

}