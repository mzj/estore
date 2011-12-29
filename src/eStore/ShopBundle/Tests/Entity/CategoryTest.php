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
    
    public function testGetId()
    {
        $this->assertEquals(null, $this->category->getId());
    }
    
    public function testToString()
    {
        $this->assertEquals(null, $this->category->__toString());
        
        $this->category->setName('test');
        
        $this->assertEquals('test', $this->category->__toString());
    }
    
    public function testGetName()
    {
        $this->assertEquals(null, $this->category->getName());
    }
    
    public function testSetName()
    {
        $this->category->setName('test');
        $this->assertEquals('test', $this->category->getName());
    }
    
    public function testGetDescription()
    {
        $this->assertEquals(null, $this->category->getDescription());
    }
    
    public function testSetDescription()
    {
        $this->category->setDescription('Test description');
        $this->assertEquals('Test description', $this->category->getDescription());
    }
    
    public function testGetLvl()
    {
        $this->assertEquals(null, $this->category->getLvl());
    }
    
    public function testSetLvl()
    {
        $this->category->setLvl(3);
        $this->assertEquals(3, $this->category->getLvl());
    }
    
    public function testGetRoot()
    {
        $this->assertEquals(null, $this->category->getRoot());
    }
    
    public function testSetRoot()
    {
        $this->category->setRoot(2);
        $this->assertEquals(2, $this->category->getRoot());
    }
    
    public function testSetParent()
    {
        $parent = $this->category->getParent();
        $this->assertTrue(null === $parent);
        
        $mockCategory = $this->getMock('\eStore\ShopBundle\Entity\Category');
        $this->category->setParent($mockCategory);
        $parent = $this->category->getParent();
        $this->assertTrue($parent instanceOf \eStore\ShopBundle\Entity\Category);
        $this->assertFalse(null === $parent);
    }
    
    public function testAddCategory()
    {
        $children = $this->category->getChildren();
        $this->assertTrue($children instanceOf \Doctrine\Common\Collections\ArrayCollection);
        $this->assertTrue(0 === $children->count());
        
        $mockCategory = $this->getMock('\eStore\ShopBundle\Entity\Category');
        $this->category->addCategory($mockCategory);
        
        $children = $this->category->getChildren();
        $this->assertTrue(1 === $children->count());
    }
    
    public function testGetLft()
    {
        $this->assertEquals(null, $this->category->getLft());
    }
    
    public function testSetLft()
    {
        $this->category->setLft(4);
        $this->assertEquals(4, $this->category->getLft());
    }
    
    public function testGetRgt()
    {
        $this->assertEquals(null, $this->category->getRgt());
    }
    
    public function testSetRgt()
    {
        $this->category->setRgt(4);
        $this->assertEquals(4, $this->category->getRgt());
    }
    
    public function testGetSlug()
    {
        $this->assertEquals(null, $this->category->getSlug());
    }
    
    public function testSetSlug()
    {
        $this->category->setSlug('slug-test');
        $this->assertEquals('slug-test', $this->category->getSlug());
    }
    
    public function testAddProduct()
    {
        $products = $this->category->getProducts();
        $this->assertTrue($products instanceOf \Doctrine\Common\Collections\ArrayCollection);
        $this->assertTrue(0 === $products->count());
        
        $mockProduct = $this->getMock('\eStore\ShopBundle\Entity\Product');
        $this->category->addProduct($mockProduct);
        
        $products = $this->category->getProducts();
        $this->assertTrue(1 === $products->count());
    }
}