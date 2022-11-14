<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertisementController extends AbstractController
{
    #[Route('/rechercher', name: 'app_advertisement_rechercher')]
    public function rechercher(): Response
    {
        return new Response('Rechercher');
    }

    #[Route('annonces-livre/{id}', name: 'app_advertisement_annonce')]
    public function annonce(int $id): Response
    {
        return new Response("Annonce n°$id");
    }
}
