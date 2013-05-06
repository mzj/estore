<?php
/**
 * 
 */
namespace eStore\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * eStore\ShopBundle\Entity\Order
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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="orders")
     */
    private $product;
    
    
    /**
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="orders")
     */
    private $customer;
    
    
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
    public function setProduct($product)
    {
        return $this->product = $product;
    }
    
    /**
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        //$customer->addOrder($this);
    }
}