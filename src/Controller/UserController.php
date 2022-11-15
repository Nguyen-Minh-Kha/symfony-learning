<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/connexion', name: 'app_user_connexion', methods: ['GET'])]
    public function connexion(): Response
    {
        return new Response('Conexion');
    }

    #[Route('/inscription', name: 'app_user_inscription')]
    public function inscription(): Response
    {
        return new Response('Inscription', 501);
    }
}
