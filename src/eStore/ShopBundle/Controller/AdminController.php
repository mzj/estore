<?php
/**
 * File: eStore/ShopBundle/Controller/StoreController.php
 * Desc: Store controller - Main pages, and navigation actions
 * Author: markozjovanovic@gmail.com 
 * Date: Dec. 2011
 */

namespace eStore\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use eStore\ShopBundle\Entity\Category;
use eStore\ShopBundle\Entity\Contact;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use eStore\ShopBundle\Form\FilterType;
use eStore\ShopBundle\Form\ContactType;


class AdminController extends Controller
{
    /**
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('eStoreShopBundle:Admin:index.html.twig');
    }
}