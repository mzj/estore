<?php
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use eStore\ShopBundle\Entity\Category;
use eStore\ShopBundle\Entity\Product;

class CategoryController extends Controller
{
    
    public function indexAction()
    {
        //$cat = new Category();
        
        $em = $this->getDoctrine()
                   ->getEntityManager();
         
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $category = $repo->find(23);
        
        
       // $product = $repo->find(26);
        
        /*$category1 = new Category();
        $category1->setName('Shirts');
        $category2 = new Category();
        $category2->setName('TShirts');
        $category3 = new Category();
        $category3->setName('Vests');
        $category4 = new Category();
        $category4->setName('Pants');
        
        $em->persist($category1);
        $em->persist($category2);
        $em->persist($category3);
        $em->persist($category4);
        $em->flush();*/
        
        
        $product = new Product();
        $product->setName('Bread');
        $product->setDescription('Breadsddf dfddf');
        $product->setPrice(100);
        $product->setImage('lime-t-shirt.png');
        $product->setCreated(new \DateTime());
        $product->setUpdated($product->getCreated());
        
        //$category->addProduct($product);
       // $em->persist($category);
        //$em->persist($product);
        //$em->flush();
        $product->addCategory($category);
        
        $em->persist($product);
        
        $em->flush();
    
        //$cats = $repo->categoryMenu();
        //exit(print_r($cats));
        
        /*$category = new Category();
        $category->setName('Ovo je mioj da jakatego tijna!');
        $em->persist($category);
        $em->flush();

        $slug = $category->getSlug();*/
        // prints: the-title-my-code
        exit('hello');
        //return $this->render('eStoreShopBundle:Category:index.html.twig', array( 'slug' => $slug ));
        //return $this->render('eStoreShopBundle:Category:index.html.twig');
    }
}
