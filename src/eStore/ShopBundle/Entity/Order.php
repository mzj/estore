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
 * @ORM\Table(name="estore_order")
 * @ORM\Entity(repositoryClass="eStore\ShopBundle\Repository\OrderRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Order
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
     *
     * @ORM\ManyToOne(targetEntity="Garment", inversedBy="orders")
     */
    private $garment;
    
    /**
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;
    
    
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
     * Get quantity
     *
     * @return integer 
     */
    public function getGarment()
    {
        return $this->garment;
    }
    
    /**
     */
    public function setGarment($garment)
    {
        $this->garment = $garments;
        $garment->addOrder($this);
    }
}