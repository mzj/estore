<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eStore\ShopBundle\Entity\Category;
use eStore\ShopBundle\Entity\Product;

class ProductController extends Controller
{
    
    public function indexAction($id, $slug)
    {       
        $em = $this->getDoctrine()
                   ->getEntityManager();
         
        $repo = $em->getRepository('eStoreShopBundle:Product');
        $product = $repo->find($id);
      
        return $this->render('eStoreShopBundle:Product:view.html.twig', array( 'product'=> $product ));
    }
    
    public function listAction()
    {       
        $em = $this->getDoctrine()->getEntityManager();

        $products = $em->getRepository('eStoreShopBundle:Product')->findAll();

        return $this->render('eStoreShopBundle:Product:list.html.twig', array( 'products' => $products ));
    }
}
