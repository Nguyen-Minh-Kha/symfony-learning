<?php

namespace App\Controller;

use DateTime;
use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminGenreController extends AbstractController
{
    // #[Route('/admin/genre', name: 'app_admin_genre')]
    // public function index(): Response
    // {
    //     return $this->render('admin_genre/index.html.twig', [
    //         'controller_name' => 'AdminGenreController',
    //     ]);
    // }

    #[Route('/admin/genres/create', name: "app_AdminGenreController_create", methods: ['GET', 'POST'])]
    public function create(Request $request, GenreRepository $genreRepository): Response
    {
        $form = $this->createForm(GenreType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $genre = $form->getData();

            $genre
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime());

            $genreRepository->save($genre, true);

            return $this->redirectToRoute('app_AdminGenreController_list');
        }
        return $this->render('admin_genre/create.html.twig', [
            'genreForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/genres', name: "app_AdminGenreController_list", methods: ['GET'])]
    public function list(Request $request, GenreRepository $genreRepository, PaginatorInterface $paginator): Response
    {
        if ($request->isMethod(Request::METHOD_GET)) {
            $genres = $genreRepository->findAll();

            $data = $paginator->paginate(
                $genres,
                $request->query->getInt('page', 1),
                10
            );
            return $this->render('admin_genre/list.html.twig', [
                'genres' => $data,
            ]);
        }
    }

    #[Route('/admin/genres/{id}', name: "app_AdminGenreController_update", methods: ['GET', 'POST'])]
    public function update(Request $request, GenreRepository $genreRepository, Genre $genre): Response
    {
        $form = $this->createForm(GenreType::class, $genre, [
            'mode' => 'update'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genre = $form->getData();
            $genre->setUpdatedAt(new DateTime());
            $genreRepository->save($genre, true);

            return $this->redirectToRoute('app_AdminGenreController_list');
        }

        return $this->render('admin_genre/update.html.twig', [
            'genre' => $genre,
            'genreForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/genres/{id}/delete', name: "app_AdminGenreController_delete", methods: ['GET'])]
    public function delete(Genre $genre, GenreRepository $genreRepository)
    {
        $genreRepository->remove($genre, true);

        return $this->redirectToRoute('app_AdminGenreController_list');
    }
}
