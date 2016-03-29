<?php
namespace Weasty\Bundle\MoneyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CurrencyRateManagerPass
 * @package Weasty\Bundle\MoneyBundle\DependencyInjection\Compiler
 */
class CurrencyRateManagerPass implements CompilerPassInterface
{
  /**
   * You can modify the container here before it is dumped to PHP code.
   *
   * @param ContainerBuilder $container
   *
   * @api
   */
  public function process(ContainerBuilder $container)
  {
    if (!$container->has('weasty_money.currency.rate.manager')) {
      return;
    }

    $definition = $container->findDefinition(
      'weasty_money.currency.rate.manager'
    );

    $taggedServices = $container->findTaggedServiceIds(
      'weasty_money.currency.rate.repository'
    );
    foreach ($taggedServices as $id => $tags) {
      $definition->addMethodCall(
        'addCurrencyRateRepository',
        [new Reference($id)]
      );
    }
  }

}