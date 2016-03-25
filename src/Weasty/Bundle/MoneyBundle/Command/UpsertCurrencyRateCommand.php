<?php
namespace Weasty\Bundle\MoneyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Weasty\Bundle\MoneyBundle\Entity\OfficialCurrencyRate;

/**
 * Class UpsertCurrencyRateCommand
 * @package Weasty\Bundle\MoneyBundle\Command
 */
class UpsertCurrencyRateCommand extends ContainerAwareCommand {
  protected function configure() {
    $this->setName( 'weasty:currency-rate:upsert' );
    $this->addArgument( 'codes', InputArgument::IS_ARRAY | InputArgument::OPTIONAL );
    $this->addOption( 'upsert-default', null, InputOption::VALUE_OPTIONAL );
    $this->addOption( 'update-existing-from-official', null, InputOption::VALUE_OPTIONAL );
  }

  protected function execute( InputInterface $input, OutputInterface $output ) {

    $em = $this->getContainer()->get( 'doctrine' )->getManager();

    $currencyRateRepository         = $this->getContainer()->get( 'weasty_money.currency.rate.repository' );
    $officialCurrencyRateRepository = $this->getContainer()->get( 'weasty_money.official_currency.rate.repository' );
    $officialCurrencyRatesManager   = $this->getContainer()->get( 'weasty_money.official_currency.rates.manager' );

    $currencyResource = $this->getContainer()->get( 'weasty_money.currency.resource' );
    $defaultCurrency  = $currencyResource->getCurrency( $currencyResource->getDefaultCurrency() );

    $codes         = $input->getArgument( 'codes' ) ?: [ ];
    $upsertDefault = filter_var( $input->getOption( 'upsert-default' ), FILTER_VALIDATE_BOOLEAN );
    if ( $upsertDefault ) {
      $currencies = $currencyResource->getCurrencies();
    }
    else {
      $currencies = array_map(
        function ( $code ) use ( $currencyResource ) {
          return $currencyResource->getCurrency( $code );
        },
        $codes
      );
    }

    $output->writeln( "<info>Update official currency rates from remote</info>" );
    $officialCurrencyRatesManager->updateRepositoryFromRemote( $defaultCurrency->getAlphabeticCode() );

    /**
     * @var $currencies \Weasty\Money\Currency\CurrencyInterface[]
     */
    foreach ( $currencies as $currency ) {

      $output->writeln( "<info>Update currency rate {$currency->getName()}[{$currency->getAlphabeticCode()}]</info>" );

      /**
       * @var $currencyRate \Weasty\Bundle\MoneyBundle\Entity\CurrencyRate
       */
      $currencyRate = $currencyRateRepository->findOneBy(
        [
          'sourceAlphabeticCode'      => $currency->getAlphabeticCode(),
          'destinationAlphabeticCode' => $currencyResource->getDefaultCurrency(),
        ]
      );

      $officialCurrencyRate = $officialCurrencyRateRepository->findOneBy(
        [
          'sourceAlphabeticCode'      => $currency->getAlphabeticCode(),
          'destinationAlphabeticCode' => $currencyResource->getDefaultCurrency(),
        ]
      );
      if ( !$officialCurrencyRate instanceof OfficialCurrencyRate ) {
        $output->writeln( "<error>Official currency rate not found[{$currency->getAlphabeticCode()}]</error>" );
        continue;
      }

      if ( !$currencyRate ) {
        $currencyRate = $currencyRateRepository->create();
        $currencyRate->setSourceAlphabeticCode( $currency->getAlphabeticCode() );
        $currencyRate->setSourceNumericCode( $currency->getNumericCode() );
        $currencyRate->setDestinationAlphabeticCode( $defaultCurrency->getAlphabeticCode() );
        $currencyRate->setDestinationNumericCode( $defaultCurrency->getNumericCode() );
        $currencyRate->setRate( $officialCurrencyRate->getRate() );
        $em->persist( $currencyRate );
      }
      elseif ( $input->getOption( 'update-existing-from-official' ) || empty( $currencyRate->getRate() ) ) {
        $currencyRate->setRate( $officialCurrencyRate->getRate() );
      }

      $output->writeln( "<info>Currency rate {$currencyRate->getRate()} {$currency->getSymbol()}</info>" );

    }

    $em->flush();

  }

}