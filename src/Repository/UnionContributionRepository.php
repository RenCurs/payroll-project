<?php

namespace App\Repository;

use App\Entity\UnionContribution;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

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

    /**
     * @return UnionContribution[]
     */
    public function getByPeriod(DateTime $start, DateTime $end): array
    {
        $qb = $this->createQueryBuilder('uc');

        return $qb->andWhere(
            $qb->expr()->gte('uc.dateStart', ':start'),
            $qb->expr()->lte('uc.dateEnd', ':end')
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
