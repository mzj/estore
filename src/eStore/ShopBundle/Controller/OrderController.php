<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Description of OrderController
 *
 * @author Marko
 */
class OrderController extends Controller
{
    /**
     * See the status of cart - submit button goes to real order action
     */
    public function orderStatusAction()
    {
        $req = $this->getRequest();
        $cartC = $this->get('estore_shop.cart.controller');
        $cart = $cartC->getCart();
        
        $productsIds  = $cart->getProductsIds();     
        
        foreach($productsIds as $pid) {
            $quantity = $req->get($pid);
            $cart->setQuantity($pid, $quantity);
        }
        $cartC->saveCart($cart);
        
        $em = $this->getDoctrine()
                   ->getEntityManager();
         
        $repo = $em->getRepository('eStoreShopBundle:Product');
        $products = $repo->getProductById($productsIds);
        
        return $this->render('eStoreShopBundle:Order:status.html.twig', array(
                'products' => $products,
                'cart' => $cart
            ));
    }
    
    /**
     * 
     */
    public function orderAction()
    {
        
    }
}

?>
