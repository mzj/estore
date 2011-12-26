<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use eStore\ShopBundle\Entity\Category;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use eStore\ShopBundle\Form\FilterType;
use FOS\RestBundle\View\View;

class ApiController extends Controller
{
    
    public function getProductsAction(Request $request)
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();       

        $query =  $em->getRepository('eStoreShopBundle:Product')
                     ->getPopularProducts();
        $pagedProducts = new Pagerfanta(new DoctrineORMAdapter($query));
        $pagedProducts->setMaxPerPage(2);

        try {
            $pagedProducts->setCurrentPage($request->query->get('page', 1));
        } catch(NotValidCurrentPageException $e) {
            throw $this->createNotFoundException('Page not found.');
        }
        
        $products = $pagedProducts->getCurrentPageResults();
        
        $view = View::create();
        
        if ('html' === $this->getRequest()->getRequestFormat()) {
            $view->setData(array('products' => $products));
        } else {
            $view->setData($products);
        }
        $view->setTemplate('eStoreShopBundle:Api:getProducts.html.twig');
        
        return $this->get('fos_rest.view_handler')->handle($view);
        
    }
    
    
    private function merge($arr1, $arr2)
    {
        array_splice($arr1, count($arr1), 0, $arr2);
        return $arr1;
    }
}