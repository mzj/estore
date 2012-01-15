<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\View\DefaultView;
use eStore\ShopBundle\Entity\Style;
use eStore\ShopBundle\Form\StyleType;
use eStore\ShopBundle\Entity\Garment;
use eStore\ShopBundle\Form\GarmentType;
use eStore\ShopBundle\Form\TestType;

class GarmentController extends Controller
{
    /**
     *
     * @param type $id
     * @return type 
     */
    public function newAction() 
    {
        /*$garment = new Garment();
        $form   = $this->createForm(new GarmentType(), $garment);

        return $this->render('eStoreShopBundle:Garment:new.html.twig', array(
            'garment' => $garment,
            'form'     => $form->createView()
        )); */
        
       // $test = new TestType();
        $form   = $this->createForm(new TestType());
        
        return $this->render('eStoreShopBundle:Garment:new.html.twig', array(
            'form'     => $form->createView()
        )); 
    }
    
    
    /**
     *
     * @return type 
     */
    public function createAction()
    {
        $garment  = new Garment();
        $request = $this->getRequest();
        $form    = $this->createForm(new GarmentType(), $garment);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($garment);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_garment_list'));
        }

        return $this->render('eStoreShopBundle:Garment:new.html.twig', array(
            'garment' => $garment,
            'form'     => $form->createView()
        ));  
    }
}