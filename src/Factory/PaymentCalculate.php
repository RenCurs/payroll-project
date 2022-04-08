<?php

namespace App\Factory;

use App\Component\Dto\PayCheckDto;

interface PaymentCalculate
{
    public function calculate(): PayCheckDto;
}