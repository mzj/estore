<?php

namespace eStore\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection,
    Gedmo\Mapping\Annotation as Gedmo,
    JMS\SerializerBundle\Annotation\ExclusionPolicy,
    JMS\SerializerBundle\Annotation\Exclude;
        
/**
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="eStore\ShopBundle\Repository\CategoryRepository")
 * @Gedmo\Tree(type="nested")
 * @ExclusionPolicy("none")
 */
class Category
{
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;
     
    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;
     
    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;
     
    /**
     * Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;
     
    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="cascade")
     */
    private $parent;
     
    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     * @Exclude
     */
    private $children;
    
    /**
     * @Gedmo\Slug(fields={"name", "id"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
     * @ORM\JoinTable(name="category_product",
     *   joinColumns={
     *     @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *   }
     * )
     * @Exclude
     */    
    private $products;
    
    
    private $indentName;
    private $indentNameFilter;
    
    
    
    public function __construct() 
    {
        $this->products = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return $this->name;
    }
    
    
    public function getIndentName()
    {
        $lvl = $this->getLvl();
        $indent = ($lvl >= 1) ? $lvl - 1 : $lvl;
        $name = $this->parent ? $this->getName() : '-- Without parent --';       
        
        return str_repeat(' |— ', $indent) . ' ' . $name;
    }
    
    public function getIndentNameFilter()
    {
        $lvl = $this->getLvl();
        $indent = ($lvl >= 1) ? $lvl - 1 : $lvl;
        $name = $this->parent ? $this->getName() : 'All Categories';       
        
        return str_repeat(' |— ', $indent) . ' ' . $name;
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }
    

    /**
     * Set lvl
     *
     * @param integer $lvl
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    /**
     * Get lvl
     *
     * @return integer 
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set root
     *
     * @param integer $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * Get root
     *
     * @return integer 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param eStore\ShopBundle\Entity\Category $parent
     */
    public function setParent(\eStore\ShopBundle\Entity\Category $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return eStore\ShopBundle\Entity\Category 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param eStore\ShopBundle\Entity\Category $children
     */
    public function addCategory(\eStore\ShopBundle\Entity\Category $children)
    {
        $this->children[] = $children;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
    }

    /**
     * Get lft
     *
     * @return integer 
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
    }

    /**
     * Get rgt
     *
     * @return integer 
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add products
     *
     * @param eStore\ShopBundle\Entity\Product $products
     */
    public function addProduct(\eStore\ShopBundle\Entity\Product $product)
    {
        $product->addCategory($this);
        $this->products[] = $product;
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    

}