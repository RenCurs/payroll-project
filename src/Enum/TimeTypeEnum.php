<?php

namespace App\Enum;

/**
 * Класс для перечисления типов потраченного времени
 */
class TimeTypeEnum
{
    /** @var string Рабочее время */
    final public const PRIMARY = 'primary';

    /** @var string Сверхурочное */
    final public const OVER_TIME = 'overtime';
}
