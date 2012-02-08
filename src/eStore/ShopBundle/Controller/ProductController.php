<?php
/**
 * 
 */
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Pagerfanta\Exception\NotValidCurrentPageException,
    Pagerfanta\View\DefaultView,
    eStore\ShopBundle\Entity\Category,
    eStore\ShopBundle\Entity\Product,
    eStore\ShopBundle\Form\ProductType;

class ProductController extends Controller
{
    /**
     *
     * @param type $id
     * @param type $slug
     * @return type 
     */
    public function indexAction($id, $slug)
    {       
        $em = $this->getDoctrine()
                   ->getEntityManager();
         
        $repo = $em->getRepository('eStoreShopBundle:Product');
        $product = $repo->find($id);
      
        return $this->render('eStoreShopBundle:Product:view.html.twig', array( 'product'=> $product ));
    }
    
    /**
     *
     * @param Request $request
     * @param type $page
     * @param type $page
     * @return type 
     */
    public function listAction(Request $request, $page)
    {       
        $em = $this->getDoctrine()->getEntityManager();
        
        
        $term = $request->query->get('term');
        
        if($term !== null) {
            $queryP = $em->getRepository('eStoreShopBundle:Product')->getProductsWithTerm($term);
        } else {
            $queryP = $em->getRepository('eStoreShopBundle:Product')->getProducts();
        }
        
        $pagedProducts = new Pagerfanta(new DoctrineORMAdapter($queryP));
        $pagedProducts->setMaxPerPage($this->container
                            ->getParameter('estore_shop.admin.products.max_per_page'));

        try {
            $pagedProducts->setCurrentPage($page);
        } catch(NotValidCurrentPageException $e) {
            throw $this->createNotFoundException('Page not found.');
        }
          
        // get products collection for current page
        $products = $pagedProducts->getCurrentPageResults();
        
        $helper = $this;
        $routeGenerator = function($page) use ($helper, $term) {
            $params = $term ? array('page' => $page, 'term' => $term) : array('page' => $page);
            $route  = $helper->generateUrl('eStoreShopBundleAdmin_product_list', $params);
            return $route;
        };
        
        $view = new DefaultView();
        $html = $view->render($pagedProducts, $routeGenerator, array(
            'proximity' => 1,
            'previous_message' => "<img src='/bundles/estoreshop/img/arrow-left.png' />",
            'next_message' => "<img src='/bundles/estoreshop/img/arrow-right.png' />",
            'css_disabled_class' => 'pagerfanta-disabled',
            'css_dots_class' => 'pagerfanta-dots',
            'css_current_class' => 'pagerfanta-current'
        ));
        
        $response = $this->render('eStoreShopBundle:Product:list.html.twig', array( 'products' => $products, 'pagerfanta' => $html ));
        $response->setSharedMaxAge(30);
        
        return $response;
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

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_product_edit', 
                    array('id' => $product->getId())));
        }

        return $this->render('eStoreShopBundle:Product:new.html.twig', array(
            'product' => $product,
            'form'     => $form->createView()
        ));  
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
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
            'product'  => $product,
            'form'     => $editForm->createView()
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
            'product' => $product,
            'form'    => $editForm->createView()
        ));        
    }
}
