<?php

/*
 * This file is part of the eStore\ShopBundle
 *
 * @author: Marko Z. Jovanovic <markozjovanovic@gmail.com>
 */

namespace eStore\ShopBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    /**
     * Symfony client
     * 
     * @var Symfony\Bundle\FrameworkBundle\Client 
     */
    protected  $client;
    
    /**
     * Called before every test method
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
     * Test moving category down in tree hierarchy, using gedmo extensions 
     */
    public function testMoveDown()
    {
        $crawler = $this->client->request('GET', '/admin/categories/move/down/2');
        $crawler = $this->client->followRedirect();
        
        $this->assertTrue($crawler->filter('legend:contains("Login Form")')->count() > 0);
        
        $form = $crawler->selectButton('Login')->form();

        $crawler = $this->client->submit(
            $form,
            array(
                '_username' => 'okram666',
                '_password' => 'password'
            )
        );

        $crawler = $this->client->followRedirect();
        $crawler = $this->client->followRedirect();
        $this->assertTrue($crawler->filter('html:contains("Category was moved down successfully!")')->count() > 0);
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
