<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\View\DefaultView;
use eStore\ShopBundle\Entity\Category;
use eStore\ShopBundle\Entity\Product;
use eStore\ShopBundle\Form\ProductType;

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
    
    
    public function listAction($page)
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $queryP = $em->getRepository('eStoreShopBundle:Product')->getProducts();
        
        $pagedProducts = new Pagerfanta(new DoctrineORMAdapter($queryP));
        $pagedProducts->setMaxPerPage($this->container
                            ->getParameter('estore_shop.admin.products.max_per_page'));

        try {
            $pagedProducts->setCurrentPage($page);
        } catch(NotValidCurrentPageException $e) {
            throw $this->createNotFoundException('Page not found.');
        }
          
        // gets products collection for currnet page
        $products = $pagedProducts->getCurrentPageResults();
        
        $helper = $this;
        $routeGenerator = function($page) use ($helper) {
            $route = $helper->generateUrl('eStoreShopBundleAdmin_product_list', 
                    array('page' => $page));
            return $route;
        };
        
        $view = new DefaultView();
        $html = $view->render($pagedProducts, $routeGenerator, array(
            'proximity' => 3,
        ));
        
        return $this->render('eStoreShopBundle:Product:list.html.twig', array( 'products' => $products, 'pagerfanta' => $html ));
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function newAction() 
    {
        $product = new Product();
        $form   = $this->createForm(new ProductType(), $product);

        return $this->render('eStoreShopBundle:Product:new.html.twig', array(
            'product' => $product,
            'form'     => $form->createView()
        ));        
    }
    
    /**
     *
     * @return type 
     */
    public function createAction()
    {
        $product  = new Product();
        $request = $this->getRequest();
        $form    = $this->createForm(new ProductType(), $product);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($product);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_product_list', 
                    array('id' => $product->getId())));
        }

        return $this->render('eStoreShopBundle:Product:new.html.twig', array(
            'product' => $product,
            'form'     => $form->createView()
        ));  
    }
    
    public function deleteAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('eStoreShopBundle:Product')->find($id);
        
        $em->remove($product);
        $em->flush();
        
        $this->get('session')->setFlash('category-notice', 'Product was removed successfully!');
        
        return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_product_list'));
    }
    
        /**
     *
     * @param type $id
     * @return type 
     */
    public function editAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();

        $product = $em->getRepository('eStoreShopBundle:Product')->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createForm(new ProductType(), $product);
        
        return $this->render('eStoreShopBundle:Product:edit.html.twig', array(
            'product'    => $product,
            'edit_form'   => $editForm->createView()
        ));        
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function updateAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();

        $product = $em->getRepository('eStoreShopBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm   = $this->createForm(new ProductType(), $product);
        $request = $this->getRequest();
        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($product);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_product_edit', array('id' => $id)));
        }

        return $this->render('eStoreShopBundle:Product:edit.html.twig', array(
            'product'    => $product,
            'edit_form'   => $editForm->createView()
        ));        
    }
}
