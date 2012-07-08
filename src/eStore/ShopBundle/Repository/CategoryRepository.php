<?php

/*
 * This file is part of the eStore\ShopBundle
 * 
 * @author: Marko Z. Jovanovic <markozjovanovic@gmail.com>
 */

namespace eStore\ShopBundle\Repository;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
        
class CategoryRepository extends NestedTreeRepository
{
    /**
     * Returns all products that are under passed 
     * category (or children of that category)
     * 
     * @param Category $category
     * @return array 
     */
    public function getAllProductsByCategory($category) 
    {
        $left  = $category->getLft();
        $right = $category->getRgt();
        
        $query = $this->_em->createQuery("SELECT p 
                                          FROM eStore\ShopBundle\Entity\Product p
                                          JOIN p.categories c
                                          WHERE c.lft BETWEEN ?1 AND ?2");
        $query->setParameters(array(
                1 => $left,
                2 => $right
            ));
        
        return $query->getResult();
    }
    
    /**
     * Strips root category
     * 
     * @return array 
     */
    public function getArrWithoutRoot() 
    {
        $categories = $this->childrenQuery()->getArrayResult();
        unset($categories[0]);
        
        return $categories;        
    }
    
}