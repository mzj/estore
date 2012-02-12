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
        
        if(!$this->isUnique($productId)) {
            throw new AlreadyExistException();
        }
        
        $this->products[] = $productId;
    }
    
    /**
     *
     * @param type $id 
     */
    public function remove($id) 
    {
        $this->products = $this->removeByValue($this->products, $id);
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
    public function getNbOfProducts() 
    {
        return count($this->products);
    }
    
    /**
     *
     * @param type $array
     * @param type $val
     * @param type $preserve_keys
     * @return type 
     */
    private function removeByValue($array, $val = '', $preserve_keys = false) 
    {
	if (empty($array) || !is_array($array)) return null;
	if (!in_array($val, $array)) return $array;

	foreach($array as $key => $value) {
		if ($value == $val) unset($array[$key]);
	}

	return ($preserve_keys === true) ? $array : array_values($array);
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    private function isUnique($id)
    {
        if (in_array($id, $this->products)) {
            return false;
        } 
        
        return true;
    }

}
