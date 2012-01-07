<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eStore\ShopBundle\Entity\Category;
use eStore\ShopBundle\Entity\Product;
use eStore\ShopBundle\Form\CategoryType;

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
        
        $categories = $repo->childrenQuery()->getArrayResult();
        
        unset($categories[0]);
        
        $categories = $this->buildTable($categories);
        
        
        
        return $this->render('eStoreShopBundle:Category:list.html.twig', array( 'categories' => $categories ));
    }
    
    
    public function moveDownAction($id)
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $category = $repo->find($id);
        
        if($repo->moveDown($category, 1)) {
            $this->get('session')->setFlash('category-notice', 'Category was moved down successfully!');
        }
        
        $em->clear();
        
        return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_category_list'));
    }
    
    
    public function moveUpAction($id)
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $category = $repo->find($id);
        
        if($repo->moveUp($category, 1)) {
            $this->get('session')->setFlash('category-notice', 'Category was moved up successfully!');
        }
        
        $em->clear();
        
        return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_category_list'));
    }
    
    
    public function deleteAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();
        $category = $em->getRepository('eStoreShopBundle:Category')->find($id);
        
        $em->remove($category);
        $em->flush();
        
        $this->get('session')->setFlash('category-notice', 'Category was removed successfully!');
        
        return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_category_list'));
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function newAction() 
    {
        $category = new Category();
        $form   = $this->createForm(new CategoryType(), $category);

        return $this->render('eStoreShopBundle:Category:new.html.twig', array(
            'category' => $category,
            'form'     => $form->createView()
        ));        
    }
    
    /**
     *
     * @return type 
     */
    public function createAction()
    {
        $category  = new Category();
        $request = $this->getRequest();
        $form    = $this->createForm(new CategoryType(), $category);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_category_edit', 
                    array('id' => $category->getId())));
        }

        return $this->render('eStoreShopBundle:Category:new.html.twig', array(
            'category' => $category,
            'form'     => $form->createView()
        ));  
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    public function editAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();

        $category = $em->getRepository('eStoreShopBundle:Category')->find($id);
        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $category);
        
        return $this->render('eStoreShopBundle:Category:edit.html.twig', array(
            'category'    => $category,
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

        $category = $em->getRepository('eStoreShopBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm   = $this->createForm(new CategoryType(), $category);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('eStoreShopBundleAdmin_category_edit', array('id' => $id)));
        }

        return $this->render('eStoreShopBundle:Category:edit.html.twig', array(
            'category'    => $category,
            'edit_form'   => $editForm->createView()
        ));        
    }

    public function buildTable($categories)
    {
        $table = '<table id="category-list">';
        $table .= '<caption>Category list</caption>';
        
        $i = 0;
        foreach($categories as $category) {
            if($i % 2 == 0) {
                $table .= '<tr class="darker">';
            } else {
                $table .= '<tr>';
            }
            $indent = str_repeat(' |— ', $category['lvl'] - 1);
            $table .= '<td>' . $indent . $category['name'] . '</td>';
            $table .= '<td>' . '<a href="' . $this->generateUrl('eStoreShopBundleAdmin_category_moveup',
                                    array('id' => $category['id'])) . '">' .
                    '<img src="/bundles/estoreshop/img/arrow-up.png" class="category-image"/> Up'
                    . '</a>';
            $table .= '<a href="' . $this->generateUrl('eStoreShopBundleAdmin_category_movedown',
                                    array('id' => $category['id'])) . '">' .
                    '<img src="/bundles/estoreshop/img/arrow-down.png" class="category-image"/> Down' 
                    . '</a></td>';
            $table .= '<td>' . 
                    '<a href="' . $this->generateUrl('eStoreShopBundleAdmin_category_edit',
                                    array('id' => $category['id'])) . '">' .
                    '<img src="/bundles/estoreshop/img/edit-gray.png" class="category-image"/> Edit</a>' 
                    . '</td>';
            $table .= '<td>' .
                    '<a href="' . $this->generateUrl('eStoreShopBundleAdmin_category_delete',
                                    array('id' => $category['id'])) . '">' .
                    '<img src="/bundles/estoreshop/img/delete-gray.png" class="category-image"/> Delete</a>' 
                    . '</td>';
            $table .= '</tr>';
            
            $i++;
        }
        
        return $table . '</table>';
    }
}
