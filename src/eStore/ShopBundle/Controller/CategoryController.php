<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eStore\ShopBundle\Entity\Category;

class CategoryController extends Controller
{
    
    public function indexAction()
    {
        //$cat = new Category();
        
        $em = $this->getDoctrine()
                   ->getEntityManager();
         
        $repo = $em->getRepository('eStoreShopBundle:Category');
        
        /*$food = new Category();
        $food->setName('Food');

        $fruits = new Category();
        $fruits->setName('Fruits');

        $vegetables = new Category();
        $vegetables->setName('Vegetables');

        $carrots = new Category();
        $carrots->setName('Carrots');

        $treeRepository
            ->persistAsFirstChild($food)
            ->persistAsFirstChildOf($fruits, $food)
            ->persistAsLastChildOf($vegetables, $food)
            ->persistAsNextSiblingOf($carrots, $fruits);

        $em->flush();
        ///$repo = $em->getRepository('eStoreShopBundle:Category');*/
    
        $food = $repo->findOneByName('Food');
        
        return $this->render('eStoreShopBundle:Category:index.html.twig', array( 'countt' => $repo->childCount($food, true) ));
    }
}
