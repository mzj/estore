<?php
/**
 * 
 */
namespace eStore\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * eStore\ShopBundle\Entity\Style
 *
 * @ORM\Table(name="style")
 * @ORM\Entity(repositoryClass="eStore\ShopBundle\Repository\StyleRepository")
 */
class Style
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
     * @OneToOne(targetEntity="Colour")
     */
    private $colour;
    
    /**
     * @ORM\Column(name="size", type="integer")
     */
    private $size;
    
}