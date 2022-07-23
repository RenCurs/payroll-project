<?php

namespace App\Factory;

use DateTime;

interface PaymentSchedule
{
    public function isPayDate(DateTime $date): bool;
}
