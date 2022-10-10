<?php

namespace App\Service;

use App\Component\Dto\PayCheckDto;
use App\Entity\Employee;
use App\Entity\PayCheck;
use App\Factory\PaymentCalculateFactory;
use App\Factory\PaymentScheduleFactory;
use App\Repository\EmployeeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;


class CalculateSalary
{
    public function __construct(private readonly EmployeeRepository $employeeRepository, private readonly PaymentScheduleFactory $scheduleFactory, private readonly PaymentCalculateFactory $calculateFactory, private readonly EntityManagerInterface $entityManager)
    {
    }

    public function execute(DateTime $date): void
    {
        // TODO Добавить получение порциями
        $employees = $this->employeeRepository->findAll();

        foreach ($employees as $employee) {
            $paymentSchedule = $this->scheduleFactory->create($employee);
            $payDate = clone $date;

            if ($paymentSchedule->isPayDate($payDate)) {
                $paymentCalculate = $this->calculateFactory->create($payDate, $employee);
                $this->savePayCheck($employee, $paymentCalculate->calculate(), $payDate);
            }
        }
    }

    private function savePayCheck(Employee $employee, PayCheckDto $payCheckDto, DateTime $payDate): void
    {
        $check = (new PayCheck())
            ->setEmployee($employee)
            ->setSum($payCheckDto->baseSum)
            ->setServicesCharge($payCheckDto->servicesChargeSum)
            ->setUnionContribution($payCheckDto->unionContributionSum)
            ->setTotalSum($payCheckDto->totalSum)
            ->setDate($payDate);

        $this->entityManager->persist($check);
        $this->entityManager->flush();
    }
}
