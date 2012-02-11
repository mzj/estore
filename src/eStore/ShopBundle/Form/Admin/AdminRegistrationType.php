<?php

namespace eStore\ShopBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class AdminRegistrationType extends BaseType
{
    private $roles_hierarchy;
    
    public function __construct($class, $roles_hierarchy = null)
    {
        parent::__construct($class);
        $this->roles_hierarchy = $roles_hierarchy;
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $roles = array_keys($this->roles_hierarchy);
        $roles = array_combine($roles, $roles);
        
        parent::buildForm($builder, $options);
        $builder
            ->add('roles', 'choice', array('choices' => $roles, 'property_path' => false));
    }
}