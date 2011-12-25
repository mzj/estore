<?php
namespace eStore\ShopBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    public function getPopularProducts($limit = 10)
    {
        $qb = $this->createQueryBuilder('p')
                   ->select('p')
                   ->addOrderBy('p.id', 'ASC');
        if (!is_null($limit)) {
                $qb->setMaxResults($limit);
        }
        return $qb->getQuery()
                  ->getResult();
    }
    
    public function getProductCategories($product)
    {
        $pid = $product->getId();
        
         $qb = $this->createQueryBuilder('c')
                    ->select('c')
                    ->from('eStore\StoreBundle\Entity\Categoty', 'c')
                    ->innerJoin('category_product.category_id WHERE category_product.product_id=privati.id');

        return $qb->getQuery()
                  ->getResult();
    }
}