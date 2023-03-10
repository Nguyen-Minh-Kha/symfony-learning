<?php

namespace App\Controller\catalog;

use App\DTO\SearchAuthorCriteria;
use App\Form\SearchAuthorType;
use App\Repository\AuthorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
