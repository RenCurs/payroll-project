<?php

namespace App\Entity;

use App\Repository\UnionContributionRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UnionContributionRepository::class)
 */
class UnionContribution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="float")
     */
    private float $sum;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="unionContribution", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Employee $employee;

    /**
     * @ORM\Column(type="date")
     */
    private $dateStart;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEnd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getDateStart(): DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(DateTime $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(DateTime $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }
}
