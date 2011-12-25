<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use eStore\ShopBundle\Entity\Category;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;

class StoreController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $query =  $em->getRepository('eStoreShopBundle:Product')
                     ->getPopularProducts();
        
        $pagedProducts = new Pagerfanta(new DoctrineORMAdapter($query));
        $pagedProducts->setMaxPerPage(5);

        try {
            $pagedProducts->setCurrentPage($request->query->get('page', 1));
        } catch(NotValidCurrentPageException $e) {
            throw $this->createNotFoundException();
        }

        return $this->render('eStoreShopBundle:Store:index.html.twig', array(
            'products' => $pagedProducts
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
    
    private function productsDataToArray($products) 
    {
        
        $productsArr = array();
        $productHolder = array();
        foreach($products as $product) {
            $productHolder['id'] = $product->getId();
            $productHolder['name'] = $product->getName();
            $productHolder['slug'] = $product->getSlug();
            
            $productHolder['categories'] = $this->categoriesDataToArray(
                            $product->getCategories()
                    );
            $productsArr[] = $productHolder;
        }
        return $productsArr;
    }
    
    private function categoriesDataToArray($categories) 
    {
        $categoriesArr = array();
        $categoryHolder = array();
        foreach($categories as $category) {
            $categoryHolder['id']  = $category->getId();
            $categoryHolder['name']  = $category->getName();
            $categoryHolder['slug']  = $category->getSlug();
            
            $categoriesArr[] = $categoryHolder;
        }
        
        return $categoriesArr;
    }
}
