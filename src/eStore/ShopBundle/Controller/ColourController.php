<?php
/**
 * 
 */
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    eStore\ShopBundle\Entity\Colour,
    eStore\ShopBundle\Form\ColourType;

class ColourController extends Controller
{
    /**
     *
     * @return type 
     */
    public function listAction()
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $colours = $em->getRepository('eStoreShopBundle:Colour')->findAll();
        
        return $this->render('eStoreShopBundle:Colour:list.html.twig', array( 'colours' => $colours ));

    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function newAction() 
    {
        $colour = new Colour();
        $form   = $this->createForm(new ColourType(), $colour);

        return $this->render('eStoreShopBundle:Colour:new.html.twig', array(
            'colour' => $colour,
            'form'  => $form->createView()
        ));        
    }
    
    /**
     *
     * @return type 
     */
    public function createAction()
    {
        $colour  = new Colour();
        $request = $this->getRequest();
        $form    = $this->createForm(new ColourType(), $colour);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($colour);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_colour_list', 
                    array('id' => $colour->getId())));
        }

        return $this->render('eStoreShopBundle:Colour:new.html.twig', array(
            'colour' => $colour,
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
