<?php
namespace eStore\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StoreControllerTest extends WebTestCase
{
    protected  $client;
    
    public function setUp()
    {
        $this->client = static::createClient();
    }
    
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(0, $crawler->filter('title:contains("404 Not Found")')->count());
        
        if ($profile = $this->client->getProfile()) {
            $queryNumber = $profile->getCollector('db')->getQueryCount();
            $exTime = $profile->getCollector('timer')->getTime();
            
            // check the number of requests
            $this->assertTrue($queryNumber < 10, 'Number of queries is ' . $queryNumber);
            // check the time spent in the framework
            $this->assertTrue( $exTime < 5, 'Execution time is ' . $exTime );
        }
    }
    
    public function testAbout()
    {
        $crawler = $this->client->request('GET', '/about');
        $this->assertEquals(0, $crawler->filter('title:contains("404 Not Found")')->count());
        
        if ($profile = $this->client->getProfile()) {
            $queryNumber = $profile->getCollector('db')->getQueryCount();
            $exTime = $profile->getCollector('timer')->getTime();
            
            // check the number of requests
            $this->assertTrue($queryNumber < 10, 'Number of queries is ' . $queryNumber);
            // check the time spent in the framework
            $this->assertTrue( $exTime < 5, 'Execution time is ' . $exTime );
        }
    }
    
    public function testContact()
    {
        $crawler = $this->client->request('GET', '/contact');
        $this->assertEquals(0, $crawler->filter('title:contains("404 Not Found")')->count());
        
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
