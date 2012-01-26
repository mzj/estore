<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eStore\ShopBundle\Entity\Brand;
use eStore\ShopBundle\Form\BrandType;

class BrandController extends Controller
{
    public function listAction()
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $brands = $em->getRepository('eStoreShopBundle:Brand')->findAll();
        
        return $this->render('eStoreShopBundle:Brand:list.html.twig', array( 'brands' => $brands ));

    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function newAction() 
    {
        $brand = new Brand();
        $form   = $this->createForm(new BrandType(), $brand);

        return $this->render('eStoreShopBundle:Brand:new.html.twig', array(
            'brand' => $brand,
            'form'  => $form->createView()
        ));        
    }
    
    /**
     *
     * @return type 
     */
    public function createAction()
    {
        $brand  = new Brand();
        $request = $this->getRequest();
        $form    = $this->createForm(new BrandType(), $brand);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($brand);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_brand_list', 
                    array('id' => $brand->getId())));
        }

        return $this->render('eStoreShopBundle:Brand:new.html.twig', array(
            'brand' => $brand,
            'form'  => $form->createView()
        ));  
    }
    
    public function deleteAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();
        $brand = $em->getRepository('eStoreShopBundle:Brand')->find($id);
        
        $em->remove($brand);
        $em->flush();
        
        $this->get('session')->setFlash('category-notice', 'Brand was removed successfully!');
        
        return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_brand_list'));
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function editAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();

        $brand = $em->getRepository('eStoreShopBundle:Brand')->find($id);
        if (!$brand) {
            throw $this->createNotFoundException('Unable to find Brand entity.');
        }

        $editForm = $this->createForm(new BrandType(), $brand);
        
        return $this->render('eStoreShopBundle:Brand:edit.html.twig', array(
            'brand'  => $brand,
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

        $brand = $em->getRepository('eStoreShopBundle:Brand')->find($id);

        if (!$brand) {
            throw $this->createNotFoundException('Unable to find Brand entity.');
        }

        $editForm   = $this->createForm(new BrandType(), $brand);
        $request = $this->getRequest();
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($brand);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_brand_edit', array('id' => $id)));
        }

        return $this->render('eStoreShopBundle:Brand:edit.html.twig', array(
            'brand' => $brand,
            'form'    => $editForm->createView()
        ));        
    }
}
