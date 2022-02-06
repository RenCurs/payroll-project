<?php

namespace App\Service;

use App\Factory\PaymentSchedule;
use DateTime;

class MonthlyPaymentSchedule implements PaymentSchedule
{
    /**
     * Для месячного графика оплаты, проверяем, что текущий день - последний день месяца,
     * иначе не выплачиваем.
     */
    public function isPayDate(DateTime $date): bool
    {
        $lastDay = (new DateTime())->format('t');
        $currentDay = $date->format('d');

        return $lastDay === $currentDay;
    }
}