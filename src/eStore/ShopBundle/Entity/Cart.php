<?php
/**
 * 
 */
namespace eStore\ShopBundle\Entity;

use eStore\ShopBundle\Exception\AlreadyExistException;

class Cart 
{
    private $products = array();
    
    /**
     *
     * @param type $productId 
     */
    public function setProduct($productId)
    {        
        $productId = (int)$productId;
        
        if(!empty($this->products[$productId])) {
            throw new AlreadyExistException();
        }
        
        $this->products[$productId] = 1;
    }
    
    /**
     *
     * @param type $id 
     */
    public function remove($productId) 
    {
        unset($this->products[$productId]);
    }
    
    /**
     *
     * @return type 
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    
    /**
     *
     * @return type 
     */
    public function getProductsIds()
    {
        return array_keys($this->products);
    }
    
    /**
     *
     * @return type 
     */
    public function getNbOfProducts() 
    {
        return count($this->products);
    }
    
    /**
     * 
     */
    public function getQuantity($productId)
    {
        return $this->products[$productId];
    }
    
    /**
     * 
     */
    public function setQuantity($productId, $quantity)
    {
        $this->products[$productId] = $quantity;
    }
}
