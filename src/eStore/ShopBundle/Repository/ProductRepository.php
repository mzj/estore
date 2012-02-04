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
     *
     * @return type 
     */
    public function getProductsForApi($params)
    {       
        $orderByPrice = $params['orderByPrice'] == 'asc' ? 'ASC' : 'DESC';
        $parameters = array(
                'priceMin' => $params['priceMin'], 
                'priceMax' => $params['priceMax'],
                'gender' => $params['gender'],
                'size' => $params['size'],
                'colours' => explode('-', $params['colours']));
        
        $dql = "SELECT p
                 FROM eStore\ShopBundle\Entity\Product p
                 JOIN p.garments g
                 JOIN g.colours c
                 JOIN p.categories cat
                 WHERE p.price BETWEEN :priceMin AND :priceMax";
        if(!empty($params['category'])) {
            $dql .= " AND cat.id = :category ";
            $parameters['category'] = $params['category'];
        }
        $dql .= " AND p.gender = :gender
                  AND g.size = :size              
                  AND c.id IN (:colours)
                  ORDER BY p.price " . $orderByPrice;
        
        $query = $this->_em->createQuery($dql);
        
        
        $query->setParameters($parameters);
        
        return $query;
    }
    
    private function tmpQbDql($params) 
    {
        $priceMin = $params['priceMin'];
        $priceMax = $params['priceMax'];
        $gender = $params['gender'];
        $size = $params['size'];
        $orderByPrice = $params['orderByPrice'];
        
        $qb = $this->createQueryBuilder('v');        
        $qb->select('p', 'g', 'c')
           ->from('eStore\ShopBundle\Entity\Product', 'p')
           ->innerJoin('p.garments', 'g')
           ->leftJoin('g.colours', 'c')
                
           //->where('p.price between ?1 and ?2')
           //->andWhere('p.gender = ?3')
           //->andWhere('g.size = ?4');
        
        //if($orderByPrice == 'asc' || $orderByPrice == 'desc') {
       //     $qb->orderBy('p.price', $orderByPrice);
        //} else {
           ->orderBy('p.id', 'desc');
        //}
        
        /*$qb->setParameter(1, $priceMin) 
           ->setParameter(2, $priceMax)
           ->setParameter(3, $gender)
           ->setParameter(4, $size);*/
        
        return $qb->getQuery();
    }
}