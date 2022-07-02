<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  @Route("/api", name="api_")
 */
class EmployeeController extends AbstractController
{
    /**
     * @Route("/employees/{id}", name="get_employee", methods={"GET"})
     */
    public function getEmployeeBydId(int $id): Response
    {
        return $this->json(['success' => true, 'id' => $id]);
    }
}
