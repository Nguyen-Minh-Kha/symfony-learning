<?php

namespace App\Controller;

use DateTime;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookController extends AbstractController
{
    // #[Route('/admin/book', name: 'app_admin_book')]
    // public function index(): Response
    // {
    //     return $this->render('admin_book/index.html.twig', [
    //         'controller_name' => 'AdminBookController',
    //     ]);
    // }

    #[Route('/admin/book/create', name: 'app_admin_book_create', methods: ['GET', 'POST'])]
    public function create(Request $request, BookRepository $repository): Response
    {
        if ($request->isMethod(Request::METHOD_GET)) {

            // render form template
            return $this->render('admin_book/create.html.twig');
        } elseif ($request->isMethod(Request::METHOD_POST)) {

            // get form data with verification
            $title = $request->request->has('title') ? $request->request->get('title') : false;
            $description = $request->request->has('description') ? $request->request->get('description') : "";
            $genre = $request->request->has('genre') ? $request->request->get('genre') : "";

            if (!$title) {
                // send to error page title empty
            }

            // add new book to repository
            $book = (new Book())
                ->setTitle($title)
                ->setDescription($description)
                ->setGenre($genre)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime());

            $repository->save($book, true);

            return $this->redirectToRoute('app_admin_book_list');
        }
    }

    #[Route('/admin/book', name: 'app_admin_book_list', methods: ['GET'])]
    public function list(Request $request, BookRepository $repository): Response
    {
        if ($request->isMethod(Request::METHOD_GET)) {
            $books = $repository->findAll();

            return $this->render('admin_book/list.html.twig', ['books' => $books]);
        }
    }
}
