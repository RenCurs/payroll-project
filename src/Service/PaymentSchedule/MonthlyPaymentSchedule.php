<?php

namespace App\Service\PaymentSchedule;

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
        $lastDay = (clone $date)->format('t');
        $currentDay = (clone $date)->format('d');

        return $lastDay === $currentDay;
    }
}