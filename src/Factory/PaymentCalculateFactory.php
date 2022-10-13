<?php

namespace App\Factory;

use App\Entity\Employee;
use App\Entity\TimeCard;
use App\Enum\PaymentTypeEnum;
use App\Repository\EmployeeRepository;
use App\Repository\SaleReceiptRepository;
use App\Repository\ServicesChargeRepository;
use App\Repository\TimeCardRepository;
use App\Repository\UnionContributionRepository;
use App\Service\Calculate\FixedSalaryCalculate;
use App\Service\Calculate\HourlySalaryCalculate;
use App\Service\Calculate\JobpriceSalaryCalculate;
use DateTime;
use InvalidArgumentException;

class PaymentCalculateFactory
{
    public function __construct(
        private readonly TimeCardRepository $timeCardRepository,
        private readonly SaleReceiptRepository $receiptRepository,
        private readonly ServicesChargeRepository $chargeRepository,
        private readonly UnionContributionRepository $contributionRepository
    ) {}

    public function create(DateTime $dateTime, Employee $employee): PaymentCalculate
    {
        $payDate = clone $dateTime;

        return match ($employee->getSalaryType()) {
            PaymentTypeEnum::FIXED => new FixedSalaryCalculate(
                $payDate,
                $employee,
                $this->chargeRepository,
                $this->contributionRepository
            ),
            PaymentTypeEnum::HOURLY => new HourlySalaryCalculate(
                $payDate,
                $employee,
                $this->timeCardRepository,
                $this->chargeRepository,
                $this->contributionRepository
            ),
            PaymentTypeEnum::JOBPRICE => new JobpriceSalaryCalculate(
                $payDate,
                $employee,
                $this->receiptRepository,
                $this->chargeRepository,
                $this->contributionRepository
            ),
            default => throw new InvalidArgumentException('Неизвестный тип оплаты для работника'),
        };
    }
}
