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
        $firstTwoTuesday = $payDate->modify('second tuesday of this month')->format('d');

        $payDate = clone $date;
        $secondTwoTuesday = $payDate->modify('fourth tuesday of this month')->format('d');

        return in_array($date->format('d'), [$firstTwoTuesday, $secondTwoTuesday], true);
    }
}