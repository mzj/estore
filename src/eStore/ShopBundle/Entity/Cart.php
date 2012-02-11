<?php
/**
 * 
 */
namespace eStore\ShopBundle\Entity;

class Cart 
{
    private $products = array();
    
    
    public function setProduct($productId)
    {
        $this->products[] = (int)$productId;
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
    
    private function removeByValue($array, $val = '', $preserve_keys = true) 
    {
	if (empty($array) || !is_array($array)) return null;
	if (!in_array($val, $array)) return $array;

	foreach($array as $key => $value) {
		if ($value == $val) unset($array[$key]);
	}

	return ($preserve_keys === true) ? $array : array_values($array);
    } 

}
