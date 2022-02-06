<?php

namespace App\Factory;

use App\Entity\Employee;
use App\Enum\PaymentScheduleEnum;
use App\Service\MonthlyPaymentSchedule;
use InvalidArgumentException;

class PaymentScheduleFactory
{
    public function create(Employee $employee): PaymentSchedule
    {
        switch ($employee->getPaymentSchedule()) {
            case PaymentScheduleEnum::MONTHLY:
                $schedule = new MonthlyPaymentSchedule();

                break;
            default:
                throw new InvalidArgumentException('Неизвестный график оплаты');
        }

        return $schedule;
    }
}