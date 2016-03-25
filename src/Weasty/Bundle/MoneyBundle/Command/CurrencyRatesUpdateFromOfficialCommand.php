<?php
namespace Weasty\Bundle\MoneyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CurrencyRatesUpdateFromOfficialCommand
 * @package Weasty\Bundle\MoneyBundle\Command
 */
class CurrencyRatesUpdateFromOfficialCommand extends ContainerAwareCommand
{

  protected function configure()
  {
    $this
      ->setName('weasty:money:currency-rates:update-from-official')
      ->addOption('source-code', 'sc', InputOption::VALUE_OPTIONAL)
      ->addOption('destination-code', 'dc', InputOption::VALUE_OPTIONAL)
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {

    $sourceCurrencyCode = $input->getOption('source-code') ?: $this->getContainer()->getParameter('currency_code');
    $destinationCurrencyCode = $input->getOption('destination-code');

    /**
     * @var \Weasty\Bundle\MoneyBundle\Entity\CurrencyRateRepository $repository
     */
    $repository = $this->getContainer()->get('weasty_money.currency.rate.repository');
    $repository->updateFromOfficial($sourceCurrencyCode, $destinationCurrencyCode);

    return;

  }

}