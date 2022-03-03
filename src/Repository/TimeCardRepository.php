<?php

namespace App\Repository;

use App\Entity\TimeCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TimeCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeCard[]    findAll()
 * @method TimeCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeCard::class);
    }

    // /**
    //  * @return TimeCard[] Returns an array of TimeCard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TimeCard
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
