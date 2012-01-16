<?php

namespace eStore\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name')
                ->add('description')
                ->add('parent', 'entity',  
                        array(
                            'property' => 'indentName',
                            'class' => 'eStoreShopBundle:Category',
                            'query_builder' => function($er)
                                {
                                    return $er->createQueryBuilder('c')->orderBy('c.lft', 'ASC');
                                },
                             'multiple' => false
                        ));
    }

    public function getName()
    {
        return 'estore_shopbundle_categorytype';
    }
}