<?php
namespace eStore\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    protected  $client;
    
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @TODO Configure test enviroment to use sqlite3 for testing - with fixtures
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/category/17/test-slug');
        
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
