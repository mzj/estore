<?php
namespace eStore\ShopBundle\Tests\Entity;

use eStore\ShopBundle\Entity\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $product = new Product();

        $this->assertEquals(null, $product->getName(),
                "Method getName in class/entity Product didn't return NULL.");
    }
    
    public function testSetName()
    {
        $product = new Product();
        $product->setName('test');
        $this->assertEquals('test', $product->getName(), 
                "Method setName didn't set up name.");
    }
    
    public function testGetDescription()
    {
        $product = new Product();

        $this->assertEquals(null, $product->getDescription(),
                "Method getDescription in class/entity Product didn't return NULL.");
    }
    
    public function testSetDescription()
    {
        $product = new Product();
        $product->setDescription('Test description');
        $this->assertEquals('Test description', $product->getDescription(), 
                "Method setDescription didn't set up description.");
    }
    
    public function testGetPrice()
    {
        $product = new Product();

        $this->assertEquals(null, $product->getPrice(),
                "Method getPrice in class/entity Product didn't return NULL.");
    }
    
    public function testSetPrice()
    {
        $product = new Product();
        $product->setPrice(100.22);
        $this->assertEquals(100.22, $product->getPrice(), 
                "Method setPrice didn't set up price.");
    }

    public function testGetImage()
    {
        $product = new Product();

        $this->assertEquals(null, $product->getImage(),
                "Method getImage in class/entity Product didn't return NULL.");
    }
    
    public function testSetImage()
    {
        $product = new Product();
        $product->setImage('image');
        $this->assertEquals('image', $product->getImage(), 
                "Method setImage didn't set up name.");
    }
    
    public function testGetSlug()
    {
        $product = new Product();

        $this->assertEquals(null, $product->getSlug(),
                "Method getSlug in class/entity Product didn't return NULL.");
    }
    
    public function testSetSlug()
    {
        $product = new Product();
        $product->setSlug('test-test-2');
        $this->assertEquals('test-test-2', $product->getSlug(), 
                "Method setSlug didn't set up slug.");
    }
    
    public function testGetCreated()
    {
        $product = new Product();

        $this->assertTrue(($product->getCreated() instanceOf \DateTime),
                "Method getCreated in class/entity Product didn't return DateTime obj.");
    }
    
    public function testSetCreated()
    {
        $product = new Product();
        $dt = new \DateTime();
        $product->setCreated($dt);
        $this->assertEquals($dt, $product->getCreated(), 
                "Method setCreated didn't set up created.");
        $this->assertTrue(($product->getCreated() instanceOf \DateTime),
                "Method getCreated in class/entity Product didn't return DateTime obj.");
    }
    
    public function testGetUpdated()
    {
        $product = new Product();

        $this->assertTrue(($product->getUpdated() instanceOf \DateTime),
                "Method getUpdated in class/entity Product didn't return DateTime obj.");
    }
    
    public function testSetUpdated()
    {
        $product = new Product();
        $dt = new \DateTime();
        $product->setUpdated($dt);
        $this->assertEquals($dt, $product->getUpdated(), 
                "Method setUpdated didn't set up created.");
        $this->assertTrue(($product->getUpdated() instanceOf \DateTime),
                "Method getUpdated in class/entity Product didn't return DateTime obj.");
    }
    
    public function testSetCreatedValue()
    {
        $product = new Product();
        $product->setCreated(null);
        $product->setUpdated(null);
        $product->setCreatedValue();
        $this->assertFalse(null === $product->getCreated());
        $this->assertFalse(null === $product->getUpdated());
        $this->assertTrue(($product->getCreated() instanceOf \DateTime));
        $this->assertTrue(($product->getUpdated() instanceOf \DateTime));
    }
    
    public function testSetUpdatedValue()
    {
        $product = new Product();
        $product->setCreated(null);
        $product->setUpdated(null);
        $product->setUpdatedValue();
        $this->assertTrue(null === $product->getCreated());
        $this->assertFalse(null === $product->getUpdated());
        $this->assertFalse(($product->getCreated() instanceOf \DateTime));
        $this->assertTrue(($product->getUpdated() instanceOf \DateTime));
    }
    
    public function testGetId()
    {
        $product = new Product();
        $this->assertTrue(null === $product->getId());
    }
    
    public function testToString()
    {
        $product = new Product();
        $this->assertTrue(($product->getCreated() instanceOf \DateTime));
        $product->setName('test');
        $this->assertTrue('test' == $product->__toString());
    }
    
    public function testAddCategory()
    {
        $product = new Product();
        $categories = $product->getCategories();
        
        $this->assertTrue($categories instanceOf \Doctrine\Common\Collections\ArrayCollection);
        $this->assertTrue(0 === $categories->count());
        
        $mockCategory = $this->getMock('\eStore\ShopBundle\Entity\Category');
        $product->addCategory($mockCategory);
        
        $this->assertTrue(1 === $categories->count());
    }
}