<?php

namespace App\Service\Calculate;

use App\Component\TimeSpentDto;
use App\Entity\Employee;
use App\Entity\TimeCard;
use App\Enum\TimeTypeEnum;
use App\Exception\NotFullyWorkingHours;
use App\Factory\PaymentCalculate;
use App\Repository\TimeCardRepository;
use DateTime;

class HourlySalaryCalculate extends AbstractCalculate implements PaymentCalculate
{
    private const NORMAL = 8;
    private const OVER_TIME_MULTIPLE_RATE = 2;

    private DateTime $payDate;
    private TimeCardRepository $timeCardRepository;

    public function __construct(DateTime $payDate, Employee $employee, TimeCardRepository $timeCardRepository)
    {
        parent::__construct($employee);

        $this->payDate = $payDate;
        $this->employee = $employee;
        $this->timeCardRepository = $timeCardRepository;
    }

    protected function calculateSalary(): float {

        $spentTimes = $this->constructTimeSpent($this->timeCardRepository->getTimeCardsForWeek($this->payDate));
        $totalPrimarySalary = $totalOverTimeSalary = 0;

        /** @var TimeSpentDto $timeSpentDto */
        foreach ($spentTimes as $timeSpentDto) {
            $primarySalary = $this->calculatePrimaryTime($timeSpentDto);
            $overTimeSalary = $this->calculateOverTime($timeSpentDto);

            try {
                $this->validatePrimarySpentTime($timeSpentDto);
            } catch (NotFullyWorkingHours $exception) {
                // todo log
                $primarySalary = $this->calculatePrimaryTimeByOverTime($timeSpentDto);
                $overTimeSalary = $this->calculateOverTime($timeSpentDto);
            }

            $totalOverTimeSalary += $primarySalary;
            $totalOverTimeSalary += $overTimeSalary;
        }

        return $totalPrimarySalary  + $totalOverTimeSalary;
    }

    private function calculatePrimaryTime(TimeSpentDto $dto): float
    {
        $primaryTime = array_sum($dto->primaryTime);

        // todo Пока неясно, а нужно ли вообще такое вводить?
        // todo А если работника перевыполнил норму рабочего времени, но ничего не указано в дополнительном.
        // Например, 2 записи по 6 часов с основным типом времени
        if (self::NORMAL < $primaryTime) {
            $diff = $primaryTime - self::NORMAL;
            $primaryTime = self::NORMAL;
            $dto->overTime[] = $diff;
        }


        return $primaryTime * $this->employee->getHourTariff();
    }

    private function calculateOverTime(TimeSpentDto $dto): float
    {
        return array_sum($dto->overTime) * $this->employee->getHourTariff() * self::OVER_TIME_MULTIPLE_RATE;
    }

    private function calculatePrimaryTimeByOverTime(TimeSpentDto $dto): float
    {
        // Рабочий невыполнил норму рабочего времени, но указал что-то в дополнительном
        // Сейчас, если за день не отработал 8 часов, то текущее значение трат основного времени дополняется времени неурочным
        // Позже подумать, как быть в таких ситуациях ?
        $primaryTime =  array_sum($dto->primaryTime);

        foreach ($dto->overTime as $index => $overTime) {
            $primaryTime += $overTime;

            if ( self::NORMAL < $primaryTime) {
                $diff = $primaryTime - self::NORMAL;
                $primaryTime = self::NORMAL;
                $dto->overTime[] = $diff;

                unset($dto->overTime[$index]);
                break;
            }
        }

        if (self::NORMAL > $primaryTime) {
            $dto->overTime = [];
        }

        return $primaryTime * $this->employee->getHourTariff();
    }

    /**
     * Формирует массив потраченного времени по дате, где дата является ключом
     *
     * @param TimeCard[] $timeCards
     *
     * @return array<string, TimeSpentDto>
     */
    private function constructTimeSpent(array $timeCards): array
    {
        $result = [];

        foreach($timeCards as $card) {
            $dateString = ($card->getDate())->format('Y-m-d');

            if (false === array_key_exists($dateString, $result)) {
                $dto = new TimeSpentDto();
                $dto->date = $card->getDate();
                $result[$dateString] = $dto;
            }

            if (TimeTypeEnum::PRIMARY === $card->getTypeTime()) {
                $result[$dateString]->primaryTime[] = ($card->getSpentHour());
            } else {
                $result[$dateString]->overTime[] = $card->getSpentHour();
            }
        }

        return $result;
    }

    /**
     * @throws NotFullyWorkingHours
     */
    private function validatePrimarySpentTime(TimeSpentDto $dto): void
    {
        // todo Опять же, как быть в ситуация, когда работник за день не выполнил норму, но работал в неурочное время ?
        $primaryTime = array_sum($dto->primaryTime);

        if (self::NORMAL > $primaryTime && !empty($dto->overTime)) {
            throw new NotFullyWorkingHours('Работник не отработал норму, но работал в неурочное время');
        }
    }
}
