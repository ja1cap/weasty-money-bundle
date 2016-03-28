<?php
namespace Weasty\Bundle\MoneyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Weasty\Money\Currency\CurrencyResource;
use Weasty\Money\Entity\CurrencyRate;

/**
 * Class CurrencyRateType
 * @package Weasty\Bundle\MoneyBundle\Form
 */
class CurrencyRateType extends AbstractType
{

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
      ->add('sourceAlphabeticCode', 'weasty_money_currency', [
        'label' => 'weasty.money.currency_rate.source_alphabetic_code',
        'translation_domain' => 'WeastyMoneyBundle',
      ])
      ->add('destinationAlphabeticCode', 'hidden', [
        'label' => 'weasty.money.currency_rate.destination_alphabetic_code',
        'translation_domain' => 'WeastyMoneyBundle',
        'data' => $this->getCurrencyResource()->getDefaultCurrency(),
      ])
      ->add('updatableFromOfficial', 'checkbox', [
        'label' => 'weasty.money.currency_rate.updatable_form_official',
        'translation_domain' => 'WeastyMoneyBundle',
        'attr' => [
          'ui-switch' => json_encode([
            'color' => '#1AB394',
            'size' => 'small',
          ]),
          'class' => 'js-switch',
        ]
      ])
      ->add('rate', 'number', [
        'label' => 'weasty.money.currency_rate.value',
        'translation_domain' => 'WeastyMoneyBundle',
      ])
      ->add('officialOffsetType', 'choice', [
        'label' => 'weasty.money.official_offset_type',
        'choices' => [
          CurrencyRate::OFFICIAL_OFFSET_TYPE_PERCENT => 'weasty.money.official_offset_type.percent',
          CurrencyRate::OFFICIAL_OFFSET_TYPE_VALUE => 'weasty.money.official_offset_type.value',
        ],
        'translation_domain' => 'WeastyMoneyBundle',
        'data' => CurrencyRate::OFFICIAL_OFFSET_TYPE_PERCENT,
      ])
      ->add('officialOffsetPercent', null, [
        'label' => 'weasty.money.official_offset_type.percent',
        'translation_domain' => 'WeastyMoneyBundle',
      ])
      ->add('officialOffsetValue', null, [
        'label' => 'weasty.money.official_offset_type.value',
        'translation_domain' => 'WeastyMoneyBundle',
      ]);

    $builder
      ->add('save', 'submit', [
        'label' => 'Сохранить',
      ]);

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