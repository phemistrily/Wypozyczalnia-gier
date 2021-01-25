<?php

namespace App\Repository;

use App\Entity\BasketLanes;
use App\Exception\BasketLane\BasketLaneNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BasketLanes|null find($id, $lockMode = null, $lockVersion = null)
 * @method BasketLanes|null findOneBy(array $criteria, array $orderBy = null)
 * @method BasketLanes[]    findAll()
 * @method BasketLanes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BasketLanesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BasketLanes::class);
    }

    public function getById(int $id): BasketLanes
    {
        $basketLane = $this->find($id);

        if(!$basketLane) {
            throw BasketLaneNotFound::forId($id);
        }

        return $basketLane;
    }

    // /**
    //  * @return BasketLanes[] Returns an array of BasketLanes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BasketLanes
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
