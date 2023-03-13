<?php

namespace App\Controller\catalog;

use App\DTO\SearchGenreCriteria;
use App\Entity\Genre;
use App\Form\SearchGenreType;
use App\Repository\GenreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    /**
    * Genre list and search
    */
    #[Route('/catalog/genres', name: 'app_GenreController_searchGenreList')]
    public function searchGenreList(GenreRepository $genreRepository, Request $request, SearchGenreCriteria $searchGenreCriteria, PaginatorInterface $paginator): Response
    {
        $genres = $genreRepository->findAll();

        $form = $this->createForm(SearchGenreType::class, $searchGenreCriteria);
        $form->handleRequest($request);
         
        if ($form->isSubmitted() && $form->isValid())
        {
            $searchGenreCriteria = $form->getData();

            $genres = $genreRepository->findByCriteria($searchGenreCriteria);

            $data = $paginator->paginate(
                $genres,
                $request->query->getInt('page', 1),
                10
            );

            return $this->render('catalog/genre/searchGenreList.html.twig',[
                'form' => $form->createView(),
                'genres' => $data
            ]);
        }

        $data = $paginator->paginate(
            $genres,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('catalog/genre/searchGenreList.html.twig',[
            'form' => $form->createView(),
            'genres' => $data
        ]);
    }

    /**
    * get books from a specific genre 
    */
    #[Route('/catalog/genres/{id}', name: 'app_GenreController_viewGenre')]
    public function viewGenre(Request $request, Genre $genre, PaginatorInterface $paginator): Response
    {
        if($genre){

            $data = $paginator->paginate(
                $genre->getBooks(),
                $request->query->getInt('page', 1),
                10,
            );

            return $this->render('catalog/genre/viewGenre.html.twig',[
                'genreTitle' => $genre->getTitle(),
                'books' => $data,

            ]);
        }
    }
    
}
