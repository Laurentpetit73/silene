<?php

namespace App\Repository;

use App\Entity\PriceConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PriceConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceConfig[]    findAll()
 * @method PriceConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceConfig::class);
    }

    // /**
    //  * @return PriceConfig[] Returns an array of PriceConfig objects
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
    public function findOneBySomeField($value): ?PriceConfig
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
