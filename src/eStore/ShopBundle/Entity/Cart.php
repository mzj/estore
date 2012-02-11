<?php
/**
 * 
 */
namespace eStore\ShopBundle\Entity;

use eStore\ShopBundle\Exception\AlreadyExistException;

class Cart 
{
    private $products = array();
    
    
    public function setProduct($productId)
    {        
        $productId = (int)$productId;
        
        if(!$this->isUnique($productId)) {
            throw new AlreadyExistException();
        }
        
        $this->products[] = $productId;
    }
    
    public function remove($id) 
    {
        $this->products = $this->removeByValue($this->products, $id);
    }
    
    public function getProducts()
    {
        return $this->products;
    }
    
    public function getNbOfProducts() 
    {
        return count($this->products);
    }
    
    private function removeByValue($array, $val = '', $preserve_keys = false) 
    {
	if (empty($array) || !is_array($array)) return null;
	if (!in_array($val, $array)) return $array;

	foreach($array as $key => $value) {
		if ($value == $val) unset($array[$key]);
	}

	return ($preserve_keys === true) ? $array : array_values($array);
    }
    
    private function isUnique($id)
    {
        if (in_array($id, $this->products)) {
            return false;
        } 
        
        return true;
    }

}
