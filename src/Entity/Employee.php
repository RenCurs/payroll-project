<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private DateTime $dateBirth;

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

    /**
     * @ORM\OneToOne(targetEntity=PayCheck::class, mappedBy="employee", cascade={"persist", "remove"})
     */
    private $payCheck;

    /**
     * @ORM\OneToMany(targetEntity=ServicesCharge::class, mappedBy="employee")
     */
    private $servicesCharges;

    /**
     * @ORM\OneToMany(targetEntity=TimeCard::class, mappedBy="employee", orphanRemoval=true)
     */
    private $timeCards;

    /**
     * @ORM\OneToMany(targetEntity=SaleReceipt::class, mappedBy="employee", orphanRemoval=true)
     */
    private $saleReceipts;

    /**
     * @ORM\Column(type="date")
     */
    private DateTime $lastPayDate;

    public function __construct()
    {
        $this->servicesCharges = new ArrayCollection();
        $this->timeCards = new ArrayCollection();
        $this->saleReceipts = new ArrayCollection();
    }

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

    public function getPayCheck(): ?PayCheck
    {
        return $this->payCheck;
    }

    public function setPayCheck(PayCheck $payCheck): self
    {
        // set the owning side of the relation if necessary
        if ($payCheck->getEmployee() !== $this) {
            $payCheck->setEmployee($this);
        }

        $this->payCheck = $payCheck;

        return $this;
    }

    /**
     * @return Collection|ServicesCharge[]
     */
    public function getServicesCharges(): Collection
    {
        return $this->servicesCharges;
    }

    public function addServicesCharge(ServicesCharge $servicesCharge): self
    {
        if (!$this->servicesCharges->contains($servicesCharge)) {
            $this->servicesCharges[] = $servicesCharge;
            $servicesCharge->setEmployee($this);
        }

        return $this;
    }

    public function removeServicesCharge(ServicesCharge $servicesCharge): self
    {
        if ($this->servicesCharges->removeElement($servicesCharge)) {
            // set the owning side to null (unless already changed)
            if ($servicesCharge->getEmployee() === $this) {
                $servicesCharge->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TimeCard[]
     */
    public function getTimeCards(): Collection
    {
        return $this->timeCards;
    }

    public function addTimeCard(TimeCard $timeCard): self
    {
        if (!$this->timeCards->contains($timeCard)) {
            $this->timeCards[] = $timeCard;
            $timeCard->setEmployee($this);
        }

        return $this;
    }

    public function removeTimeCard(TimeCard $timeCard): self
    {
        // set the owning side to null (unless already changed)
        if ($this->timeCards->removeElement($timeCard) && $timeCard->getEmployee() === $this) {
            $timeCard->setEmployee(null);
        }

        return $this;
    }

    /**
     * @return Collection|SaleReceipt[]
     */
    public function getSaleReceipts(): Collection
    {
        return $this->saleReceipts;
    }

    public function addSaleReceipt(SaleReceipt $saleReceipt): self
    {
        if (!$this->saleReceipts->contains($saleReceipt)) {
            $this->saleReceipts[] = $saleReceipt;
            $saleReceipt->setEmployee($this);
        }

        return $this;
    }

    public function removeSaleReceipt(SaleReceipt $saleReceipt): self
    {
        if ($this->saleReceipts->removeElement($saleReceipt)) {
            // set the owning side to null (unless already changed)
            if ($saleReceipt->getEmployee() === $this) {
                $saleReceipt->setEmployee(null);
            }
        }

        return $this;
    }

    public function getLastPayDate(): ?DateTime
    {
        return $this->lastPayDate;
    }

    public function setLastPayDate(DateTime $lastPayDate): self
    {
        $this->lastPayDate = $lastPayDate;

        return $this;
    }
}
