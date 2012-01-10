<?php

namespace eStore\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use eStore\ShopBundle\Form\CategoryType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name')
                ->add('description')
                ->add('categories', 'entity',  
                        array(
                            'class' => 'eStoreShopBundle:Category',
                            'query_builder' => function($er)
                                {
                                    return $er->createQueryBuilder('c')->orderBy('c.lft', 'ASC');
                                },
                             'multiple' => true
                        ))
                ->add('price')
                ->add('file', 'file', array('required' => false));
    }

    public function getName()
    {
        return 'estore_shopbundle_producttype';
    }
}