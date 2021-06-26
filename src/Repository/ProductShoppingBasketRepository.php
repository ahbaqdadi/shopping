<?php

namespace App\Repository;

use App\Entity\ProductShoppingBasket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductShoppingBasket|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductShoppingBasket|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductShoppingBasket[]    findAll()
 * @method ProductShoppingBasket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductShoppingBasketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductShoppingBasket::class);
    }

    // /**
    //  * @return ProductShoppingBasket[] Returns an array of ProductShoppingBasket objects
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
    public function findOneBySomeField($value): ?ProductShoppingBasket
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
