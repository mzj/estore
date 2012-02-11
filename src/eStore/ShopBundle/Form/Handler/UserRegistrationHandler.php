<?php

namespace eStore\ShopBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;

class UserRegistrationHandler extends BaseHandler
{
    public function process($confirmation = false)
    {
        $user = $this->userManager->createUser();
        $this->form->setData($user);

        if ('POST' == $this->request->getMethod()) {
            $this->form->bindRequest($this->request);
            
            if ($this->form->isValid()) {
                //$form = $this->request->get('fos_user_registration_form');
               // $roles = $form['roles'];
               // $user->addRole($roles);
                
                //exit($roles);
                $this->onSuccess($user, $confirmation);
                return true;
            }
        }

        return false;
    }
}