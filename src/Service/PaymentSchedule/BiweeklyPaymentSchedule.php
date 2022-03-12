<?php

namespace App\Service\PaymentSchedule;

use App\Factory\PaymentSchedule;
use DateTime;

class BiweeklyPaymentSchedule implements PaymentSchedule
{

    public function isPayDate(DateTime $date): bool
    {
        // todo ???
        $payDate = clone $date;
        $firstTwoTuesday = $payDate->modify('second tuesday')->format('l');

        $payDate = clone $date;
        $secondTwoTuesday = $payDate->modify('fourth tuesday')->format('l');

        return in_array($date->format('l'), [$firstTwoTuesday, $secondTwoTuesday], true);
    }
}