<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eStore\ShopBundle\Entity\Category;

class StoreController extends Controller
{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $products = $em->getRepository('eStoreShopBundle:Product')
                    ->getPopularProducts();

        return $this->render('eStoreShopBundle:Store:index.html.twig', array(
            'products' => $products
        ));
    }
    
    public function aboutAction()
    {
        return $this->render('eStoreShopBundle:Store:about.html.twig');
    }
    
    public function contactAction()
    {
        return $this->render('eStoreShopBundle:Store:contact.html.twig');
    }
    
    
    public function headerNavigationAction()
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();
        $repo = $em->getRepository('eStoreShopBundle:Category');

        $categories = $repo->categoryMenu($this);
        
        return $this->render('eStoreShopBundle:Store:headerNavigation.html.twig', array(
            'categories' => $categories
        ));
    }
    
    public function cartWidgetAction()
    {
        return $this->render('eStoreShopBundle:Store:cartWidget.html.twig');
    }
}
