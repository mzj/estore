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
 * ORM\Table(name="style")
 * ORM\Entity(repositoryClass="eStore\ShopBundle\Repository\StyleRepository")
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
     * @ORM\ManyToMany(targetEntity="Colour")
     * @ORM\JoinTable(
     *   joinColumns={
     *     @ORM\JoinColumn(name="style_id", referencedColumnName="id")
     *   }
     * )
     */
    private $colour;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Garment", mappedBy="style")
     */
    private $garments;
    
    /**
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    
    public function __construct()
    {
        $this->colour = new \Doctrine\Common\Collections\ArrayCollection();
        $this->garments = new \Doctrine\Common\Collections\ArrayCollection();
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
        $this->colour[] = $colour;
    }

    /**
     * Get colour
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * Add garments
     *
     * @param eStore\ShopBundle\Entity\Garment $garments
     */
    public function addGarment(\eStore\ShopBundle\Entity\Garment $garments)
    {
        $this->garments[] = $garments;
    }

    /**
     * Get garments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGarments()
    {
        return $this->garments;
    }
    
    public function __toString()
    {
        $colours = null;
        
        foreach($this->colour as $colour) {
            $colours .= ', ' . $colour->getName();
        }
        return $colours . ' | Size: ' . $this->getSize();
    }
}