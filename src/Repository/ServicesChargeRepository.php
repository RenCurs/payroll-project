<?php

namespace App\Repository;

use App\Entity\ServicesCharge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServicesCharge|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServicesCharge|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServicesCharge[]    findAll()
 * @method ServicesCharge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicesChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServicesCharge::class);
    }

    // /**
    //  * @return ServicesCharge[] Returns an array of ServicesCharge objects
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
    public function findOneBySomeField($value): ?ServicesCharge
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
