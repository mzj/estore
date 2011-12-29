<?php
namespace eStore\ShopBundle\Tests\Entity;

use eStore\ShopBundle\Entity\Category;

class CategoryTest extends \PHPUnit_Framework_TestCase
{
    protected  $category;
    
    public function setUp()
    {
        $this->category = new Category();
    }
    
    public function testGetName()
    {
        $this->assertEquals(null, $this->category->getName(),
                "Method getName in class/entity Category didn't return NULL.");
    }
    
    public function testSetName()
    {
        $this->category->setName('test');
        $this->assertEquals('test', $this->category->getName(), 
                "Method setName didn't set up name.");
    }
    
    public function testGetDescription()
    {
        $this->assertEquals(null, $this->category->getDescription(),
                "Method getDescription in class/entity Product didn't return NULL.");
    }
    
    public function testSetDescription()
    {
        $this->category->setDescription('Test description');
        $this->assertEquals('Test description', $this->category->getDescription(), 
                "Method setDescription didn't set up description.");
    }
}