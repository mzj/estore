<?php
/**
 * File: eStore/ShopBundle/Controller/AdminController.php
 * Desc: Admin controller - Index page
 * Author: markozjovanovic@gmail.com 
 * Date: Dec. 2011
 */
namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('eStoreShopBundle:Admin:index.html.twig');
    }
}