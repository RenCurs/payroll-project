<?php

namespace App\Factory;

use App\Entity\Employee;
use App\Enum\PaymentScheduleEnum;
use App\Service\PaymentSchedule\BiweeklyPaymentSchedule;
use App\Service\PaymentSchedule\MonthlyPaymentSchedule;
use App\Service\PaymentSchedule\WeeklyPaymentSchedule;
use InvalidArgumentException;

class PaymentScheduleFactory
{
    public function create(Employee $employee): PaymentSchedule
    {
        $schedule = match ($employee->getPaymentSchedule()) {
            PaymentScheduleEnum::MONTHLY => new MonthlyPaymentSchedule(),
            PaymentScheduleEnum::WEEKLY => new WeeklyPaymentSchedule(),
            PaymentScheduleEnum::BIWEEKLY => new BiweeklyPaymentSchedule(),
            default => throw new InvalidArgumentException('Неизвестный график оплаты'),
        };

        return $schedule;
    }
}