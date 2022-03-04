<?php

namespace App\Factory;

use App\Entity\Employee;
use App\Enum\PaymentTypeEnum;
use App\Service\Calculate\FixedSalaryCalculate;
use App\Service\Calculate\HourlySalaryCalculate;
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
                $calculate = new HourlySalaryCalculate($employee);

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