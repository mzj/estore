<?php
namespace eStore\ShopBundle\Tests\Entity;

use eStore\ShopBundle\Entity\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    protected  $product;
    
    public function setUp()
    {
        $this->product = new Product();
    }
    
    public function testGetName()
    {
        $this->assertEquals(null, $this->product->getName(),
                "Method getName in class/entity Product didn't return NULL.");
    }
    
    public function testSetName()
    {
        $this->product->setName('test');
        $this->assertEquals('test', $this->product->getName(), 
                "Method setName didn't set up name.");
    }
    
    public function testGetDescription()
    {
        $this->assertEquals(null, $this->product->getDescription(),
                "Method getDescription in class/entity Product didn't return NULL.");
    }
    
    public function testSetDescription()
    {
        $this->product->setDescription('Test description');
        $this->assertEquals('Test description', $this->product->getDescription(), 
                "Method setDescription didn't set up description.");
    }
    
    public function testGetPrice()
    {
        $this->assertEquals(null, $this->product->getPrice(),
                "Method getPrice in class/entity Product didn't return NULL.");
    }
    
    public function testSetPrice()
    {
        $this->product->setPrice(100.22);
        $this->assertEquals(100.22, $this->product->getPrice(), 
                "Method setPrice didn't set up price.");
    }

    public function testGetImage()
    {
        $this->assertEquals(null, $this->product->getImage(),
                "Method getImage in class/entity Product didn't return NULL.");
    }
    
    public function testSetImage()
    {
        $this->product->setImage('image');
        $this->assertEquals('image', $this->product->getImage(), 
                "Method setImage didn't set up name.");
    }
    
    public function testGetSlug()
    {
        $this->assertEquals(null, $this->product->getSlug(),
                "Method getSlug in class/entity Product didn't return NULL.");
    }
    
    public function testSetSlug()
    {
        $this->product->setSlug('test-test-2');
        $this->assertEquals('test-test-2', $this->product->getSlug(), 
                "Method setSlug didn't set up slug.");
    }
    
    public function testGetCreated()
    {
        $this->assertTrue(($this->product->getCreated() instanceOf \DateTime),
                "Method getCreated in class/entity Product didn't return DateTime obj.");
    }
    
    public function testSetCreated()
    {
        $dt = new \DateTime();
        $this->product->setCreated($dt);
        $this->assertEquals($dt, $this->product->getCreated(), 
                "Method setCreated didn't set up created.");
        $this->assertTrue(($this->product->getCreated() instanceOf \DateTime),
                "Method getCreated in class/entity Product didn't return DateTime obj.");
    }
    
    public function testGetUpdated()
    {
        $this->assertTrue(($this->product->getUpdated() instanceOf \DateTime),
                "Method getUpdated in class/entity Product didn't return DateTime obj.");
    }
    
    public function testSetUpdated()
    {
        $dt = new \DateTime();
        $this->product->setUpdated($dt);
        $this->assertEquals($dt, $this->product->getUpdated(), 
                "Method setUpdated didn't set up created.");
        $this->assertTrue(($this->product->getUpdated() instanceOf \DateTime),
                "Method getUpdated in class/entity Product didn't return DateTime obj.");
    }
    
    public function testSetCreatedValue()
    {
        $this->product->setCreated(null);
        $this->product->setUpdated(null);
        $this->product->setCreatedValue();
        $this->assertFalse(null === $this->product->getCreated());
        $this->assertFalse(null === $this->product->getUpdated());
        $this->assertTrue(($this->product->getCreated() instanceOf \DateTime));
        $this->assertTrue(($this->product->getUpdated() instanceOf \DateTime));
    }
    
    public function testSetUpdatedValue()
    {
        $this->product->setCreated(null);
        $this->product->setUpdated(null);
        $this->product->setUpdatedValue();
        $this->assertTrue(null === $this->product->getCreated());
        $this->assertFalse(null === $this->product->getUpdated());
        $this->assertFalse(($this->product->getCreated() instanceOf \DateTime));
        $this->assertTrue(($this->product->getUpdated() instanceOf \DateTime));
    }
    
    public function testGetId()
    {
        $this->assertTrue(null === $this->product->getId());
    }
    
    public function testToString()
    {
        $this->assertTrue(($this->product->getCreated() instanceOf \DateTime));
        $this->product->setName('test');
        $this->assertTrue('test' == $this->product->__toString());
    }
    
    public function testAddCategory()
    {
        $categories = $this->product->getCategories();
        
        $this->assertTrue($categories instanceOf \Doctrine\Common\Collections\ArrayCollection);
        $this->assertTrue(0 === $categories->count());
        
        $mockCategory = $this->getMock('\eStore\ShopBundle\Entity\Category');
        $this->product->addCategory($mockCategory);
        
        $categories = $this->product->getCategories();
        $this->assertTrue(1 === $categories->count());
    }
}