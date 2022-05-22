<?php

namespace App\Repository;

use App\Entity\Employee;
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
    public function getTimeCardsForWeek(Employee $employee, DateTime $currentDate): array
    {
        $friday = clone $currentDate;
        $monday = $currentDate->sub(new DateInterval('P4D'));

        if ('Mon' !== $monday->format('D')) {
            throw new InvalidArgumentException('Incorrect date for weekly search, current day must be friday!');
        }

        $qb = $this->createQueryBuilder('tc');

        $qb->where($qb->expr()->between('tc.date', ':monday', ':friday'))
            ->andWhere($qb->expr()->eq('tc.employee', ':employee'))
            ->setParameters(new ArrayCollection([
                    new Parameter('monday', $monday),
                    new Parameter('friday', $friday),
                    new Parameter('employee', $employee),
                ]
            ));

        return $qb->getQuery()->getResult();
    }
}
