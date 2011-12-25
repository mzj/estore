<?php

namespace eStore\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('gender', 'choice', array(
                'choices' => array(
                    'm' => "Men's",
                    'w' => "Women's",
                    'k' => "Kid's"
                ),
                'required'    => true,
                'empty_value' => 'Choose gender type...',
                'empty_data'  => null
            ));
        
        $builder->add('sizes', 'choice', array(
                'choices' => array(
                     's' => "S",
                     'm' => "M",
                     'l' => "L",
                     'x' => "X",
                     'xl' => "XL",
                     'xxl' => "XXL"
                ),
                'required'    => true,
                'empty_value' => 'Choose size...',
                'empty_data'  => null
            ));
        
        $builder->add('subject');
        $builder->add('body', 'textarea');
    }

    public function getName()
    {
        return 'estore_shopbundle_filtertype';
    }
}