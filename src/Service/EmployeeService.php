<?php

namespace App\Service;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployeeService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
    }

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

    public function createOrUpdate(Employee $employee, ?int $id): Employee
    {
        // TODO Add validaton
        // TODO Save and update
    }
}
