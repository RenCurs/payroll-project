<?php

namespace App\Factory;

use App\Enum\PaymentTypeEnum;
use App\Entity\Employee;
use App\Service\FixedSalaryCalculate;
use InvalidArgumentException;

class PaymentCalculateFactory
{
    public function create(Employee $employee): PaymentCalculate
    {
        switch ($employee->getSalaryType()) {
            case PaymentTypeEnum::FIXED:
                $calculate = new FixedSalaryCalculate($employee);

                break;
            case PaymentTypeEnum::HOURLY:
                $calculate = 2;

                break;
            case PaymentTypeEnum::JOB_PRICE:
                $calculate = 3;

                break;
            default:
                throw new InvalidArgumentException('Неизвестный тип оплаты для работника');
        }

        return $calculate;
    }
}