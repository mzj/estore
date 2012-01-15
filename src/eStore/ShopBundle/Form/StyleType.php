<?php

namespace eStore\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use eStore\ShopBundle\Entity\Style;

class StyleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('colour')
                ->add('size', 'choice', array(
                    'choices' => array(
                        Style::SIZE_SMALL => "Small",
                        Style::SIZE_MEDIUM => "Medium",
                        Style::SIZE_BIG => "Big"),
                    'expanded' => true)
                   );
    }

    public function getName()
    {
        return 'estore_shopbundle_styletype';
    }
}