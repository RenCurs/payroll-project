<?php

namespace App\Component\Dto;

class PayCheckDto
{
    /** @var float Зарплата до вычета взносов и услуг */
    public float $baseSum;

    /** @var float Сумма взносов за расчетный период */
    public float $unionContributionSum = 0;

    /** @var float Сумма услуг за расчетный период */
    public float $servicesChargeSum = 0;

    /** @var float Зарплата после вычета взносов и услуг */
    public float $totalSum = 0;
}
