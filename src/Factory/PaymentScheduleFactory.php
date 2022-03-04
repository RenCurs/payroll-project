<?php

namespace App\Factory;

use App\Entity\Employee;
use App\Enum\PaymentScheduleEnum;
use App\Service\PaymentSchedule\MonthlyPaymentSchedule;
use App\Service\PaymentSchedule\WeeklyPaymentSchedule;
use InvalidArgumentException;

class PaymentScheduleFactory
{
    public function create(Employee $employee): PaymentSchedule
    {
        switch ($employee->getPaymentSchedule()) {
            case PaymentScheduleEnum::MONTHLY:
                $schedule = new MonthlyPaymentSchedule();

                break;

            case PaymentScheduleEnum::WEEKLY:
                $schedule = new WeeklyPaymentSchedule();

                break;
            default:
                throw new InvalidArgumentException('Неизвестный график оплаты');
        }

        return $schedule;
    }
}