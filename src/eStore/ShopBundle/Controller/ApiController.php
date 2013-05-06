<?php
/**
 * File: eStore/ShopBundle/Controller/ApiController.php
 * Desc: RESTFul Api controller - Uses FOSRestBundle for content negotiation
 * as well as serialization of the entities 
 * Author: markozjovanovic@gmail.com 
 * Date: Aug. 2012
 */

namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Pagerfanta\Exception\NotValidCurrentPageException,
    eStore\ShopBundle\Form\FilterType,
    FOS\RestBundle\View\View;


class ApiController extends Controller
{
    /**
     * Returns paged collection of product entity, 
     * in one of the tree formats - JSON, XML, HMTL. 
     * Depending on the requested format (by extension (or lack of one) in the url)
     * 
     * @param Request $request
     * @param int $page
     * @return Response 
     */
    public function getProductsAction()
    {
        $productsPerPage = $this->getParam('ppp');
        $page = $this->getPage();
        
        $params = array(
                'search'          => $this->getParam('search'), 
                'colours'         => $this->getParam('colours'), 
                'gender'          => $this->getParam('gender'), 
                'size'            => $this->getParam('size'), 
                'orderByPrice'    => $this->getParam('obp'), 
                'priceMin'        => $this->getParam('minprice'), 
                'priceMax'        => $this->getParam('maxprice'), 
                'category'        => $this->getParam('category'), 
                'productsPerPage' => $productsPerPage, 
                'page'            => $page,
            );
        
        $em = $this->getDoctrine()
                   ->getEntityManager();       

        $query =  $em->getRepository('eStoreShopBundle:Product')
                     ->getProductsForApi($params);
        
        $pagedProducts = new Pagerfanta(new DoctrineORMAdapter($query));
        $pagedProducts->setMaxPerPage($productsPerPage);

        try {
            $pagedProducts->setCurrentPage($page);
        } catch(NotValidCurrentPageException $e) {
            throw $this->createNotFoundException('Page not found.');
        }
        
        // gets products collection for currnet page
        $products = $pagedProducts->getCurrentPageResults();
        
        $view = View::create();
        $view->setData(array(
            'products' => $products,
            'cart' => $this->getCartProducts(),
            'pagerfanta' => array(
                'currentPage' => $pagedProducts->getCurrentPage(),
                'nbPages'     => $pagedProducts->getNbPages(),
                'nbResults'   => $pagedProducts->getNbResults()
            )
          ));
        
        $view->setTemplate('eStoreShopBundle:Api:getProducts.html.twig');
        
        return $view;
    }
    
    /**
     * 
     */
    private function getParam($paramName) 
    {
        $request = $this->getRequest();
        
        return $request->query->get($paramName);
    }
    
    /**
     * Get current page - fallback on 1
     * 
     * @return int
     */
    private function getPage()
    {
        $page = $this->getParam('page');
        $page = $page ? $page : 1;
        
        return $page;
    }
    
    /**
     * 
     */
    private function getCartProducts()
    {
        $cartCont = $this->container->get('estore_shop.cart.controller');
        $cart = $cartCont->getCart();
        
        return $cart->getProductsIds(); 
    }
}