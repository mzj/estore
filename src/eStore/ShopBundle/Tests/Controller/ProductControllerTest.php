<?php
namespace eStore\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    protected  $client;
    
    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/1/test-slug');
        
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
