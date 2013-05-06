<?php
/**
 * 
 */
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    eStore\ShopBundle\Entity\Brand,
    eStore\ShopBundle\Form\BrandType;

class GarmentController extends Controller
{
    /**
     *
     * @param type $id
     * @return type 
     */
    public function deleteAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();
        $brand = $em->getRepository('eStoreShopBundle:Brand')->find($id);
        
        $em->remove($brand);
        $em->flush();
        
        $this->get('session')->setFlash('category-notice', 'Brand was removed successfully!');
        
        return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_brand_list'));
    }
}
