<?php
/**
 * File: eStore/ShopBundle/Entity/Contact.php
 * Desc: Contact form type
 * Author: markozjovanovic@gmail.com 
 * Date: Jan. 2012
 */

namespace eStore\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
        $builder->add('address');
        $builder->add('phone');
        $builder->add('email', 'email');
    }

    public function getName()
    {
        return 'customer';
    }
}