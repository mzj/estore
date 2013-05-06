<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    eStore\ShopBundle\Form\CustomerType,
    eStore\ShopBundle\Entity\Customer,
    eStore\ShopBundle\Entity\Order;

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
        $customer = new Customer(); 
        
        $cform = $this->createForm(new CustomerType(), $customer);
        
        $req = $this->getRequest();
        $cartC = $this->get('estore_shop.cart.controller');
        $cart = $cartC->getCart();
        
        $productsIds  = $cart->getProductsIds();     
        
        foreach($productsIds as $pid) {
            $quantity = $req->get($pid) >= 1 ? $req->get($pid) : 1;
            $cart->setQuantity($pid, $quantity);
        }
        $cartC->saveCart($cart);
        
        $em = $this->getDoctrine()
                   ->getEntityManager();
         
        $repo = $em->getRepository('eStoreShopBundle:Product');
        $products = $repo->getProductById($productsIds);
        
        return $this->render('eStoreShopBundle:Order:status.html.twig', array(
                'products' => $products,
                'cart' => $cart,
                'cform' => $cform->createView()
            ));
    }
    
    /**
     * 
     */
    public function orderAction()
    {
        $customer  = new Customer();
        $request = $this->getRequest();
        $form    = $this->createForm(new CustomerType(), $customer);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($customer);
            
            $cartC = $this->get('estore_shop.cart.controller');
            $cart = $cartC->getCart();
            
            $products  = $cart->getProducts();     

            foreach($products as $pid => $quantity) {
                $repo = $em->getRepository('eStoreShopBundle:Product');
                $product = $repo->find($pid);
                
                $order = new Order();
                $order->setQuantity($quantity);
                $order->setProduct($product);
                $order->setCustomer($customer);
                
                $em->persist($order);
            }
            
            $em->flush();
            $this->get('session')->setFlash(
                'notice',
                'Your order was saved!'
            );
            $cartC->emptyCartAction();
            return $this->redirect($this->generateUrl('eStoreShopBundle_home'));
        }

        $this->get('session')->setFlash(
                'notice',
                'There were some problems with your order!'
            );
        return $this->redirect($this->generateUrl('eStoreShopBundle_orderStatus'));
    }
}

?>
