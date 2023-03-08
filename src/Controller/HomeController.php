<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {

        $books = $bookRepository->findAll();

        return $this->render('home/index.html.twig',[
            'books' => $books
        ]);
    }

    
}
