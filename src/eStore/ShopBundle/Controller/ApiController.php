<?php
/**
 * File: eStore/ShopBundle/Controller/ApiController.php
 * Desc: RESTFul Api controller - Uses FOSRestBundle for content negotiation
 * as well as serialization of the entities 
 * Author: markozjovanovic@gmail.com 
 * Date: Dec. 2011
 */

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
    /**
     * Returns paged collection of product entity, 
     * in one of the tree types - JSON, XML, HMTL. 
     * Depending on the requested format (by extension (or lack of one) in the url)
     * 
     * @param Request $request
     * @param int $page
     * @return Response 
     */
    public function getProductsAction(Request $request, $page)
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();       

        $query =  $em->getRepository('eStoreShopBundle:Product')
                     ->getPopularProducts();
        
        $pagedProducts = new Pagerfanta(new DoctrineORMAdapter($query));
        $pagedProducts->setMaxPerPage($this->container
                            ->getParameter('estore_shop.products.max_per_page'));

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