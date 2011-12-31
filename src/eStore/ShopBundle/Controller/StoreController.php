<?php
/**
 * File: eStore/ShopBundle/Controller/StoreController.php
 * Desc: Store controller - Main pages, and navigation actions
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


class StoreController extends Controller
{
    /**
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new FilterType());

        return $this->render('eStoreShopBundle:Store:index.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * About route - About page
     * @return Response
     */
    public function aboutAction()
    {
        return $this->render('eStoreShopBundle:Store:about.html.twig');
    }
    
    /**
     * Contact route - Contact page
     * @return Response 
     */
    public function contactAction()
    {
        return $this->render('eStoreShopBundle:Store:contact.html.twig');
    }
    

    /**
     *
     * @return Response 
     */
    public function headerNavigationAction()
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $helper = $this;
        
        /**
         * Generate hierarchical categories menu
         * @todo refactor - it needs to be used in multiple places
         */
        $categories = $repo->childrenHierarchy(null, false, array('decorate' => true, 
                    'nodeDecorator' => function($node) use ($helper) {
                        return '<a href="' . $helper->generateUrl('eStoreShopBundle_category', 
                                array('id' => $node['id'],'slug' => $node['slug'])) . '">' 
                                . $node['name'] . '</a>';
                    })
                );
        
        return $this->render('eStoreShopBundle:Store:headerNavigation.html.twig', array(
            'categories' => $categories
        ));
    }
    
    /**
     *
     * @return Response 
     */
    public function cartWidgetAction()
    {
        return $this->render('eStoreShopBundle:Store:cartWidget.html.twig');
    }
}
