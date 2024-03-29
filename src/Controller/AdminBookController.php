<?php

namespace App\Controller;

use App\Entity\Book;
use DateTime;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\GenreRepository;
use App\Repository\PublishingHouseRepository;
use Knp\Component\Pager\PaginatorInterface;
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

    #[Route('/admin/book/create', name: 'app_AdminBookController_create', methods: ['GET', 'POST'])]
    public function create(
        Request $request, 
        BookRepository $repository,
        AuthorRepository $authorRepository,
        GenreRepository $genreRepository,
        PublishingHouseRepository $publishingHouseRepository
        ): Response
    {
        $form = $this->createForm(BookType::class,null ,[
            'authors' => $authorRepository->findAll(),
            'genres' => $genreRepository->findAll(),
            'houses' => $publishingHouseRepository->findAll(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $book   
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime());

            $repository->save($book, true);
            return $this->redirectToRoute('app_AdminBookController_list');
        }
        
        return $this->render('admin_book/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/book', name: 'app_AdminBookController_list', methods: ['GET'])]
    public function list(Request $request, BookRepository $repository, PaginatorInterface $paginator): Response
    {
        if ($request->isMethod(Request::METHOD_GET)) {
            $books = $repository->findAll();

            $data = $paginator->paginate(
                $books,
                $request->query->getInt('page', 1),
                10
            );

            return $this->render('admin_book/list.html.twig', ['books' => $data]);
        }
    }

    #[Route('/admin/book/{id}', name: 'app_AdminBookController_update', methods: ['GET', 'POST'])]
    public function update(Request $request, 
    BookRepository $repository, 
    Book $book,
    AuthorRepository $authorRepository,
    GenreRepository $genreRepository,
    PublishingHouseRepository $publishingHouseRepository
    ): Response
    {
        
        $form = $this->createForm(BookType::class, $book, [
            'mode' => 'update',
            'authors' => $authorRepository->findAll(),
            'genres' => $genreRepository->findAll(),
            'houses' => $publishingHouseRepository->findAll(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $book->setUpdatedAt(new DateTime());

            $repository->save($book, true);

            return $this->redirectToRoute('app_AdminBookController_list');
        }

        return $this->render('admin_book/update.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }
    

    #[Route('/admin/book/{id}/delete', name: 'app_AdminBookController_delete', methods: ['GET'])]
    public function delete(Request $request, BookRepository $repository, Book $book) 
    {
        
        $repository->remove($book, true);

        return $this->redirectToRoute('app_AdminBookController_list');
        
    }
}
