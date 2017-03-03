<?php
namespace Weasty\Bundle\MoneyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Weasty\Money\Currency\CurrencyResource;
use Weasty\Money\Entity\CurrencyRate;
use Weasty\Money\Manager\CurrencyRateManagerInterface;

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
     * @var CurrencyRateManagerInterface
     */
    protected $currencyRateManager;

    /**
     * @param \Weasty\Money\Currency\CurrencyResource $currencyResource
     * @param \Weasty\Money\Manager\CurrencyRateManagerInterface $currencyRateManager
     */
    function __construct(CurrencyResource $currencyResource, CurrencyRateManagerInterface $currencyRateManager)
    {
        $this->currencyResource = $currencyResource;
        $this->currencyRateManager = $currencyRateManager;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);


        $officialCurrencyRates = $this->currencyRateManager->getOfficialCurrencyRateManager()->getOfficialCurrencyRateRepository()->findAll();

        $resolver->setDefaults([
            'officialCurrencyRates' => $officialCurrencyRates,
        ]);

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
                'attr' => [
                    'ng-model' => 'currencyRate.sourceAlphabeticCode',
                ],
            ])
            ->add('destinationAlphabeticCode', 'hidden', [
                'label' => 'weasty.money.currency_rate.destination_alphabetic_code',
                'translation_domain' => 'WeastyMoneyBundle',
                'data' => $this->getCurrencyResource()->getDefaultCurrency(),
                'attr' => [
                    'ng-model' => 'currencyRate.destinationAlphabeticCode',
                ],
            ])
            ->add('updatableFromOfficial', 'checkbox', [
                'required' => false,
                'label' => 'weasty.money.currency_rate.updatable_form_official',
                'translation_domain' => 'WeastyMoneyBundle',
                'attr' => [
                    'ng-model' => 'currencyRate.updatableFromOfficial',
                    'ui-switch' => json_encode([
                        'color' => '#1AB394',
                        'size' => 'small',
                    ]),
                    'class' => 'js-switch',
                ],
                'label_attr' => [
                    'class' => 'p-none',
                ],
            ])
            ->add('rate', 'number', [
                'label' => 'weasty.money.currency_rate.value',
                'translation_domain' => 'WeastyMoneyBundle',
                'attr' => [
                    'ng-model' => 'currencyRate.rate',
                ],
            ])
            ->add('officialOffsetType', 'choice', [
                'label' => 'weasty.money.official_offset_type',
                'choices' => [
                    CurrencyRate::OFFICIAL_OFFSET_TYPE_PERCENT => 'weasty.money.official_offset_type.percent',
                    CurrencyRate::OFFICIAL_OFFSET_TYPE_VALUE => 'weasty.money.official_offset_type.value',
                ],
                'translation_domain' => 'WeastyMoneyBundle',
                'data' => CurrencyRate::OFFICIAL_OFFSET_TYPE_PERCENT,
                'attr' => [
                    'ng-model' => 'currencyRate.officialOffsetType',
                ],
            ])
            ->add('officialOffsetPercent', 'number', [
                'label' => 'weasty.money.official_offset_type.percent',
                'translation_domain' => 'WeastyMoneyBundle',
                'attr' => [
                    'ng-model' => 'currencyRate.officialOffsetPercent',
                ],
            ])
            ->add('officialOffsetValue', 'number', [
                'label' => 'weasty.money.official_offset_type.value',
                'translation_domain' => 'WeastyMoneyBundle',
                'attr' => [
                    'ng-model' => 'currencyRate.officialOffsetValue',
                ],
            ])
            ->add('finalRate', null, [
                'mapped' => false,
            ]);

        $builder
            ->add('save', 'submit', [
                'label' => 'Сохранить',
            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['attr']['ng-controller'] = 'currencyRate';
        $view->vars['attr']['ng-init'] = 'init(' . json_encode($view->vars['value']) . ',' . json_encode($options['officialCurrencyRates']) . ')';
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