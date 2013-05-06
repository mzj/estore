<?php
/**
 * 
 */
namespace eStore\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * eStore\ShopBundle\Entity\Garment
 *
 * @ORM\Table(name="garment")
 * @ORM\Entity(repositoryClass="eStore\ShopBundle\Repository\GarmentRepository")
 */
class Garment
{
    const SIZE_SMALL = 1;
    const SIZE_MEDIUM = 2;
    const SIZE_BIG = 3;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * ORM\ManyToOne(targetEntity="Style", inversedBy="garments")
     */
    private $style;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Colour")
     * @ORM\JoinTable(
     *   joinColumns={
     *     @ORM\JoinColumn(name="garment_id", referencedColumnName="id", onDelete="cascade")
     *   }
     * )
     */
    private $colours;
    
    /**
     * @ORM\Column(name="size", type="integer")
     */
    private $size;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="garments")
     */
    private $product;
    
    /**
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;
    
    /**
     * ORM\OneToMany(targetEntity="Order", mappedBy="garment")
     */
    private $orders;
    
    
    public function __construct()
    {
        $this->colours = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set style
     *
     * @param eStore\ShopBundle\Entity\Style $style
     */
    public function setStyle(\eStore\ShopBundle\Entity\Style $style)
    {
        $this->style = $style;
    }

    /**
     * Get style
     *
     * @return eStore\ShopBundle\Entity\Style 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set product
     *
     * @param eStore\ShopBundle\Entity\Product $product
     */
    public function setProduct(\eStore\ShopBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return eStore\ShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
    
    
        /**
     * Set size
     *
     * @param integer $size
     */
    public function setSize($size)
    {
        if (!in_array($size, array(self::SIZE_SMALL, self::SIZE_MEDIUM, self::SIZE_BIG))) {
            throw new \InvalidArgumentException("Invalid size value");
        }
        
        $this->size = $size;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Add colour
     *
     * @param eStore\ShopBundle\Entity\Colour $colour
     */
    public function addColour(\eStore\ShopBundle\Entity\Colour $colour)
    {
        $this->colours[] = $colour;
    }
    
    /**
     * Add categories
     *
     * @param eStore\ShopBundle\Entity\Category $categories
     */
    public function addOrder(\eStore\ShopBundle\Entity\Order $order)
    {
        //$category->addProduct($this);
        $this->orders[] = $order;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }
    
    /**
     * Add colour
     *
     * @param eStore\ShopBundle\Entity\Colour $colour
     */
    public function setColours($colours)
    {
        $this->colours = $colours;
    }

    /**
     * Get colour
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getColours()
    {
        return $this->colours;
    }
}