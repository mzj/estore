<?php

namespace eStore\ShopBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * GarmentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
        
class GarmentRepository extends EntityRepository
{    
    /**
     *
     * @todo You could use DISTINCT clause
     */
    public function getGarments()
    {
        $query = $this->_em
                      ->createQuery("SELECT p, g, c
                                     FROM eStore\ShopBundle\Entity\Product p
                                     LEFT JOIN p.garments g
                                     LEFT JOIN g.colours c
                                     WHERE p.id = 22 
                                     ORDER BY p.id DESC
                                   ");
        return $query->getResult();
    }
}