<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminGenreController extends AbstractController
{
    #[Route('/admin/genre', name: 'app_admin_genre')]
    public function index(): Response
    {
        return $this->render('admin_genre/index.html.twig', [
            'controller_name' => 'AdminGenreController',
        ]);
    }
}
