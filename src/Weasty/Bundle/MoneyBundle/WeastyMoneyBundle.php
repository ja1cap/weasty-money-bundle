<?php

namespace Weasty\Bundle\MoneyBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Weasty\Bundle\MoneyBundle\DependencyInjection\Compiler\CurrencyRateManagerPass;

/**
 * Class WeastyMoneyBundle
 * @package Weasty\Bundle\MoneyBundle
 */
class WeastyMoneyBundle extends Bundle
{
  /**
   * Builds the bundle.
   *
   * It is only ever called once when the cache is empty.
   *
   * This method can be overridden to register compilation passes,
   * other extensions, ...
   *
   * @param ContainerBuilder $container A ContainerBuilder instance
   */
  public function build(ContainerBuilder $container)
  {
    parent::build($container);
    $container->addCompilerPass( new CurrencyRateManagerPass() );
  }

}
