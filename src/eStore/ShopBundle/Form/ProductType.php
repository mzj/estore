<?php

namespace eStore\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use eStore\ShopBundle\Form\CategoryType;
use eStore\ShopBundle\Form\GarmentType;
use eStore\ShopBundle\Entity\Product;

class ProductType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name')
                ->add('code')
                ->add('active')
                ->add('description')
                ->add('categories', 'entity',  
                        array(
                            'property' => 'indentName',
                            'class' => 'eStoreShopBundle:Category',
                            'query_builder' => function($er)
                                {
                                    return $er->createQueryBuilder('c')->orderBy('c.lft', 'ASC');
                                },
                             'multiple' => true
                        ))
                ->add('price')
                ->add('gender', 'choice', array(
                    'choices' => array(
                        Product::GENDER_M => "Men's",
                        Product::GENDER_W => "Women's",
                        Product::GENDER_K => "Kid's",
                        Product::GENDER_U => "Uni's"),
                    'expanded' => true)
                   )
                ->add('file', 'file', array('required' => false))                           
            ->add('garments', 'collection', array(
             'type' => new GarmentType($this->pid),
                'by_reference' => false,
                 'allow_add' => true,
                    'prototype' => true
             ));
    }

    public function getName()
    {
        return 'estore_shopbundle_producttype';
    }
}