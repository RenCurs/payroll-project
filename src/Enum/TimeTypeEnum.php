<?php

namespace App\Enum;

/**
 * Класс для перечисления типов потраченного времени
 */
class TimeTypeEnum
{
    /** @var string Рабочее время */
    public const PRIMARY = 'primary';

    /** @var string Сверхурочное */
    public const OVER_TIME = 'overtime';
}
