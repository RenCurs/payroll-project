<?php

namespace App\Service;

use App\Entity\Employee;
use App\Factory\PaymentCalculate;

class FixedSalaryCalculate implements PaymentCalculate
{
    private Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function calculate(): float
    {
        $salary = $this->employee->getSalary();
        $this->subUnionContribution($salary);
        $this->subUnionServiceCharge($salary);

        return $salary;
    }

    private function subUnionContribution(float &$salary): void
    {
    }

    private function subUnionServiceCharge(float &$salary): void
    {
    }
}