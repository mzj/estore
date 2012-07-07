<?php

/*
 * This file is part of the eStore/ShopBundle
 *
 * Author: Marko Z. Jovanovic <markozjovanovic@gmail.com>
 *
 */

namespace eStore\ShopBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    protected  $client;
    
    public function setUp()
    {
        $this->client = static::createClient();
    }
    
    public function testIndex()
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
        
        $crawler = $this->client->request('GET', '/category/2/test-slug');
        
        if ($profile = $this->client->getProfile()) {
            $queryNumber = $profile->getCollector('db')->getQueryCount();
            $exTime = $profile->getCollector('timer')->getTime();
            
            // check the number of requests
            $this->assertTrue($queryNumber < 10, 'Number of queries is ' . $queryNumber);
            // check the time spent in the framework
            $this->assertTrue( $exTime < 5, 'Execution time is ' . $exTime );
        }
    
    }
}
