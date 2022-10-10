<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Exception\ValidationException;
use App\Service\EmployeeService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route("/api", name: "api_")]
class EmployeeController extends AbstractController
{
    public function __construct(
        private readonly EmployeeService $service,
        private readonly SerializerInterface $serializer,
    ) {}

    #[Route("/employees/{id}", name: "get_employee", methods: ["GET"])]
    public function getEmployeeBydId(int $id): Response
    {
        $response = $this->serializer->serialize(
            $this->service->findById($id),
            'json',
            [
                'groups' => ['account'],
                // TODO возможно как-нибудь через св-во указать формат, что не дублировать?
                AbstractNormalizer::CALLBACKS => [
                    'dateBirth' => fn (DateTime $innerObject) => $innerObject->format('Y-m-d')
                ]
            ]
        );

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }

    #[Route("/employees", name: "get_employees_list", methods: ["GET"])]
    public function getEmployeesList(): Response
    {
        $response = $this->serializer->serialize(
            $this->service->findAll(),
            'json',
            [
                'groups' => ['account'],
                AbstractNormalizer::CALLBACKS => [
                    'dateBirth' => fn (DateTime $innerObject) => $innerObject->format('Y-m-d')
                ]
            ]
        );

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }

    /**
     * @throws ValidationException
     */
    #[Route(
        "/employees/update/{employeeId}",
        name: "update_employee",
        requirements: ["employeeId" => "\d+"],
        methods: ["PUT"]
    )]
    public function updateEmployee(Request $request, int $employeeId): Response
    {
        $employee = $this->serializer->deserialize($request->getContent(), Employee::class, 'json');
        $updatedEmployee = $this->service->createOrUpdate($employee, $employeeId);

        $response = $this->serializer->serialize(
            $updatedEmployee,
            'json',
            [
                'groups' => ['account'],
                AbstractNormalizer::CALLBACKS => [
                    'dateBirth' => fn(DateTime $innerObject) => $innerObject->format('Y-m-d')
                ]
            ]
        );

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }

    /**
     * @throws ValidationException
     */
    #[Route(
        "/employees/create",
        name: "create_employee",
        methods: ["POST"]
    )]
    public function createEmployee(Request $request): Response
    {
        $employee = $this->serializer->deserialize($request->getContent(), Employee::class, 'json');
        $updatedEmployee = $this->service->createOrUpdate($employee);

        $response = $this->serializer->serialize(
            $updatedEmployee,
            'json',
            [
                'groups' => ['account'],
                AbstractNormalizer::CALLBACKS => [
                    'dateBirth' => fn(DateTime $innerObject) => $innerObject->format('Y-m-d')
                ]
            ]
        );

        return new JsonResponse($response, Response::HTTP_CREATED, [], true);
    }
}
