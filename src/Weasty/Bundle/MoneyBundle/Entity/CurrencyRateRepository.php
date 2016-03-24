<?php
namespace Weasty\Bundle\MoneyBundle\Entity;

use Weasty\Money\Entity\CurrencyRateRepository as BaseCurrencyRateRepository;

/**
 * Class CurrencyRateRepository
 * @package Weasty\Bundle\MoneyBundle\Entity
 */
class CurrencyRateRepository extends BaseCurrencyRateRepository {

  /**
   * @var \Weasty\Doctrine\Entity\AbstractRepository
   */
  protected $officialCurrencyRateRepository;

  /**
   * @param \Weasty\Doctrine\Entity\AbstractRepository $officialCurrencyRateRepository
   */
  public function setOfficialCurrencyRateRepository( $officialCurrencyRateRepository ) {
    $this->officialCurrencyRateRepository = $officialCurrencyRateRepository;
  }

  /**
   * @return \Weasty\Doctrine\Entity\AbstractRepository
   */
  protected function getOfficialCurrencyRepository() {
    if ( !$this->officialCurrencyRateRepository ) {
      $this->officialCurrencyRateRepository = $this->getEntityManager()->getRepository(
        'WeastyMoneyBundle:OfficialCurrencyRate'
      );
    }

    return $this->officialCurrencyRateRepository;
  }

} 