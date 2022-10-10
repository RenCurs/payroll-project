<?php

namespace App\Validator;

use App\Entity\Employee;
use App\Enum\PaymentTypeEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class PaymentTypeConstraintValidator extends ConstraintValidator
{
    private string $mismatchPaymentType = '';

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PaymentTypeConstraint) {
            throw new UnexpectedTypeException($constraint, PaymentTypeConstraint::class);
        }

        if (!$value instanceof Employee) {
            throw new UnexpectedValueException($value, Employee::class);
        }

        $this
            ->checkFixedType($value)
            ->checkHourlyType($value)
            ->checkJobpriceType($value);

        if (!empty($this->mismatchPaymentType)) {
            $this->context
                ->buildViolation('error.validation.paymentType')
                ->setParameter('{{ type }}', $this->mismatchPaymentType)
                ->setTranslationDomain('messages')
                ->addViolation();

            $this->mismatchPaymentType = '';
        }
    }

    private function checkFixedType(Employee $employee): self
    {
        if (PaymentTypeEnum::FIXED === $employee->getSalaryType() && null === $employee->getSalary()) {
            $this->mismatchPaymentType = PaymentTypeEnum::FIXED;
        }

        return $this;
    }

    private function checkHourlyType(Employee $employee): self
    {
        if (PaymentTypeEnum::HOURLY === $employee->getSalaryType() && null === $employee->getHourTariff()) {
            $this->mismatchPaymentType = PaymentTypeEnum::HOURLY;
        }

        return $this;
    }

    private function checkJobpriceType(Employee $employee): self
    {
        if (PaymentTypeEnum::JOBPRICE === $employee->getSalaryType() && null === $employee->getCommissionRate()) {
            $this->mismatchPaymentType = PaymentTypeEnum::JOBPRICE;
        }

        return $this;
    }
}
