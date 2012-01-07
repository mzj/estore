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
                             'class'=>'eStore\ShopBundle\Entity\Category',
                             'property'=>'indentName'
                            )
                      );
                //->add('parent');
    }

    public function getName()
    {
        return 'estore_shopbundle_filtertype';
    }
}