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
}
