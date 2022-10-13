<?php

namespace App\Controller;


use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ["POST"])]
    public function index(): Response
    {
        $code = Response::HTTP_OK;
        /** @var Client $response */
        $response = $this->getUser();

        return $this->json($response, $code, [], ['groups' => 'auth']);
    }
}
