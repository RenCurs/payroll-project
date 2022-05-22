<?php

namespace App\Service\Calculate;

use App\Entity\Employee;
use App\Entity\ServicesCharge;
use App\Entity\UnionContribution;
use App\Factory\PaymentCalculate;
use App\Repository\SaleReceiptRepository;
use App\Repository\ServicesChargeRepository;
use App\Repository\UnionContributionRepository;
use DateTime;

class JobpriceSalaryCalculate extends AbstractCalculate implements PaymentCalculate
{
    private SaleReceiptRepository $receiptRepository;

    public function __construct(
        DateTime $payDate,
        Employee $employee,
        SaleReceiptRepository $receiptRepository,
        ServicesChargeRepository $chargeRepository,
        UnionContributionRepository $contributionRepository
    ) {
        parent::__construct($payDate, $employee, $chargeRepository, $contributionRepository);

        $this->receiptRepository = $receiptRepository;
    }

    protected function calculateSalary(): float
    {
        $sumSaleReceipt = $this->calculateSumFromSale();

        return (float) ($this->employee->getSalary()) + $sumSaleReceipt * ( $this->employee->getCommissionRate() / 100);
    }

    private function calculateSumFromSale(): float
    {
        // Todo А не буду ли одни и теже записи попадаться в разных расчетных периодах, так как поиск идет по границам
        // включительно???
        $receipts = $this->receiptRepository->getSaleReceiptsForPeriod(
            $this->employee->getLastPayDate(),
            $this->payDate
        );

        $sum = 0;

        foreach ($receipts as $receipt) {
            $sum += $receipt->getAmount();
        }

        return $sum;
    }

    /**
     * @return array
     */
    protected function getUnionContributions(): array
    {
        $endDate = clone $this->payDate;
        $startDate = clone $this->employee->getLastPayDate();
        $startDate = $startDate->modify('+ 1 days');

        return $this->contributionRepository->getByPeriod($this->employee, $startDate, $endDate);
    }

    /**
     * @return array
     */
    protected function getServicesCharges(): array
    {
        $endDate = clone $this->payDate;
        $startDate = clone $this->employee->getLastPayDate();
        $startDate = $startDate->modify('+ 1 days');

        return $this->chargeRepository->getByPeriod($this->employee, $startDate, $endDate);
    }
}
