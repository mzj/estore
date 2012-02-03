<?php
/**
 * File: eStore/ShopBundle/Tests/Controller/ApiController.php
 * Desc: Functional tests for ApiController 
 * Author: markozjovanovic@gmail.com 
 * Date: Dec. 2011
 */
namespace eStore\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Pagerfanta\Exception\NotValidCurrentPageException;


class ApiControllerTest extends WebTestCase
{
    protected  $client;
    
    /**
     * Setting up client before executing each individual test
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Testing getProductsAction if it really returns 
     * serialized entities in JSON format. 
     * As well as execution time and number of executed queries
     */
    public function testGetProductsJsonAction()
    {
        $crawler = $this->client->request('GET', '/api/products.json');
        $json = $this->client->getResponse()->getContent();
        $this->assertTrue($this->isJson($json), 
                "Requested json response, got something else");
        
        if ($profile = $this->client->getProfile()) {
            $queryNumber = $profile->getCollector('db')->getQueryCount();
            $exTime = $profile->getCollector('timer')->getTime();
            
            // Check the number of queries 
            // needs to be under 6 to pass the test
            $this->assertTrue($queryNumber <= 5, 'Number of queries is ' . $queryNumber);
            // Check the time spent in the framework 
            // needs to be under 5 sec. to pass the test
            $this->assertTrue($exTime < 5, 'Execution time is ' . $exTime);
        }
    }
    
    /**
     * Testing getProductsAction if it really returns 
     * serialized entities in XML format. 
     * As well as execution time and number of executed queries
     */
    public function testGetProductsXmlAction()
    {
        $crawler = $this->client->request('GET', '/api/products.xml');
        $xml = $this->client->getResponse()->getContent();
        $this->assertTrue($this->isXml($xml), 
                "Requested xml response, got something else");
        
        if ($profile = $this->client->getProfile()) {
            $queryNumber = $profile->getCollector('db')->getQueryCount();
            $exTime = $profile->getCollector('timer')->getTime();
            
            // Check the number of queries
            // needs to be under 6 to pass the test
            $this->assertTrue($queryNumber <= 5, 'Number of queries is ' . $queryNumber);
            // Check the time spent in the framework
            // needs to be under 6 to pass the test
            $this->assertTrue($exTime < 5, 'Execution time is ' . $exTime);
        }
    }
    
    /**
     * Check If page doesn't exists - show 404 error page
     */
    public function testExpectException() 
    {
        $crawler = $this->client->request('GET', '/api/products/99999999999999.html');
        $this->assertEquals(1, $crawler->filter('title:contains("404 Not Found")')->count());
    }
    
    /**
     * Check if given string is valid JSON
     * 
     * @param string $string
     * @return boolean 
     */
    protected function isJson($string) 
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    /**
     * Check if given string is valid XML
     * 
     * @param string $string
     * @return boolean 
     */
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
