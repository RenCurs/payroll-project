<?php

namespace App\Enum;

// TODO Можно попробовать на enum переделать, чисто для изучения
class PaymentTypeEnum
{
    final public const FIXED = 'fixed';
    final public const HOURLY = 'hourly';
    final public const JOBPRICE = 'job_price';

    /**
     * @return string[]
     */
    public static function getTypes(): array
    {
        return [self::FIXED, self::HOURLY, self::JOBPRICE];
    }
}
