<?php
namespace Weasty\Bundle\MoneyBundle\Form\Type;

use Weasty\Money\Currency\CurrencyResource;

/**
 * Class CurrencyType
 * @package Weasty\Bundle\MoneyBundle\Form\Type
 */
class CurrencyType extends AbstractCurrencyType {

    /**
     * @return string
     */
    public function getName()
    {
        return 'weasty_money_currency';
    }

    /**
     * @return string
     */
    public function getCodeType()
    {
        return CurrencyResource::CODE_TYPE_ISO_4217_ALPHABETIC;
    }

} 