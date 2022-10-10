<?php

use Symfony\Component\Validator\Constraint;

/**
 * Ограничение для проверки, что указан один и только один из доступных типов оплаты
 */
#[Attribute]
class SalaryConstraint extends Constraint
{
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
