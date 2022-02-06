<?php

namespace App\Repository;

use App\Entity\PayCheck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PayCheck|null find($id, $lockMode = null, $lockVersion = null)
 * @method PayCheck|null findOneBy(array $criteria, array $orderBy = null)
 * @method PayCheck[]    findAll()
 * @method PayCheck[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayCheckRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PayCheck::class);
    }

    // /**
    //  * @return PayCheck[] Returns an array of PayCheck objects
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
    public function findOneBySomeField($value): ?PayCheck
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
