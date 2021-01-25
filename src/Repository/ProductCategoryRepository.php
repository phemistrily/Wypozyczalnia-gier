<?php

namespace App\Repository;

use App\Entity\ProductCategory;
use App\Exception\ProductCategory\CategoryNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @method ProductCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductCategory[]    findAll()
 * @method ProductCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCategory::class);
    }

    public function getProductCategories()
    {
        try {
            $categories = $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult()
            ;

            if (!$categories[0] instanceof ProductCategory) {
                throw new Exception("Product Categories not found");
                
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
            
        return $categories;
    }

    public function getById(int $id): ProductCategory
    {
        $category = $this->find($id);

        if(!$category) {
            throw CategoryNotFound::forId($id);
        }

        return $category;
    }

    // /**
    //  * @return ProductCategory[] Returns an array of ProductCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductCategory
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
