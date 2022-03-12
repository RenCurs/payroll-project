<?php

namespace App\Repository;

use App\Entity\TimeCard;
use DateInterval;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;

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

    /**
     * @return TimeCard[]
     */
    public function getTimeCardsForWeek(DateTime $currentDate): array
    {
        $friday = clone $currentDate;
        $monday = $currentDate->sub(new DateInterval('P4D'));

        if ('Mon' !== $monday->format('D')) {
            throw new InvalidArgumentException('Incorrect date for weekly search, current day must be friday!');
        }

        $qb = $this->createQueryBuilder('tc');

        $qb->where($qb->expr()->between('tc.date', ':monday', ':friday'))
            ->setParameters(new ArrayCollection([
                    new Parameter('monday', $monday),
                    new Parameter('friday', $friday),
                ]
            ));

        return $qb->getQuery()->getResult();
    }
}
