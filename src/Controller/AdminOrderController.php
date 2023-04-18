<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminOrderController extends AbstractController
{
    /**
    * show all orders of every user 
    */
    #[Route('/admin/order', name: 'app_AdminOrderController_list')]
    public function list(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();

        return $this->render('admin_order/list.html.twig', [
            "orders" => $orders,
        ]);
    }

    // todo: show order details with a form and be able to update a user's order

    // todo: delete an order

    // todo: show all orders of a user

    // todo: add a new order for a user
}
