<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Service\EmployeeService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
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

    /**
     * @Route("/employees", name="get_employees_list", methods={"GET"})
     */
    public function getEmployeesList(): Response
    {
        $employees  = $this->service->findAll();
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
}
