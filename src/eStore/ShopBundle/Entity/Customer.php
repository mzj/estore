<?php
// src/Acme/UserBundle/Entity/User.php

namespace eStore\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="eStore\ShopBundle\Repository\CustomerRepository")
 * @ORM\Table(name="customer")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    
    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    
    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;
    
   /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    

    
    
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
     * Set name
     *
     * @param string $name
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }
    
            /**
     * Set name
     *
     * @param string $name
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * Set name
     *
     * @param string $name
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    
    
}