<?php

namespace App\Controller\catalog;

use App\Entity\Author;
use App\Form\SearchAuthorType;
use App\DTO\SearchAuthorCriteria;
use App\Repository\AuthorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    /**
    * Author list and search 
    */
    #[Route('/catalog/authors', name: 'app_AuthorController_searchAuthorList')]
    public function searchAuthorList(Request $request, SearchAuthorCriteria $searchAuthorCriteria, AuthorRepository $authorRepository, PaginatorInterface $paginator): Response
    {
        $authors = $authorRepository->findAll();

        $form = $this->createForm(SearchAuthorType::class, $searchAuthorCriteria);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchAuthorCriteria = $form->getData();

            $authors = $authorRepository->findByCriteria($searchAuthorCriteria);

            $data = $paginator->paginate(
                $authors, 
                $request->query->getInt('page', 1),
                10);

            return $this->render('catalog/author/searchAuthorList.html.twig',[
                'form' => $form->createView(),
                'authors' => $data
            ]);

        }

        $data = $paginator->paginate(
            $authors,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('catalog/author/searchAuthorList.html.twig',[
            'form' => $form->createView(),
            'authors' => $data
        ]);
    }

    /**
    * view list of books by author
    */
    #[Route('/catalog/authors/{id}', name: 'app_AuthorController_viewAuthor')]
    public function viewAuthor(Request $request, Author $author, PaginatorInterface $paginator): Response
    {
        if($author){
            $data = $paginator->paginate(
                $author->getBooks(),
                $request->query->getInt('page', 1),
                10,
            );

            return $this->render('catalog/author/viewAuthor.html.twig',[
                'authorName' => $author->getName(),
                'books' => $data,
            ]);
        }
    }
}
