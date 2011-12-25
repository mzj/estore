<?php

namespace eStore\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        
    }

    public function getName()
    {
        return 'estore_shopbundle_producttype';
    }
}