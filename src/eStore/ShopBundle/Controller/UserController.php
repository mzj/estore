<?php
/**
 * 
 */
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    eStore\ShopBundle\Entity\User,
    eStore\ShopBundle\Form\Admin\RegisterAdminType;

class UserController extends Controller
{
    /**
     *
     * @return type 
     */
    public function listAction()
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $users = $em->getRepository('eStoreShopBundle:User')->getUsersByRoles('ADMIN');
        
        return $this->render('eStoreShopBundle:User:list.html.twig', array( 'users' => $users ));

    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function newAction() 
    {
        $user = new User();
        $form = $this->container->get('admin.registration.form.type');
        $form   = $this->createForm($form, $user);

        return $this->render('eStoreShopBundle:User:new.html.twig', array(
            'user' => $user,
            'form'  => $form->createView()
        ));        
    }
    
    /**
     *
     * @return type 
     */
    public function createAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $request = $this->getRequest();
        $form = $this->container->get('admin.registration.form.type');
        $form = $this->createForm($form, $user);
        $form->bindRequest($request);
        
        $formValues = $request->get('fos_user_registration');
        $username = $formValues['username']; 
        $email = $formValues['email']; 
        $passwordFirst = $formValues['plainPassword']['first'];
        $role = $formValues['roles'];
        
        if ($form->isValid()) {
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPlainPassword($email);
            $user->setEnabled(true);
            $user->addRole($role);
            
            $userManager->updateUser($user);
            
            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_user_new'));
        }

        return $this->render('eStoreShopBundle:User:new.html.twig', array(
            'user' => $user,
            'form'  => $form->createView()
        ));  
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function deleteAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();
        $colour = $em->getRepository('eStoreShopBundle:Colour')->find($id);
        
        $em->remove($colour);
        $em->flush();
        
        $this->get('session')->setFlash('category-notice', 'Colour was removed successfully!');
        
        return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_colour_list'));
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function editAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();

        $colour = $em->getRepository('eStoreShopBundle:Colour')->find($id);
        if (!$colour) {
            throw $this->createNotFoundException('Unable to find colour entity.');
        }

        $editForm = $this->createForm(new ColourType(), $colour);
        
        return $this->render('eStoreShopBundle:Colour:edit.html.twig', array(
            'colour'  => $colour,
            'form'     => $editForm->createView()
        ));        
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function updateAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();

        $colour = $em->getRepository('eStoreShopBundle:Colour')->find($id);

        if (!$colour) {
            throw $this->createNotFoundException('Unable to find Colour entity.');
        }

        $editForm   = $this->createForm(new ColourType(), $colour);
        $request = $this->getRequest();
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($colour);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_colour_edit', array('id' => $id)));
        }

        return $this->render('eStoreShopBundle:Colour:edit.html.twig', array(
            'colour' => $colour,
            'form'    => $editForm->createView()
        ));        
    }
}
