<?php

namespace App\Controller\catalog;

use App\DTO\SearchBookCriteria;
use App\Form\SearchBookType;
use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    /**
    * Catalog > Books list with search bar for all users 
    */
    #[Route('/catalog/books', name: 'app_BookController_searchBookList')]
    public function searchBookList(Request $request, BookRepository $bookRepository, SearchBookCriteria $searchBookCriteria, PaginatorInterface $paginator): Response
    {
        $books = $bookRepository->findAll();

        $form = $this->createForm(SearchBookType::class, $searchBookCriteria);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchBookCriteria = $form->getData();
            $books = $bookRepository->findByCriteria($searchBookCriteria);

            $data = $paginator->paginate(
                $books,
                $request->query->getInt('page', 1),
                10
            );

            return $this->render('catalog/book/searchBookList.html.twig',[
                'form' => $form->createView(),
                'books' => $data,
            ]);
        }

        $data = $paginator->paginate(
            $books,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('catalog/book/searchBookList.html.twig',[
            'form' => $form->createView(),
            'books' => $data
        ]);

    }


}
