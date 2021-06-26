<?php

namespace App\Repository;

use App\Entity\ShoppingBasket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShoppingBasket|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingBasket|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingBasket[]    findAll()
 * @method ShoppingBasket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingBasketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingBasket::class);
    }

    // /**
    //  * @return ShoppingBasket[] Returns an array of ShoppingBasket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShoppingBasket
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
