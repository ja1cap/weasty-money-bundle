<?php
namespace Weasty\Bundle\MoneyBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CurrencyType as BaseCurrencyType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Weasty\Money\Currency\Code\CurrencyCodeConverter;
use Weasty\Money\Currency\CurrencyResource;

/**
 * Class AbstractCurrencyType
 * @package Weasty\Bundle\MoneyBundle\Form\Type
 */
abstract class AbstractCurrencyType extends BaseCurrencyType {


    /**
     * @var \Weasty\Money\Currency\CurrencyResource
     */
    protected $currencyResource;

    /**
     * @var \Weasty\Money\Currency\Code\CurrencyCodeConverter
     */
    protected $currencyCodeConverter;

    function __construct(CurrencyResource $currencyResource, CurrencyCodeConverter $currencyCodeConverter)
    {
        $this->currencyResource = $currencyResource;
        $this->currencyCodeConverter = $currencyCodeConverter;
    }

    /**
     * @return string
     */
    abstract public function getCodeType();

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $choices = array();

        foreach($this->getCurrencyResource()->getCurrencies() as $alphabeticCode => $currency){
            $choices[$this->getCurrencyCodeConverter()->convert($alphabeticCode, $this->getCodeType(), CurrencyResource::CODE_TYPE_ISO_4217_ALPHABETIC)] = $currency;
        }

        $resolver->setDefaults(array(
            'choices' => $choices,
        ));

    }

    /**
     * @return \Weasty\Money\Currency\CurrencyResource
     */
    public function getCurrencyResource()
    {
        return $this->currencyResource;
    }

    /**
     * @return \Weasty\Money\Currency\Code\CurrencyCodeConverter
     */
    public function getCurrencyCodeConverter()
    {
        return $this->currencyCodeConverter;
    }

} 