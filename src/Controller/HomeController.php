<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index', methods: ['GET'])]
    public function index(Request $request, BookRepository $bookRepository, PaginatorInterface $paginator): Response
    {

        $books = $bookRepository->findAll();

        $data = $paginator->paginate(
            $books,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('home/index.html.twig',[
            'books' => $data
        ]);
    }

    
}
