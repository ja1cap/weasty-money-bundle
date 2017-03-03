<?php
namespace Weasty\Bundle\MoneyBundle\Price;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Weasty\Bundle\CommonBundle\Serializer\SerializerAwareInterface;
use Weasty\Money\Price\Price as BasePrice;

/**
 * Class Price
 * @package Weasty\Bundle\MoneyBundle\Price
 */
class Price extends BasePrice implements SerializerAwareInterface
{

    /**
     * @param ContainerInterface $container
     * @return \Weasty\Money\Serializer\PriceSerializer
     */
    public function getSerializer(ContainerInterface $container)
    {
        return $container->get('weasty_money.serializer.price');
    }

}