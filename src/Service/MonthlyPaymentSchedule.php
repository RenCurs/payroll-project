<?php

namespace App\Service;

use App\Factory\PaymentSchedule;
use DateTime;

class MonthlyPaymentSchedule implements PaymentSchedule
{
    public function isPayDate(DateTime $date): bool
    {
        $lastDay = (new DateTime())->format('t');
        $currentDay = $date->format('d');

        return $lastDay === $currentDay;
    }
}