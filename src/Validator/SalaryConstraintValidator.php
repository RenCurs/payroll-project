<?php

use App\Entity\Employee;
use App\Enum\PaymentTypeEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class SalaryConstraintValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof SalaryConstraint) {
            throw new UnexpectedTypeException($constraint, SalaryConstraint::class);
        }

        if (!$value instanceof Employee) {
            throw new UnexpectedValueException($value, Employee::class);
        }

        $specifiedSalary = array_filter([
            PaymentTypeEnum::HOURLY => $value->getHourTariff(),
            PaymentTypeEnum::FIXED => $value->getSalary(),
            PaymentTypeEnum::JOBPRICE => $value->getCommissionRate(),
        ]);

        if (empty($specifiedSalary) || count($specifiedSalary) > 1) {
            $this->context
                ->buildViolation('error.validation.salary')
                ->setTranslationDomain('messages')
                ->setParameter('{{ allTypes }}', trim(implode(', ', PaymentTypeEnum::getTypes())))
                ->setParameter('{{ specifiedTypes }}', trim(implode(', ', array_keys($specifiedSalary))))
                ->addViolation();
        }
    }
}
