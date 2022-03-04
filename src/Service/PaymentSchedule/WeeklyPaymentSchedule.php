<?php

namespace App\Service\PaymentSchedule;

use App\Factory\PaymentSchedule;
use DateTime;

class WeeklyPaymentSchedule implements PaymentSchedule
{
    private const FRIDAY = 'Friday';

    public function isPayDate(DateTime $date): bool
    {
        return self::FRIDAY === $date->format('l');
    }
}
