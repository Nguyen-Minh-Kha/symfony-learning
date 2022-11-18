<?php

namespace App\Controller;

use DateTime;
use App\Form\GenreType;
use App\Repository\GenreRepository;
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

            return $this->redirectToRoute('');
        }
        return $this->render('admin_genre/create.html.twig', [
            'genreForm' => $form->createView(),
        ]);
    }
}
