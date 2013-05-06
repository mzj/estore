<?php

namespace eStore\ShopBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder,
    eStore\ShopBundle\Entity\Product;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('gender', 'choice', array(
                    'choices' => array(
                        Product::GENDER_M => "Men's",
                        Product::GENDER_W => "Women's",
                        Product::GENDER_K => "Kid's",
                        Product::GENDER_U => "Uni's"),
                    'expanded' => true, 
                    'property_path' => false)
                   )
                ->add('categories', 'entity',  
                        array(
                            'property' => 'indentNameFilter',
                            'class' => 'eStoreShopBundle:Category',
                            'query_builder' => function($er)
                                {
                                    return $er->createQueryBuilder('c')->orderBy('c.lft', 'ASC');
                                },
                             'multiple' => false
                        ))
                 ->add('colours', 'entity',  
                        array(
                            'property' => 'name',
                            'class' => 'eStoreShopBundle:Colour',
                            'multiple' => true,
                            'expanded' => true
                        ));
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
           'csrf_protection' => false
        );
    }
    
    public function getName()
    {
        return 'estore_shopbundle_filtertype';
    }
}