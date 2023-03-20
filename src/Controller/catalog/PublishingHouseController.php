<?php

namespace App\Controller\catalog;

use App\Form\SearchPublishingHouseType;
use App\DTO\SearchPublishingHouseCriteria;
use App\Entity\PublishingHouse;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\PublishingHouseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublishingHouseController extends AbstractController
{
    /**
    * Search house and list 
    */
    #[Route('/catalog/publishing-houses', name: 'app_PublishingHouseController_searchHouseList')]
    public function searchHouseList(PublishingHouseRepository $publishingHouseRepository, Request $request, SearchPublishingHouseCriteria $searchPublishingHouseCriteria, PaginatorInterface $paginator): Response
    {
        $houses = $publishingHouseRepository->findAll();

        $form = $this->createForm(SearchPublishingHouseType::class, $searchPublishingHouseCriteria);
        $form->handleRequest($request);
         
        if ($form->isSubmitted() && $form->isValid())
        {
            $searchPublishingHouseCriteria = $form->getData();

            $houses = $publishingHouseRepository->findByCriteria($searchPublishingHouseCriteria);

            $data = $paginator->paginate(
                $houses,
                $request->query->getInt('page', 1),
                10
            );

            return $this->render('catalog/publishing_house/searchPublishingHouseList.html.twig',[
                'form' => $form->createView(),
                'houses' => $data
            ]);
        }

        $data = $paginator->paginate(
            $houses,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('catalog/publishing_house/searchPublishingHouseList.html.twig',[
            'form' => $form->createView(),
            'houses' => $data
        ]);

    }

    /**
    * view publish house books list
    */
    #[Route('/catalog/publishing-house/{id}', name: 'app_PublishingHouseController_viewHouse')]
    public function viewHouse(Request $request, PublishingHouse $house, PaginatorInterface $paginator): Response
    {
        if($house){
            $data = $paginator->paginate(
                $house->getBooks(),
                $request->query->getInt('page', 1),
                10,
            );

            return $this->render('catalog/publishing_house/viewPublishingHouse.html.twig',[
                'houseName' => $house->getName(),
                'books' => $data,
            ]);
        }
    }
}
