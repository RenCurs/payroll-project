<?php

namespace App\Service\Calculate;

use App\Component\Dto\PayCheckDto;
use App\Entity\Employee;
use App\Entity\ServicesCharge;
use App\Entity\UnionContribution;
use App\Repository\ServicesChargeRepository;
use App\Repository\UnionContributionRepository;
use DateTime;

abstract class AbstractCalculate
{
    protected DateTime $payDate;
    protected Employee $employee;
    protected ServicesChargeRepository $chargeRepository;
    protected UnionContributionRepository $contributionRepository;

    public function __construct(
        DateTime $payDate,
        Employee $employee,
        ServicesChargeRepository $chargeRepository,
        UnionContributionRepository $contributionRepository
    ) {
        $this->payDate = $payDate;
        $this->employee = $employee;
        $this->chargeRepository = $chargeRepository;
        $this->contributionRepository = $contributionRepository;
    }

    abstract protected function calculateSalary(): float;

    /** @return UnionContribution[] */
    abstract protected function getUnionContributions(): array;

    /** @return ServicesCharge[] */
    abstract protected function getServicesCharges(): array;

    public function calculate(): PayCheckDto
    {
        return $this->createPayCheck(
            $this->calculateSalary(),
            $this->calculateUnionContribution(),
            $this->calculateServicesCharge()
        );
    }

    protected function calculateUnionContribution(): float
    {
        $result = 0;

        if (true === $this->employee->getIsUnionAffiliation()) {
            $contributions = $this->getUnionContributions();

            foreach ($contributions as $contribution) {
                $result += $contribution->getSum();
            }
        }

        return $result;
    }

    protected function calculateServicesCharge(): float
    {
        $result = 0;

        // todo А вот за какой период брать услуги, пока неясно. По логике за расчетный период каждого типа работника.
        $services = $this->getServicesCharges();

        foreach ($services as $service) {
            $result += $service->getCost();
        }

        return $result;
    }

    protected function createPayCheck(float $baseSalary, float $unionContribution, float $servicesCharge): PayCheckDto
    {
        $check = new PayCheckDto();
        $check->baseSum = $baseSalary;
        $check->unionContributionSum = $unionContribution;
        $check->servicesChargeSum = $servicesCharge;
        $check->totalSum = $baseSalary - $servicesCharge - $unionContribution;

        return $check;
    }
}
