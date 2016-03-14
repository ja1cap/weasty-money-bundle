<?php
namespace Weasty\Bundle\MoneyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Weasty\Bundle\MoneyBundle\Form\DataTransformer\ArrayToPriceTransformer;

/**
 * Class PriceType
 * @package Weasty\Bundle\MoneyBundle\Form\Type
 */
class PriceType extends AbstractType {

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'label' => false,
                'value_options' => array(
                    'label' => 'Цена',
                ),
                'currency_form_type' => 'weasty_money_currency',
                'currency_options' => array(
                    'label' => 'Валюта',
                ),
                'attr' => array(
                    'widget_col' => 12,
                ),
            ))
        ;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('value', 'text', $options['value_options'])
            ->add('currency', $options['currency_form_type'], $options['currency_options'])
        ;

        $builder->addViewTransformer(new ArrayToPriceTransformer(), true);

    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'weasty_money_price';
    }

} 