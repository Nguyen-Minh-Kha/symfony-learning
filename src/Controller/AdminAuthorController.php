<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAuthorController extends AbstractController
{
    /**
    * Create new Author 
    */
    #[Route('/admin/author/create', name: 'app_AdminAuthorController_create', methods: ['GET', 'POST'])]
    public function create(Request $request, AuthorRepository $authorRepository): Response
    {
        //création du formulaire je n'ai pas besoin d'ajouter un objet Author en paramétre car je ne fait pas de préremplissage
        $form = $this->createForm(AuthorType::class);
        //remplir le formulaire avec les données envoyées par l'utilisateur
        $form->handleRequest($request);


        //tester si le formulaire a était envoyé et est valide
        if ($form->isSubmitted() && $form->isValid()) {

            //récupérer les données du formulaire dans un objet author
            $author = $form->getData();

            //enregistrer l'auteur dans la bd grace au repository
            $authorRepository->save($author, true);

            //redirection de l'utilisateur vers la liste des auteurs
            return $this->redirectToRoute('app_AdminAuthorController_list');
        }
        return $this->render('admin_author/create.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
    * List of authors 
    */
    #[Route('/admin/author', name: 'app_AdminAuthorController_list', methods: ['GET'])]
    public function list(Request $request, AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();

        return $this->render('admin_author/list.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
    * edit an author 
    */
    #[Route('/admin/author/{id}', name: 'app_AdminAuthorController_update', methods: ['GET', 'POST'])]
    public function update(Author $author, AuthorRepository $authorRepository, Request $request): Response
    {
         $form = $this->createForm(AuthorType::class, $author,['mode'=>'update']);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {

            //récupérer les données du formulaire dans un objet author
            $author = $form->getData();

            //enregistrer l'auteur
            $authorRepository->save($author, true);

            //redirection vers la page de liste
            return $this->redirectToRoute('app_AdminAuthorController_list');
        }

        return $this->render('admin_author/update.html.twig', [
            'form' => $form->createView(),
            'author' => $author
        ]);
    }

    /**
    * Delete an author 
    */
    #[Route('/admin/author/{id}/delete', name: 'app_AdminAuthorController_delete', methods: ['GET'])]
    public function delete(Author $author, AuthorRepository $authorRepository): Response
    {
         $authorRepository->remove($author, true);

         return $this->redirectToRoute('app_AdminAuthorController_list');
    }
    
}
