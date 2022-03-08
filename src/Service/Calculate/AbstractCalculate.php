<?php

namespace App\Service\Calculate;

use App\Entity\Employee;

abstract class AbstractCalculate
{
    protected Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    abstract protected function calculateSalary(): float;

    public function calculate(): float
    {
        $salary = $this->calculateSalary();
        $this->subUnionContribution($salary);
        $this->subUnionServiceCharge($salary);

        return $salary;
    }

    protected function subUnionContribution(float &$salary): void
    {
        if ($this->employee->getIsUnionAffiliation()) {
            $contribution = $this->employee->getUnionContribution();

            if (null !== $contribution) {
                $salary-= $contribution->getSum();
            }
        }
    }

    protected function subUnionServiceCharge(float &$salary): void
    {
        $services = $this->employee->getServicesCharges();

        foreach ($services as $service) {
            $salary-= $service->getCost();
        }
    }
}
