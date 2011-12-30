<?php
namespace eStore\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Pagerfanta\Exception\NotValidCurrentPageException;

class ApiControllerTest extends WebTestCase
{
    protected  $client;
    
    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testGetProductsJsonAction()
    {
        $crawler = $this->client->request('GET', '/api/products/1.json');
        $json = $this->client->getResponse()->getContent();
        $this->assertTrue($this->isJson($json), 
                "Requested json response, got something else");
        
        if ($profile = $this->client->getProfile()) {
            $queryNumber = $profile->getCollector('db')->getQueryCount();
            $exTime = $profile->getCollector('timer')->getTime();
            
            // Check the number of requests
            $this->assertTrue($queryNumber <= 5, 'Number of queries is ' . $queryNumber);
            // Check the time spent in the framework
            $this->assertTrue($exTime < 5, 'Execution time is ' . $exTime);
        }
    }
    
    public function testGetProductsXmlAction()
    {
        $crawler = $this->client->request('GET', '/api/products/1.xml');
        $xml = $this->client->getResponse()->getContent();
        $this->assertTrue($this->isXml($xml), 
                "Requested xml response, got something else");
        
        if ($profile = $this->client->getProfile()) {
            $queryNumber = $profile->getCollector('db')->getQueryCount();
            $exTime = $profile->getCollector('timer')->getTime();
            
            // Check the number of requests
            $this->assertTrue($queryNumber <= 5, 'Number of queries is ' . $queryNumber);
            // Check the time spent in the framework
            $this->assertTrue($exTime < 5, 'Execution time is ' . $exTime);
        }
    }
    
    public function testExpectException() 
    {
        $crawler = $this->client->request('GET', '/api/products/99999999999999.html');
        $this->assertEquals(1, $crawler->filter('title:contains("404 Not Found")')->count());
    }
    
    protected function isJson($string) 
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    protected function isXml($string) 
    {
        libxml_use_internal_errors(true);
        $sxe = simplexml_load_string($string);
        if(!$sxe) {
            return false;
        }
        return true;
    }
}
