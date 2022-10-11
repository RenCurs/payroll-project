<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use App\Validator\PaymentTypeConstraint;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use SalaryConstraint;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TODO Поправить типы для св-в и методов
 */
#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[SalaryConstraint]
#[PaymentTypeConstraint]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['account'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['account'])]
    #[Assert\NotBlank]
    private string $fio;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['account'])]
    private ?string $address = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['account'])]
    #[Assert\NotBlank]
    #[Assert\Type(DateTimeInterface::class)]
    private DateTimeInterface $dateBirth;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['account'])]
    #[Assert\NotBlank]
    private string $salaryType;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['account'])]
    #[Assert\NotBlank]
    private string $paymentSchedule;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['account'])]
    private ?float $salary = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['account'])]
    private ?float $hourTariff = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['account'])]
    private ?float $commissionRate = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    #[Groups(['account'])]
    private bool $isUnionAffiliation = false;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: UnionContribution::class, cascade: ['persist', 'remove'])]
    #[Groups(['account'])]
    private Collection $unionContribution;

    #[ORM\OneToOne(mappedBy: 'employee', targetEntity: PayCheck::class, cascade: ['persist', 'remove'])]
    #[Groups(['account'])]
    private ?PayCheck $payCheck = null;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: ServicesCharge::class)]
    private Collection $servicesCharges;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: TimeCard::class, orphanRemoval: true)]
    #[Groups(['account'])]
    private Collection $timeCards;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: SaleReceipt::class, orphanRemoval: true)]
    #[Groups(['account'])]
    private Collection $saleReceipts;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?DateTimeInterface $lastPayDate = null;

    public function __construct()
    {
        $this->servicesCharges = new ArrayCollection();
        $this->timeCards = new ArrayCollection();
        $this->saleReceipts = new ArrayCollection();
        $this->unionContribution = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFio(): string
    {
        return $this->fio;
    }

    public function setFio(string $fio): self
    {
        $this->fio = $fio;

        return $this;
    }

    public function getSalaryType(): string
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

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDateBirth(): DateTimeInterface
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

    public function getIsUnionAffiliation(): bool
    {
        return $this->isUnionAffiliation;
    }

    public function setIsUnionAffiliation(bool $isUnionAffiliation): self
    {
        $this->isUnionAffiliation = $isUnionAffiliation;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(?float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getHourTariff(): ?float
    {
        return $this->hourTariff;
    }

    public function setHourTariff(?float $hourTariff): self
    {
        $this->hourTariff = $hourTariff;

        return $this;
    }

    public function getCommissionRate(): ?float
    {
        return $this->commissionRate;
    }

    public function setCommissionRate(?float $commissionRate): self
    {
        $this->commissionRate = $commissionRate;

        return $this;
    }

    public function getUnionContribution(): Collection
    {
        return $this->unionContribution;
    }

    public function addUnionContribution(UnionContribution $unionContribution): self
    {
        // set the owning side of the relation if necessary
        if (!$this->unionContribution->contains($unionContribution)) {
            $this->unionContribution->add($unionContribution);
            $unionContribution->setEmployee($this);
        }

        return $this;
    }

    public function removeUnionContribution(UnionContribution $unionContribution): self
    {
        // set the owning side of the relation if necessary
        if (!$this->unionContribution->removeElement($unionContribution)) {
            // set the owning side to null (unless already changed)
            if ($unionContribution->getEmployee() === $this) {
                $unionContribution->setEmployee(null);
            }
        }

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

    public function getLastPayDate(): ?DateTimeInterface
    {
        return $this->lastPayDate;
    }

    public function setLastPayDate(DateTimeInterface $lastPayDate): self
    {
        $this->lastPayDate = $lastPayDate;

        return $this;
    }
}
