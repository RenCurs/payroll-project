<?php

namespace App\Service\Calculate;

use App\Factory\PaymentCalculate;

class FixedSalaryCalculate extends AbstractCalculate implements PaymentCalculate
{
    public function calculateSalary(): float
    {
        $salary = $this->employee->getSalary();
        $this->subUnionContribution($salary);
        $this->subUnionServiceCharge($salary);

        return $salary;
    }

    /**
     * @return array
     */
    protected function getUnionContributions(): array
    {
        $payDate = clone $this->payDate;

        $startDate = $payDate->modify('First day of this month');
        $endDate = $payDate;

        return $this->contributionRepository->getByPeriod($startDate, $endDate);
    }

    /**
     * @return array
     */
    protected function getServicesCharges(): array
    {
        $payDate = clone $this->payDate;

        $startDate = $payDate->modify('First day of this month');
        $endDate = $payDate;

        return $this->chargeRepository->getByPeriod($startDate, $endDate);
    }
}
