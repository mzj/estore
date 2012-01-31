<?php
/**
 * File: eStore/ShopBundle/Controller/ApiController.php
 * Desc: RESTFul Api controller - Uses FOSRestBundle for content negotiation
 * as well as serialization of the entities 
 * Author: markozjovanovic@gmail.com 
 * Date: Dec. 2011
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
    public function getProductsAction(Request $request)
    {
        $search = $request->query->get('search');
        $colours = $request->query->get('colours');
        $gender = $request->query->get('gender');
        $size = $request->query->get('size');
        $productsPerPage = $request->query->get('ppp');
        $orderByPrice = $request->query->get('obp');
        $priceLowest = $request->query->get('priceL');
        $priceHighest = $request->query->get('priceH');
        $page = $request->query->get('page');
        $page = $page ? $page : 1;
        
        $em = $this->getDoctrine()
                   ->getEntityManager();       

        $query =  $em->getRepository('eStoreShopBundle:Product')
                     ->getPopularProducts();
        
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
        $view->setData(array('products' => $products, 'pagerfanta' => array(
            'currentPage'  => $pagedProducts->getCurrentPage(),
            'nbPages'      => $pagedProducts->getNbPages(), 
            'nbResults'    => $pagedProducts->getNbResults(),
            )
          ));
        
        $view->setTemplate('eStoreShopBundle:Api:getProducts.html.twig');
        
        return $view;
    }
}