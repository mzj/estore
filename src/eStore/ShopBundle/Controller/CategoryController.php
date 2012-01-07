<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eStore\ShopBundle\Entity\Category;
use eStore\ShopBundle\Entity\Product;

class CategoryController extends Controller
{
    
    public function indexAction($id, $slug)
    {       
        $em = $this->getDoctrine()
                   ->getEntityManager();
         
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $category = $repo->find($id);
        $products = $repo->getAllProductsByCategory($category);
      
        return $this->render('eStoreShopBundle:Category:listProducts.html.twig', array( 'category'=> $category, 'products' => $products));
    }
    
    public function listAction()
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $helper = $this;
        
        $categories = $repo->childrenHierarchy(null, false, array('decorate' => true, 
                    'nodeDecorator' => function($node) use ($helper) {
                        return '<a href="' . $helper->generateUrl('eStoreShopBundle_category', 
                                array('id' => $node['id'],'slug' => $node['slug'])) . '">' 
                                . $node['name'] . '</a>'
                            . '<a href="' . $helper->generateUrl('eStoreShopBundleAdmin_category_movedown',
                                    array('id' => $node['id'])) . '">'
                                    . ' | down' . '</a>';
                    })
                );
        
        return $this->render('eStoreShopBundle:Category:list.html.twig', array( 'categories' => $categories ));
    }
    
    
    public function moveDownAction($id)
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $category = $repo->find($id);
        $repo->moveDown($category, true);
        $em->clear();
        return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_category_list'));
    }
}
