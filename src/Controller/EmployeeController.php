<?php

namespace App\Controller;

use App\Service\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 *  @Route("/api", name="api_")
 */
class EmployeeController extends AbstractController
{
    private EmployeeService $service;
    private SerializerInterface $serializer;

    public function __construct(EmployeeService $service, SerializerInterface $serializer)
    {
        $this->service = $service;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/employees/{id}", name="get_employee", methods={"GET"})
     */
    public function getEmployeeBydId(int $id): Response
    {
        $response = $this->serializer->serialize(
            $this->service->findById($id),
            'json',
            ['groups' => ['account']]
        );

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/employees", name="get_employees_list", methods={"GET"})
     */
    public function getEmployeesList(): Response
    {
        $response = $this->serializer->serialize($this->service->findAll(), 'json', ['groups' => ['account']]);

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }
}
