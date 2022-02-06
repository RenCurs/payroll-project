<?php

namespace App\Service;

use App\Factory\PaymentCalculateFactory;
use App\Factory\PaymentScheduleFactory;
use App\Repository\EmployeeRepository;
use DateTime;

class CalculateSalary
{
    private EmployeeRepository $employeeRepository;
    private PaymentScheduleFactory $scheduleFactory;
    private PaymentCalculateFactory $calculateFactory;

    public function __construct(
        EmployeeRepository $employeeRepository,
        PaymentScheduleFactory $scheduleFactory,
        PaymentCalculateFactory $calculateFactory
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->scheduleFactory = $scheduleFactory;
        $this->calculateFactory = $calculateFactory;
    }

    public function execute(DateTime $date): void
    {
        $employees = $this->employeeRepository->findAll();

        foreach ($employees as $employee) {
            $paymentSchedule = $this->scheduleFactory->create($employee);
            if ($paymentSchedule->isPayDate($date)) {
                $paymentCalculate = $this->calculateFactory->create($employee);
                $paymentEmployee = $paymentCalculate->calculate();
                dump($paymentEmployee);
            }
        }
    }
}
