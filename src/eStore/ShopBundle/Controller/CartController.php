<?php
/**
 * 
 */
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\DependencyInjection\ContainerInterface,
    eStore\ShopBundle\Entity\Cart;

class CartController extends Controller
{
    
    /**
     *
     * @return type 
     */
    public function addToCartAction($id)
    {     
        $cart = $this->getCart();
        
        try {
            $cart->setProduct($id);
        } catch(\Exception $e) {}
        
        $this->saveCart($cart);
        
        return new Response($cart->getNbOfProducts(), 200, array('Content-Type' => 'text/plain'));
    }
    
    public function emptyCartAction() 
    {
        $session = $this->get( 'session' );
        $session->remove('cart');
        
        return new Response('ok', 200, array('Content-Type' => 'text/plain'));
    }
    
    public function removeFromCartAction($id)
    {
        $cart = $this->getCart();
        $cart->remove($id);
        $this->saveCart($cart);
        
        return new Response('ok', 200, array('Content-Type' => 'text/plain'));
    }


    public function getCart() 
    {
        $session = $this->container->get( 'session' );
        
        if($session->has('cart')) {
            $cart = unserialize($session->get('cart'));
        } else {
            $cart = new Cart();
        }
        
        return $cart;
    }
    
    public function saveCart($cart) 
    {
        $session = $this->get( 'session' );
        $session->set( 'cart', serialize($cart) );
    }
}
