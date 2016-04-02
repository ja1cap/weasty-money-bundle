<?php
namespace Weasty\Bundle\MoneyBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Weasty\Money\Currency\Rate\UpdatableFromOfficialCurrencyRateInterface;

/**
 * Class CurrencyRateSubscriber
 * @package Weasty\Bundle\MoneyBundle\EventListener
 */
class CurrencyRateSubscriber implements EventSubscriber
{

  /**
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected $container;

  /**
   * CurrencyRateSubscriber constructor.
   * @param ContainerInterface $container
   */
  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  /**
   * Returns an array of events this subscriber wants to listen to.
   *
   * @return array
   */
  public function getSubscribedEvents()
  {
    return [
      'prePersist',
      'preUpdate',
    ];
  }

  /**
   * @param LifecycleEventArgs $args
   * @throws \Exception
   */
  public function prePersist(LifecycleEventArgs $args)
  {
    $this->update($args);
  }

  /**
   * @param LifecycleEventArgs $args
   * @throws \Exception
   */
  public function preUpdate(LifecycleEventArgs $args)
  {
    $this->update($args);
  }

  /**
   * @param LifecycleEventArgs $args
   */
  protected function update(LifecycleEventArgs $args)
  {
    $currencyRate = $args->getEntity();
    if (!$currencyRate instanceof UpdatableFromOfficialCurrencyRateInterface) {
      return;
    }
    $this->container->get('weasty_money.currency.rate.manager')->updateCurrencyFromOfficial($currencyRate);
  }

}