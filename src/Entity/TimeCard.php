<?php

namespace App\Entity;

use App\Repository\TimeCardRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeCardRepository::class)]
class TimeCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private readonly ?int $id;

    #[ORM\Column(type: 'date')]
    private DateTime $date;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'timeCards')]
    #[ORM\JoinColumn(nullable: false)]
    private Employee $employee;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $spentHour;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $typeTime;

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getSpentHour(): int
    {
        return $this->spentHour;
    }

    public function setSpentHour(int $spentHour): TimeCard
    {
        $this->spentHour = $spentHour;

        return $this;
    }

    public function getTypeTime(): string
    {
        return $this->typeTime;
    }

    public function setTypeTime(string $typeTime): TimeCard
    {
        $this->typeTime = $typeTime;

        return $this;
    }
}
