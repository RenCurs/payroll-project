<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $fio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $address;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $dateBirth;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $salaryType;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $paymentSchedule;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $salary;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $hourTariff;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $commissionRate;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $isUnionAffiliation;

    /**
     * @ORM\OneToOne(targetEntity=UnionContribution::class, mappedBy="employee", cascade={"persist", "remove"})
     */
    private ?UnionContribution $unionContribution;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFio(): ?string
    {
        return $this->fio;
    }

    public function setFio(string $fio): self
    {
        $this->fio = $fio;

        return $this;
    }

    public function getSalaryType(): ?string
    {
        return $this->salaryType;
    }

    public function setSalaryType(string $salaryType): self
    {
        $this->salaryType = $salaryType;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDateBirth(): ?DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    public function getPaymentSchedule(): ?string
    {
        return $this->paymentSchedule;
    }

    public function setPaymentSchedule(string $paymentSchedule): self
    {
        $this->paymentSchedule = $paymentSchedule;

        return $this;
    }

    public function getIsUnionAffiliation(): ?string
    {
        return $this->isUnionAffiliation;
    }

    public function setIsUnionAffiliation(string $isUnionAffiliation): self
    {
        $this->isUnionAffiliation = $isUnionAffiliation;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getHourTariff(): ?float
    {
        return $this->hourTariff;
    }

    public function setHourTariff(float $hourTariff): self
    {
        $this->hourTariff = $hourTariff;

        return $this;
    }

    public function getCommissionRate(): ?float
    {
        return $this->commissionRate;
    }

    public function setCommissionRate(float $commissionRate): self
    {
        $this->commissionRate = $commissionRate;

        return $this;
    }

    public function getUnionContribution(): ?UnionContribution
    {
        return $this->unionContribution;
    }

    public function setUnionContribution(UnionContribution $unionContribution): self
    {
        // set the owning side of the relation if necessary
        if ($unionContribution->getEmployee() !== $this) {
            $unionContribution->setEmployee($this);
        }

        $this->unionContribution = $unionContribution;

        return $this;
    }
}
