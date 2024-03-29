<?php

namespace App\Component\Dto;

use DateTime;

class TimeSpentDto
{
    public ?DateTime $date = null;

    /** @var int[] */
    public array $primaryTime = [];

    /** @var int[] */
    public array $overTime = [];
}
