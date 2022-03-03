<?php

namespace App\Service;

use App\Entity\Employee;
use App\Factory\PaymentCalculate;

class HourlySalaryCalculate implements PaymentCalculate
{
    private Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function calculate(): float
    {
       $timeCards = $this->employee->getTimeCards();
    }
}