<?php

namespace App\Controller;

use App\Entity\Order;
use App\DTO\NumberOfBooksInCart;
use App\Repository\OrderRepository;
use App\Form\NumberOfBooksInCartType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
    * show order details as admin 
    */
    #[Route('/admin/order/{id}', name: 'app_AdminOrderController_update')]
    public function update(Order $order, Request $request, OrderRepository $orderRepository): Response
    {
        $dto = new NumberOfBooksInCart();

        $dto->setNumberOfBooks($order->getNumberOfBooksInCart());

        $form = $this->createForm(NumberOfBooksInCartType::class, $dto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        } else {
            return $this->render('admin_order/update.html.twig', [
                'form' => $form->createView(),
                'order' => $order,
            ]);
        }
    }

    // todo: delete an order

    // todo: add a new order for a user

    // todo: delete a book from an order

    // todo: add a book to an order
}
