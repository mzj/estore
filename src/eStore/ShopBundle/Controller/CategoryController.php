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
        
        /*$tshirts    = new Category();
        $tshirts->setName('T-shirts');
        $shirts     = new Category();
        $shirts->setName('Shirts');
        $pants      = new Category();
        $pants->setName('Pants');
        $sweatshirt = new Category();
        $sweatshirt->setName('Sweatshirt');
        $vests      = new Category();
        $vests->setName('Vests');
        
        $hoodie = new Category();
        $hoodie->setName('Hoodie');
        $hoodie->setParent($sweatshirt);
        
        $em->persist($tshirts);
        $em->persist($shirts);
        $em->persist($pants);
        $em->persist($sweatshirt);
        $em->persist($vests);
        $em->persist($hoodie);
        $em->flush();*/
        
        /* $food = new Category();
        $food->setName('Food');

        $fruits = new Category();
        $fruits->setName('Fruits');
        $fruits->setParent($food);

        $vegetables = new Category();
        $vegetables->setName('Vegetables');
        $vegetables->setParent($food);

        $carrots = new Category();
        $carrots->setName('Carrots');
        $carrots->setParent($vegetables);

        $em->persist($food);
        $em->persist($fruits);
        $em->persist($vegetables);
        $em->persist($carrots);
        $em->flush();*/
    
        $cats = $repo->categoryMenu();
        exit(print_r($cats));
        
        /*$category = new Category();
        $category->setName('Ovo je mioj da jakatego tijna!');
        $em->persist($category);
        $em->flush();

        $slug = $category->getSlug();*/
        // prints: the-title-my-code
        
        return $this->render('eStoreShopBundle:Category:index.html.twig', array( 'slug' => $slug ));
        //return $this->render('eStoreShopBundle:Category:index.html.twig');
    }
}
