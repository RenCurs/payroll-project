<?php

namespace App\Repository;

use App\Entity\UnionContribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UnionContribution|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnionContribution|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnionContribution[]    findAll()
 * @method UnionContribution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnionContributionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnionContribution::class);
    }

    // /**
    //  * @return UnionContribution[] Returns an array of UnionContribution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UnionContribution
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
