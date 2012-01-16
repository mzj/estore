<?php
/**
 * 
 */
namespace eStore\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * eStore\ShopBundle\Entity\Product
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="eStore\ShopBundle\Repository\BrandRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Brand
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
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="brand")
     */
    private $products;
    
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add product
     *
     * @param eStore\ShopBundle\Entity\Product $products
     */
    public function addProduct(\eStore\ShopBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    }
    
    /**
     * Set products
     *
     * @param eStore\ShopBundle\Entity\Product $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
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