<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\View\DefaultView;
use eStore\ShopBundle\Entity\Style;
use eStore\ShopBundle\Form\StyleType;

class StyleController extends Controller
{
    /**
     *
     * @param type $id
     * @return type 
     */
    public function newAction() 
    {
        $style = new Style();
        $form   = $this->createForm(new StyleType(), $style);

        return $this->render('eStoreShopBundle:Style:new.html.twig', array(
            'style' => $style,
            'form'     => $form->createView()
        ));        
    }
    
    
    /**
     *
     * @return type 
     */
    public function createAction()
    {
        $style  = new Style();
        $request = $this->getRequest();
        $form    = $this->createForm(new StyleType(), $style);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($style);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_style_list', 
                    array('id' => $style->getId())));
        }

        return $this->render('eStoreShopBundle:Style:new.html.twig', array(
            'style' => $style,
            'form'     => $form->createView()
        ));  
    }
}
