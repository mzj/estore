<?php
/**
 * 
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

/**
 * 
 */
class ApiController extends Controller
{
    /**
     *
     * @param Request $request
     * @param type $page
     * @return Response 
     */
    public function getProductsAction(Request $request, $page)
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();       

        $query =  $em->getRepository('eStoreShopBundle:Product')
                     ->getPopularProducts();
        $pagedProducts = new Pagerfanta(new DoctrineORMAdapter($query));
        $pagedProducts->setMaxPerPage(2);

        try {
            $pagedProducts->setCurrentPage($page);
        } catch(NotValidCurrentPageException $e) {
            throw $this->createNotFoundException('Page not found.');
        }
        
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