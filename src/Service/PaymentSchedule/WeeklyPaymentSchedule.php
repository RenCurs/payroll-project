<?php

namespace App\Service\PaymentSchedule;

use App\Factory\PaymentSchedule;
use DateTime;

class WeeklyPaymentSchedule implements PaymentSchedule
{
    private const FRIDAY = 'Friday';

    public function isPayDate(DateTime $date): bool
    {
        $payDate = clone $date;

        return self::FRIDAY === $payDate->format('l');
    }
}
