<?php

/*
 * This file is part of the eStore\ShopBundle
 *
 * src/eStore/ShopBundle/Tests/Controller
 */

namespace eStore\ShopBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase,
    eStore\ShopBundle\DataFixtures\ORM\UserFixtures;

/**
 * Functional tests for Category controller
 * 
 * @author: Marko Z. Jovanovic <markozjovanovic@gmail.com> 
 */
class CategoryControllerTest extends WebTestCase
{
    /**
     * @var Symfony\Bundle\FrameworkBundle\Client 
     */
    protected  $client;
    
    /**
     * Called before every test method
     * Loads fixtures and creates client
     */
    public function setUp()
    {
        $this->doLoadFixtures();
        $this->client = static::createClient();
    }
    
    /**
     * Test index action - return of products for given category id
     */
    public function testIndex()
    {        
        $crawler = $this->client->request('GET', '/category/2/test-slug');
        
        if ($profile = $this->client->getProfile()) {
            $queryNumber = $profile->getCollector('db')->getQueryCount();
            $exTime = $profile->getCollector('timer')->getTime();
            
            // check the number of requests
            $this->assertTrue($queryNumber < 10, 'Number of queries is ' . $queryNumber);
            // check the time spent in the framework
            $this->assertTrue( $exTime < 5, 'Execution time is ' . $exTime );
        }
        
        // checks to see if products is shown
        $this->assertTrue($crawler->filter('div:contains("Lionweight")')->count() > 0);
    }
    
    /**
     * Test listing of categories
     */
    public function testList()
    {
        $crawler = $this->client->request('GET', '/admin/categories/list');
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('legend:contains("Login Form")')->count() > 0);
        
        $form = $crawler->selectButton('Login')->form();

        $crawler = $this->client->submit(
            $form,
            array(
                '_username' => UserFixtures::USERNAME,
                '_password' => UserFixtures::PASSWORD
            )
        );

        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filterXpath('//tr[position()=8]/td')->text() == 'Pants');
    }
    
    /**
     * Test moving category down in tree hierarchy, using gedmo extensions 
     */
    public function testMoveUp()
    {
        $crawler = $this->client->request('GET', '/admin/categories/list');
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('legend:contains("Login Form")')->count() > 0);
        
        $form = $crawler->selectButton('Login')->form();

        $crawler = $this->client->submit(
            $form,
            array(
                '_username' => UserFixtures::USERNAME,
                '_password' => UserFixtures::PASSWORD
            )
        );

        $crawler = $this->client->followRedirect();
        $this->assertTrue($crawler->filterXpath('//tr[position()=8]/td')->text() == 'Pants');
        
        
        $crawler = $this->client->request('GET', '/admin/categories/move/down/9');
        
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('html:contains("Category was moved down successfully!")')->count() > 0);
        $this->assertTrue($crawler->filterXpath('//tr[position()=10]/td')->text() == 'Pants');
    }
    
    /**
     * Test moving category down in tree hierarchy, using gedmo extensions 
     */
    public function testMoveDown()
    {
        $crawler = $this->client->request('GET', '/admin/categories/list');
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('legend:contains("Login Form")')->count() > 0);
        
        $form = $crawler->selectButton('Login')->form();

        $crawler = $this->client->submit(
            $form,
            array(
                '_username' => UserFixtures::USERNAME,
                '_password' => UserFixtures::PASSWORD
            )
        );

        $crawler = $this->client->followRedirect();
        $this->assertTrue($crawler->filterXpath('//tr[position()=8]/td')->text() == 'Pants');
        
        
        $crawler = $this->client->request('GET', '/admin/categories/move/up/9');
        
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('html:contains("Category was moved up successfully!")')->count() > 0);
        $this->assertTrue($crawler->filterXpath('//tr[position()=7]/td')->text() == 'Pants');
    }
    
    /**
     * Test removing category
     */
    public function testDelete()
    {
        $crawler = $this->client->request('GET', '/admin/categories/list');
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('legend:contains("Login Form")')->count() > 0);
        
        $form = $crawler->selectButton('Login')->form();

        $crawler = $this->client->submit(
            $form,
            array(
                '_username' => UserFixtures::USERNAME,
                '_password' => UserFixtures::PASSWORD
            )
        );

        $crawler = $this->client->followRedirect();
        $this->assertTrue($crawler->filterXpath('//tr[position()=8]/td')->text() == 'Pants');
        
        
        $crawler = $this->client->request('GET', '/admin/categories/delete/9');
        
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('html:contains("Category was removed successfully!")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Pants")')->count() == 0);
    }
    
    /**
     * Test creating new category record
     */
    public function testCreateCategory()
    {
        $crawler = $this->client->request('GET', '/admin/categories/new');
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('legend:contains("Login Form")')->count() > 0);
        
        $form = $crawler->selectButton('Login')->form();

        $crawler = $this->client->submit(
            $form,
            array(
                '_username' => UserFixtures::USERNAME,
                '_password' => UserFixtures::PASSWORD
            )
        );

        $crawler = $this->client->followRedirect();
        
        $form = $crawler->selectButton('Create')->form();
        
        $crawler = $this->client->submit(
            $form,
            array(
                'estore_shopbundle_categorytype[name]' => 'TestCat',
                'estore_shopbundle_categorytype[description]' => 'Lorem ipsum'
            )
        );
        
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('html:contains("TestCat")')->count() > 0);
    }

    /**
     * Test editing existing category record
     */
    public function testEditCategory()
    {
        $crawler = $this->client->request('GET', '/admin/categories/edit/9');
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('legend:contains("Login Form")')->count() > 0);
        
        $form = $crawler->selectButton('Login')->form();

        $crawler = $this->client->submit(
            $form,
            array(
                '_username' => UserFixtures::USERNAME,
                '_password' => UserFixtures::PASSWORD
            )
        );

        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('html:contains("Pants")')->count() > 0);
        
        $form = $crawler->selectButton('Edit')->form();
        
        $crawler = $this->client->submit(
            $form,
            array(
                'estore_shopbundle_categorytype[name]' => 'TestCat',
                'estore_shopbundle_categorytype[description]' => 'Lorem ipsum'
            )
        );
        
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('html:contains("TestCat")')->count() > 0);
    }    
    
    /**
     * 
     */
    protected function doLoadFixtures()
    {
        // add all your doctrine fixtures classes
        $classes = array(
            // classes implementing Doctrine\Common\DataFixtures\FixtureInterface
            'eStore\ShopBundle\DataFixtures\ORM\UserFixtures',
            'eStore\ShopBundle\DataFixtures\ORM\CategoryFixtures',
            'eStore\ShopBundle\DataFixtures\ORM\ColourFixtures',
            'eStore\ShopBundle\DataFixtures\ORM\BrandFixtures',
            'eStore\ShopBundle\DataFixtures\ORM\ProductFixtures',
            'eStore\ShopBundle\DataFixtures\ORM\GarmentFixtures'
        );
        $this->loadFixtures($classes);
    }
}
