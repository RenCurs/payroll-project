<?php

namespace App\Entity;

use App\Repository\PayCheckRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayCheckRepository::class)]
class PayCheck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private readonly ?int $id;

    #[ORM\Column(type: 'float')]
    private float $sum;

    #[ORM\Column(type: 'float')]
    private float $unionContribution;

    #[ORM\Column(type: 'float')]
    private float $servicesCharge;

    #[ORM\Column(type: 'float')]
    private float $totalSum;

    #[ORM\OneToOne(targetEntity: Employee::class, inversedBy: 'payCheck', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Employee $employee;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface $date;

    public function getId(): ?int
    {
        return $this->id ?? null;
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

    public function getUnionContribution(): float
    {
        return $this->unionContribution;
    }

    public function setUnionContribution(float $unionContribution): self
    {
        $this->unionContribution = $unionContribution;

        return $this;
    }

    public function getServicesCharge(): float
    {
        return $this->servicesCharge;
    }

    public function setServicesCharge(float $servicesCharge): self
    {
        $this->servicesCharge = $servicesCharge;

        return $this;
    }

    public function getTotalSum(): float
    {
        return $this->totalSum;
    }

    public function setTotalSum(float $totalSum): self
    {
        $this->totalSum = $totalSum;

        return $this;
    }

    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    public function setEmployee(Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
