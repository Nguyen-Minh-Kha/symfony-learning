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

    /**
    * get last x values of an array 
    */
    public function getLastXValuesOfAnArray(array $array, int $x)
    {
        sort($array);
        return array_slice($array, -$x);
    }

    // todo: show order details with a form and be able to update a user's order

    /**
    * show order details as admin and update the order
    * TODO: What to do when we change the price to an order that is already paid ? 
    */
    #[Route('/admin/order/{id}', name: 'app_AdminOrderController_update')]
    public function update(Order $order, Request $request, OrderRepository $orderRepository): Response
    {
        $dto = new NumberOfBooksInCart();

        $dto->setNumberOfBooks($order->getNumberOfBooksInCart());

        $form = $this->createForm(NumberOfBooksInCartType::class, $dto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $totalPrice = 0;

            $data = $form->getData();
            $numberOfBooks = $this->getLastXValuesOfAnArray($data->numberOfBooks, count($order->getBooks()));
            
            foreach ($numberOfBooks as $key => $value) {
                $totalPrice += $value * $order->getBooks()[$key]->getPrice();
            }
            
            $order->setTotalPrice($totalPrice);
            
            $order->setNumberOfBooksInCart($numberOfBooks);

            $orderRepository->save($order, true);

            return $this->redirectToRoute('app_AdminOrderController_update', [
                'id' => $order->getId(),
            ]);

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
