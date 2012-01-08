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


class StoreController extends Controller
{
    /**
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new FilterType());

        return $this->render('eStoreShopBundle:Store:index.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * About route - About page
     * @return Response
     */
    public function aboutAction()
    {
        return $this->render('eStoreShopBundle:Store:about.html.twig');
    }
    
    /**
     * Contact route - Contact page
     * @return Response 
     */
    public function contactAction()
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType());

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from estore.com')
                    ->setFrom('contact@estore.com')
                    ->setTo($this->container->getParameter('estore_shop.emails.contact_email'))
                    ->setBody($this->renderView('eStoreShopBundle:Store:contactEmail.txt.twig', array('contact' => $contact)));
                $this->get('mailer')->send($message);

                $this->get('session')->setFlash('estore-notice', 'Your contact data was successfully sent. Thank you!');

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('eStoreShopBundle_contact'));
            }
        }
        return $this->render('eStoreShopBundle:Store:contact.html.twig', 
                    array('form' => $form->createView())
               );
    }
    

    /**
     *
     * @return Response 
     */
    public function headerNavigationAction()
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();
        $repo = $em->getRepository('eStoreShopBundle:Category');
        $categories = $repo->getArrWithoutRoot();
        $helper = $this;
        
        /**
         * Generate hierarchical categories menu with unorderd list
         */
        $categories = $repo->buildTree($categories, array('decorate' => true, 
                    'nodeDecorator' => function($node) use ($helper) {
                        return '<a href="' . $helper->generateUrl('eStoreShopBundle_category', 
                                array('id' => $node['id'],'slug' => $node['slug'])) . '">' 
                                . $node['name'] . '</a>';
                    })
                );
        
        return $this->render('eStoreShopBundle:Store:headerNavigation.html.twig', array(
            'categories' => $categories
        ));
    }
    
    /**
     *
     * @return Response 
     */
    public function cartWidgetAction()
    {
        return $this->render('eStoreShopBundle:Store:cartWidget.html.twig');
    }
}
