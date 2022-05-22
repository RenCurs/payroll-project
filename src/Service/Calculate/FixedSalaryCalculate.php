<?php

namespace App\Service\Calculate;

use App\Factory\PaymentCalculate;

class FixedSalaryCalculate extends AbstractCalculate implements PaymentCalculate
{
    public function calculateSalary(): float
    {
        return $this->employee->getSalary();
    }

    /**
     * @return array
     */
    protected function getUnionContributions(): array
    {
        $startDate = (clone $this->payDate)->modify('First day of this month');
        $endDate = clone $this->payDate;

        return $this->contributionRepository->getByPeriod($this->employee, $startDate, $endDate);
    }

    /**
     * @return array
     */
    protected function getServicesCharges(): array
    {
        $payDate = clone $this->payDate;

        $startDate = $payDate->modify('First day of this month');
        $endDate = $payDate;

        return $this->chargeRepository->getByPeriod($this->employee, $startDate, $endDate);
    }
}
