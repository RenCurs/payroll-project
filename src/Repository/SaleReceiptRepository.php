<?php

namespace App\Repository;

use App\Entity\SaleReceipt;
use Cassandra\Date;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method SaleReceipt|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaleReceipt|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaleReceipt[]    findAll()
 * @method SaleReceipt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleReceiptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaleReceipt::class);
    }

    /**
     * @return SaleReceipt[]
     */
    public function getSaleReceiptsForPeriod(DateTime $lastPayDate, DateTime $currentPayDate): array
    {
        $lastDate = clone $lastPayDate;
        $qb = $this->createQueryBuilder('sr');
        $qb
            ->where($qb->expr()->between('sr.date', ':from', ':to'))
            ->setParameters(new ArrayCollection(
                [
                    new Parameter('from', $lastDate),
                    new Parameter('to', $currentPayDate),
                ]
            ));

        return $qb->getQuery()->getResult();
    }
}
