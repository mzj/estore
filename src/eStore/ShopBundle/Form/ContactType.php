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

class ContactType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
        $builder->add('email', 'email');
        $builder->add('subject');
        $builder->add('body', 'textarea');
    }

    public function getName()
    {
        return 'contact';
    }
}