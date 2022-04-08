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
    private TimeCardRepository $timeCardRepository;
    private SaleReceiptRepository $receiptRepository;
    private ServicesChargeRepository $chargeRepository;
    private UnionContributionRepository $contributionRepository;

    public function __construct(
        TimeCardRepository $timeCardRepository,
        SaleReceiptRepository $receiptRepository,
        ServicesChargeRepository $chargeRepository,
        UnionContributionRepository $contributionRepository
    ) {
        $this->timeCardRepository = $timeCardRepository;
        $this->receiptRepository = $receiptRepository;
        $this->chargeRepository = $chargeRepository;
        $this->contributionRepository = $contributionRepository;
    }

    public function create(DateTime $dateTime, Employee $employee): PaymentCalculate
    {
        switch ($employee->getSalaryType()) {
            case PaymentTypeEnum::FIXED:
                $calculate = new FixedSalaryCalculate(
                    $dateTime,
                    $employee,
                    $this->chargeRepository,
                    $this->contributionRepository
                );

                break;
            case PaymentTypeEnum::HOURLY:
                $calculate = new HourlySalaryCalculate(
                    $dateTime,
                    $employee,
                    $this->timeCardRepository,
                    $this->chargeRepository,
                    $this->contributionRepository
                );

                break;
            case PaymentTypeEnum::JOBPRICE:
                $calculate = new JobpriceSalaryCalculate(
                    $dateTime,
                    $employee,
                    $this->receiptRepository,
                    $this->chargeRepository,
                    $this->contributionRepository
                );

                break;
            default:
                throw new InvalidArgumentException('Неизвестный тип оплаты для работника');
        }

        return $calculate;
    }
}