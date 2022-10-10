<?php

namespace App\Service;

use App\Component\ErrorHelper;
use App\Entity\Employee;
use App\Exception\ValidationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployeeService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
        private readonly ErrorHelper $errorHelper,
    ) {}

    /**
     * @return Employee[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Employee::class)->findAll();
    }

    public function findById(int $id): Employee
    {
        return $this->entityManager->getRepository(Employee::class)->find($id);
    }

    /**
     * @throws ValidationException
     */
    public function createOrUpdate(Employee $employee, ?int $id = null): Employee
    {
        $errors = $this->validator->validate($employee);

        if (count($errors) > 0) {
            throw new ValidationException($this->errorHelper->getValidationErrors($errors));
        }

        if (null !== $id) {
            $existEmployee = $this->findById($id);
            $existEmployee
                ->setAddress($employee->getAddress())
                ->setFio($employee->getFio())
                ->setDateBirth($employee->getDateBirth())
                ->setSalaryType($employee->getSalaryType())
                ->setPaymentSchedule($employee->getPaymentSchedule());
        } else {
            $existEmployee = $employee;
            $this->entityManager->persist($existEmployee);
        }

        $this->entityManager->flush();

        return $existEmployee;
    }
}
