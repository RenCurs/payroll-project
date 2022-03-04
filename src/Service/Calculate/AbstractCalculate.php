<?php

namespace App\Service\Calculate;

use App\Entity\Employee;

// todo Или убрать абстракцию, сделать либо хелпер для этого либо сервис ???
class AbstractCalculate
{
    protected Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
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
