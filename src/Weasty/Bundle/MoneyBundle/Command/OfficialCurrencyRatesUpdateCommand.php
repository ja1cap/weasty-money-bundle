<?php
namespace Weasty\Bundle\MoneyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class OfficialCurrencyRatesUpdateCommand
 * @package Weasty\Bundle\MoneyBundle\Command
 */
class OfficialCurrencyRatesUpdateCommand extends ContainerAwareCommand
{

  protected function configure()
  {
    $this
      ->setName('weasty:money:official-currency-rates:update')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {

    $sourceCurrencyCode = $this->getContainer()->getParameter('currency_code');

    /**
     * @var \Weasty\Money\Manager\OfficialCurrencyRatesManagerInterface $manager
     */
    $manager = $this->getContainer()->get('weasty_money.official_currency.rates.manager');
    $manager->updateRepositoryFromRemote($sourceCurrencyCode);

    return;

  }
  
}