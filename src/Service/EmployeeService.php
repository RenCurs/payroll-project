<?php

namespace App\Service;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
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
}
