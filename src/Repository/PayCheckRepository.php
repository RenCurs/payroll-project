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
}
