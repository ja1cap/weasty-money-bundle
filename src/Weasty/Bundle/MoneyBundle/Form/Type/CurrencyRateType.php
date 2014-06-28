<?php
namespace Weasty\Bundle\MoneyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Weasty\Money\Currency\CurrencyResource;

/**
 * Class CurrencyRateType
 * @package Weasty\Bundle\MoneyBundle\Form
 */
class CurrencyRateType extends AbstractType {

    /**
     * @var \Weasty\Money\Currency\CurrencyResource
     */
    protected $currencyResource;

    /**
     * @param \Weasty\Money\Currency\CurrencyResource $currencyResource
     */
    function __construct(CurrencyResource $currencyResource)
    {
        $this->currencyResource = $currencyResource;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('sourceAlphabeticCode', 'weasty_money_currency', array(
                'label' => 'Конвертируемая валюта',
            ))
            ->add('destinationAlphabeticCode', 'weasty_money_currency', array(
                'label' => 'Базовая валюта'
            ))
            ->add('rate', 'number', array(
                'label' => 'Курс конверсии'
            ))
        ;

        $builder
            ->add('save', 'submit', array(
                'label' => 'Сохранить',
            ));

    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'weasty_money_currency_rate';
    }

    /**
     * @return \Weasty\Money\Currency\CurrencyResource
     */
    public function getCurrencyResource()
    {
        return $this->currencyResource;
    }

} 