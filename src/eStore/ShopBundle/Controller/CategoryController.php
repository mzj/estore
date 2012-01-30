<?php
/**
 * 
 */
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    eStore\ShopBundle\Entity\Category,
    eStore\ShopBundle\Form\CategoryType;

/**
 * 
 */
class CategoryController extends Controller
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
         
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $category = $repo->find($id);
        $products = $repo->getAllProductsByCategory($category);
      
        return $this->render('eStoreShopBundle:Category:listProducts.html.twig', array( 'category'=> $category, 'products' => $products));
    }
    
    /**
     *
     * @return type 
     */
    public function listAction()
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $categories = $em->getRepository('eStoreShopBundle:Category')->getArrWithoutRoot();
        
        
        return $this->render('eStoreShopBundle:Category:list.html.twig', array( 'categories' => $categories ));
    }
    
    /**
     * 
     */
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
    
    /**
     * 
     */
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
    
    /**
     *
     * @param type $id
     * @return type 
     */
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
}
