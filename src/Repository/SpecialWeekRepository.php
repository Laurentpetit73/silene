<?php

namespace App\Repository;

use App\Entity\SpecialWeek;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SpecialWeek|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialWeek|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialWeek[]    findAll()
 * @method SpecialWeek[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialWeekRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialWeek::class);
    }

    // /**
    //  * @return SpecialWeek[] Returns an array of SpecialWeek objects
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
    public function findOneBySomeField($value): ?SpecialWeek
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
