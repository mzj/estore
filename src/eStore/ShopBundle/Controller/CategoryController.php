<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eStore\ShopBundle\Entity\Category;
use eStore\ShopBundle\Entity\Product;

class CategoryController extends Controller
{
    
    public function indexAction($id, $slug)
    {       
        $em = $this->getDoctrine()
                   ->getEntityManager();
         
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $category = $repo->find($id);
        $products = $repo->getAllProducts($category);
      
        return $this->render('eStoreShopBundle:Category:listProducts.html.twig', array( 'category'=> $category, 'products' => $products));
    }
}
