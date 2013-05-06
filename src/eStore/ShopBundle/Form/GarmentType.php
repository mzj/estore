<?php

namespace eStore\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use eStore\ShopBundle\Entity\Style;
use eStore\ShopBundle\Entity\Garment;

class GarmentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
                
        $builder->add('colours', 'entity',  
                        array(
                            'property' => 'name',
                            'class' => 'eStoreShopBundle:Colour',
                            'query_builder' => function($er)
                                {
                                    return $er->createQueryBuilder('c')->orderBy('c.id', 'ASC');
                                },
                             'multiple' => true,
                             'expanded' => true
                        ))
                ->add('size', 'choice', array(
                            'choices' => array(
                                Garment::SIZE_SMALL => "Small",
                                Garment::SIZE_MEDIUM => "Medium",
                                Garment::SIZE_BIG => "Big"
                            ),
                    'expanded' => true)
                   )
                ->add('quantity');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'eStore\ShopBundle\Entity\Garment',
        );
    }
    
    public function getName()
    {
        return 'estore_shopbundle_garmenttype';
    }
}