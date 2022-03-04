<?php

namespace App\Service\Calculate;

use App\Entity\TimeCard;
use App\Factory\PaymentCalculate;

class HourlySalaryCalculate extends AbstractCalculate implements PaymentCalculate
{
    private const NORMAL = 8;

    public function calculate(): float
    {
        $salary = $this->calculateSalary();
        $this->subUnionContribution($salary);
        $this->subUnionServiceCharge($salary);

        return $salary;
    }

    private function calculateSalary(): float {
        $currentSpent = 0;
        $upTimeSpent = 0;

        $tariffRate = $this->employee->getHourTariff();

        $timeCards = $this->reindexByDate($this->employee->getTimeCards()->toArray());

        // todo Упростить расчет, разбить на разные методы. Сама подсчет вроде верный
        foreach ($timeCards as $spentHours) {
            $currentSpentDay = 0;
            $upTimeSpentDay = 0;

            foreach ($spentHours as $hour) {
                if ($currentSpentDay < self::NORMAL) {
                    $currentSpentDay = +$hour;
                }

                if ($currentSpentDay >= self::NORMAL) {
                    $upTimeSpentDay += $hour;
                }

                $currentSpent = $currentSpentDay;
                $upTimeSpent = $upTimeSpentDay;
            }
        }

        $primarySalary = $currentSpent * $tariffRate;
        $upSalary = $upTimeSpent * 2 * $tariffRate;

        return $primarySalary + $upSalary;
    }

    /**
     * Формирует массив потраченного времени по дате, где дата является ключом
     * Пример: [
     *              '2022-01-01 => [4, 5, 2],
     *              '2022-01-02 => [8]
     *         ]
     * @param TimeCard[] $timeCards
     */
    private function reindexByDate(array $timeCards): array
    {
        $result = [];

        foreach($timeCards as $card) {
            $dateString = ($card->getDate())->format('Y-m-d');
            $result[$dateString][] = $card->getSpentHour();
        }

        return $result;
    }
}
