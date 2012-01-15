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
 * @ORM\Table(name="colour")
 * @ORM\Entity(repositoryClass="eStore\ShopBundle\Repository\GarmentRepository")
 */
class Garment
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
     * @ManyToOne(targetEntity="Style")
     */
    private $style;
    
    /**
     *
     * @ManyToOne(targetEntity="Product", inversedBy="garments")
     */
    private $product;
    
    /**
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;
    
}