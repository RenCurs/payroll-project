<?php

namespace App\Component;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ErrorHelper
{
    public function __construct(private readonly TranslatorInterface $translator) {}

    public function getValidationErrors(ConstraintViolationListInterface $errors): array
    {
        $validationErrors = [];

        /** @var  ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            if (!empty($error->getPropertyPath())) {
                $validationErrors[] = $this->getValidationMessage($error);
            } else {
                $validationErrors[] = $error->getMessage();
            }

        }

        return $validationErrors;
    }

    private function getValidationMessage(ConstraintViolationInterface $error): string
    {
        $dotPosition = mb_strpos($error->getMessage(), '.');
        $translatedProperty = $this->translator->trans("property.employee.{$error->getPropertyPath()}");

        return mb_substr($error->getMessage(), 0, $dotPosition) . ': ' . $translatedProperty;
    }
}
