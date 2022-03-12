<?php

namespace App\Factory;

use App\Entity\Employee;
use App\Entity\TimeCard;
use App\Enum\PaymentTypeEnum;
use App\Repository\EmployeeRepository;
use App\Repository\SaleReceiptRepository;
use App\Repository\TimeCardRepository;
use App\Service\Calculate\FixedSalaryCalculate;
use App\Service\Calculate\HourlySalaryCalculate;
use App\Service\Calculate\JobpriceSalaryCalculate;
use DateTime;
use InvalidArgumentException;

class PaymentCalculateFactory
{
    private TimeCardRepository $timeCardRepository;
    private SaleReceiptRepository $receiptRepository;

    public function __construct(TimeCardRepository $timeCardRepository, SaleReceiptRepository $receiptRepository)
    {
        $this->timeCardRepository = $timeCardRepository;
        $this->receiptRepository = $receiptRepository;
    }

    public function create(DateTime $dateTime, Employee $employee): PaymentCalculate
    {
        switch ($employee->getSalaryType()) {
            case PaymentTypeEnum::FIXED:
                $calculate = new FixedSalaryCalculate($employee);

                break;
            case PaymentTypeEnum::HOURLY:
                $calculate = new HourlySalaryCalculate($dateTime, $employee, $this->timeCardRepository);

                break;
            case PaymentTypeEnum::JOBPRICE:
                $calculate = new JobpriceSalaryCalculate($dateTime, $employee, $this->receiptRepository);

                break;
            default:
                throw new InvalidArgumentException('Неизвестный тип оплаты для работника');
        }

        return $calculate;
    }
}