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

    public function findById(int $id): ?Employee
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
                ?->setFio($employee->getFio())
                ->setAddress($employee->getAddress())
                ->setDateBirth($employee->getDateBirth())
                ->setSalaryType($employee->getSalaryType())
                ->setPaymentSchedule($employee->getPaymentSchedule())
                ->setSalary($employee->getSalary())
                ->setHourTariff($employee->getHourTariff())
                ->setCommissionRate($employee->getCommissionRate())
                ->setIsUnionAffiliation($employee->getIsUnionAffiliation());
        } else {
            $existEmployee = $employee;
            $this->entityManager->persist($existEmployee);
        }

        $this->entityManager->flush();

        return $existEmployee;
    }

    public function delete(int $employeeId): void
    {
        $employee = $this->findById($employeeId);

        if (null === $employee) {
            return;
        }

        $this->entityManager->remove($employee);
        $this->entityManager->flush();
    }
}
