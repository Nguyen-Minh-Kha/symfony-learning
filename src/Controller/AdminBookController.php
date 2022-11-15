<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookController extends AbstractController
{
    #[Route('/admin/book', name: 'app_admin_book')]
    public function index(): Response
    {
        return $this->render('admin_book/index.html.twig', [
            'controller_name' => 'AdminBookController',
        ]);
    }
}
