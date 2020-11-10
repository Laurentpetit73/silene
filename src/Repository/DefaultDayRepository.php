<?php

namespace App\Repository;

use App\Entity\DefaultDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DefaultDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method DefaultDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method DefaultDay[]    findAll()
 * @method DefaultDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefaultDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DefaultDay::class);
    }

    // /**
    //  * @return DefaultDay[] Returns an array of DefaultDay objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DefaultDay
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
