<?php

namespace App\Service\Calculate;

use App\Entity\Employee;
use App\Factory\PaymentCalculate;
use App\Repository\SaleReceiptRepository;
use DateTime;

class JobpriceSalaryCalculate extends AbstractCalculate implements PaymentCalculate
{
    private SaleReceiptRepository $receiptRepository;
    private DateTime $payDate;

    public function __construct(DateTime $payDate, Employee $employee, SaleReceiptRepository $receiptRepository)
    {
        parent::__construct($employee);

        $this->receiptRepository = $receiptRepository;
        $this->payDate = $payDate;
    }

    protected function calculateSalary(): float
    {
        $sumSaleReceipt = $this->calculateSumFromSale();

        return (float) ($this->employee->getSalary()) + $sumSaleReceipt * ( $this->employee->getCommissionRate() / 100);
    }

    private function calculateSumFromSale(): float
    {
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
}
