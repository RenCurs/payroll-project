<?php

namespace App\Repository;

use App\Entity\ServicesCharge;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
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

    /**
     * @return ServicesCharge[]
     */
    public function getByPeriod(DateTime $start, DateTime $end): array
    {
        $qb = $this->createQueryBuilder('sc');

        return $qb->andWhere(
            $qb->expr()->gte('sc.date', ':start'),
            $qb->expr()->lte('sc.date', ':end')
        )
            ->setParameters(
                new ArrayCollection(
                    [
                        new Parameter('start', $start),
                        new Parameter('end', $end),
                    ]
                )
            )
            ->getQuery()
            ->getResult();
    }
}
