<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Stripe;

class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function index(Request $request): Response
    {

        $total = $request->get('total');
        $uuid = $request->get('uuid');

        return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
            'stripe_key' => $_ENV['STRIPE_KEY'],
            'total' => $total,
            'uuid' => $uuid
        ]);
    }

    #[Route('/stripe/create-charge/{total}/{uuid}', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request, float $total, string $uuid)
    {

        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        Stripe\Charge::create ([
                "amount" => intval($total*100),
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'),
                "description" => "Payment for order " . $uuid,
        ]);
        $this->addFlash(
            'success',
            'Payment Successful!'
        );

        return $this->redirectToRoute('app_OrderController_validate', ['uuid' => $uuid], Response::HTTP_SEE_OTHER);
    }
}
