<?php
namespace eStore\ShopBundle\Repository;

use Doctrine\ORM\EntityRepository,
    eStore\ShopBundle\Entity\Product;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    /**
     *
     * @param type $id
     * @return type 
     */
    public function getProductById($id) 
    {
        if(empty($id)) {
            return;
        }
        
        $query = $this->_em->createQuery("SELECT p, g, c, b, col
                                          FROM eStore\ShopBundle\Entity\Product p
                                          JOIN p.garments g
                                          JOIN p.categories c
                                          JOIN p.brand b
                                          JOIN g.colours col
                                          WHERE p.id IN (?1)");
        $query->setParameter(1, $id); 

        $result = !is_array($id) ?  $query->getSingleResult() : $query->getResult();

        return $result; 
    }
    
    /**
     *
     * @todo You could use DISTINCT (Group by) clause
     */
    public function getPopularProducts()
    {
        $query = $this->_em
                      ->createQuery("SELECT p, c, cp
                                     FROM eStore\ShopBundle\Entity\Product p
                                     JOIN p.categories c
                                     LEFT JOIN c.parent cp
                                     ORDER BY p.id DESC
                                   ");
        return $query;
    }
    
    /**
     *
     * @return type 
     */
    public function getProducts()
    {
        $query = $this->_em
                      ->createQuery("SELECT p
                                     FROM eStore\ShopBundle\Entity\Product p
                                     ORDER BY p.id DESC
                                   ");
        return $query;
    }
    
    /**
     *
     * @return type 
     */
    public function getProductsWithTerm($term)
    {
        $query = $this->_em
                      ->createQuery("SELECT p
                                     FROM eStore\ShopBundle\Entity\Product p
                                     WHERE p.name LIKE :term
                                     ORDER BY p.id DESC
                                   ");
        $query->setParameter('term', '%' . $term . '%');
        
        return $query;
    }
    
    
    /**
     * @todo Query Builder bug with joins - solution searching in progress
     */
    public function getProductsForApi($params)
    {       
        $orderByPrice = $params['orderByPrice'] == 'asc' ? 'ASC' : 'DESC';
        $parameters = array(
                'priceMin' => $params['priceMin'], 
                'priceMax' => $params['priceMax'],
                'gender' => $params['gender'],
                'colours' => explode('-', $params['colours']));
        
        $dql = "SELECT p
                 FROM eStore\ShopBundle\Entity\Product p
                 JOIN p.garments g
                 JOIN g.colours c
                 JOIN p.categories cat
                 WHERE p.price BETWEEN :priceMin AND :priceMax";
        
        if(!empty($params['category'])) {
            $cat = $this->getCategory($params['category']);
            $left  = $cat->getLft();
            $right = $cat->getRgt();
            
            $dql .= " AND cat.lft BETWEEN :left AND :right ";
            $parameters['left'] = $left;
            $parameters['right'] = $right;
        }
        if(!empty($params['size'])) {
            $dql .= " AND g.size = :size ";
            
            $parameters['size'] = $params['size'];
        }
        $dql .= " AND p.gender = :gender
                  AND c.id IN (:colours)
                  ORDER BY p.price " . $orderByPrice;
        
        $query = $this->_em->createQuery($dql);
        
       
        
        $query->setParameters($parameters);
        
        return $query;
    }
    
    /**
     *
     * @param type $id
     * @return type 
     */
    private function getCategory($id)
    {
         $query = $this->_em
                      ->createQuery("SELECT c
                                     FROM eStore\ShopBundle\Entity\Category c
                                     WHERE c.id = ?1
                                   ");
         $query->setParameter(1, $id);
         $cat = $query->getSingleResult();
         
         return $cat;
    }
}