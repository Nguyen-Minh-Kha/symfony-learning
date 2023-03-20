<?php

namespace App\Controller;

use App\Entity\PublishingHouse;
use App\Form\PublishingHouseType;
use App\Repository\PublishingHouseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPublishingHouseController extends AbstractController
{
    #[Route('/admin/publishing/house', name: 'app_admin_publishing_house')]
    public function index(): Response
    {
        return $this->render('admin_publishing_house/index.html.twig', [
            'controller_name' => 'AdminPublishingHouseController',
        ]);
    }

    /**
    * create a new publishing house
    */
    #[Route('/admin/publishing-house/create', name: 'app_AdminPublishingHouseController_create', methods: ['GET', 'POST'])]
    public function create(Request $request, PublishingHouseRepository $publishingHouseRepository): Response
    {
        $form = $this->createForm(PublishingHouseType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            //récupérer les données du formulaire dans un objet PH
            $publishinghouse= $form->getData();

            //enregistrer la maison d'édition dans la bd grace au repository
            $publishingHouseRepository->save($publishinghouse, true);

            //redirection de l'utilisateur vers la liste des maisons d'édition
            return $this->redirectToRoute('app_AdminPublishingHouseController_list');
        }
        return $this->render('admin_publishing_house/create.html.twig', [
            'form' => $form->createView(), // génére le html du formulaire
        ]);
    }

    /**
    * list of publishing houses 
    */
    #[Route('/admin/publishing-house', name: 'app_AdminPublishingHouseController_list', methods: ['GET'])]
    public function list(PublishingHouseRepository $publishingHouseRepository, PaginatorInterface $paginator, Request $request): Response
    {
         $publishinghouses = $publishingHouseRepository->findAll();

         $data = $paginator->paginate(
            $publishinghouses,
            $request->query->getInt('page', 1),
            10
        );

         return $this->render('admin_publishing_house/list.html.twig',[
            'publishinghouses' => $data,
         ]);
    }

    /**
    * update a publishing house
    */
    #[Route('/admin/publishing-house/{id}', name: 'app_AdminPublishingHouseController_update', methods: ['GET', 'POST'])]
    public function update(Request $request, PublishingHouse $publishingHouse, PublishingHouseRepository $publishingHouseRepository): Response
    {
         $form = $this->createForm(PublishingHouseType::class, $publishingHouse, [
            'mode' => 'update'
         ]);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()){
            $publishinghouse= $form->getData();

            $publishingHouseRepository->save($publishingHouse, true);

            return $this->redirectToRoute('app_AdminPublishingHouseController_list');
        }
        return $this->render('admin_publishing_house\update.html.twig',[
            'form' => $form->createView(),
            'publishinghouse' => $publishingHouse,
        ]);
    }

    /**
    * remove a publishing house 
    */
    #[Route('/admin/publishing-house/{id}/delete', name: 'app_AdminPublishingHouseController_remove', methods: ['GET'])]
    public function remove(PublishingHouse $publishingHouse, PublishingHouseRepository $publishingHouseRepository): Response
    {
        $publishingHouseRepository->remove($publishingHouse, true);

        return $this->redirectToRoute('app_AdminPublishingHouseController_list');
    }
}
