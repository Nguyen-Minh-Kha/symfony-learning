<?php

namespace App\Controller;

use DateTime;
use App\Entity\Order;
use Symfony\Component\Uid\Uuid;
use App\Repository\CartRepository;
use App\Form\OrderConfirmationType;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    /**
    * create a new order for the user
    */
    #[Route('/order/new', name: 'app_OrderController_new')]
    public function new(Request $request, OrderRepository $orderRepository, CartRepository $cartRepository): Response
    {
        $user = $this->getUser();

        if ($user && count($user->getCart()->getBooks())!==0){

            $total = $request->get('total');

            $numberOfBooksInCart = $request->get('numberOfBooksInCart');

            $cart = $user->getCart();

            $form = $this->createForm(OrderConfirmationType::class);

            $form->handleRequest($request);

            if($form->isSubmitted()){

                $uuid = Uuid::v6()->toRfc4122();

                $order = new Order();

                $order->setUser($user);
    
                    foreach ($cart->getBooks() as $book){
                        $order->addBook($book);
                    }
    
                    $order->setTotalPrice($total)
                    ->setNumberOfBooksInCart($numberOfBooksInCart)
                    ->setOrderedDate(new DateTime())
                    ->setUuid($uuid);

                    $user->addOrder($order);

                    $orderRepository->save($order,true);

                return $this->redirectToRoute('app_stripe', [
                    'total' => $total,
                    'uuid' => $uuid,
                ]);

            }

            return $this->render('order/order-confirmation.html.twig', [
                'form' => $form->createView(),
                'books' => $cart->getBooks(),
                'numberOfBooksInCart' => $numberOfBooksInCart,
                'total' => $total
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
    * get the user's history of orders
    */
    #[Route('/order/history', name: 'app_OrderController_showHistory')]
    public function showHistory(): Response
    {
        $user = $this->getUser();

        if ($user){
            $orders = $user->getOrders();

            return $this->render('order/order-history.html.twig', [
                'orders' => $orders,
            ]);
            
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
    * get the details of a user's order
    */
    #[Route('/order/{id}', name: 'app_OrderController_showOrder')]
    public function showOrder(Order $order): Response
    {
        $user = $this->getUser();

        if($user){
            return $this->render('order/order-detail.html.twig',[
                'order' => $order,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
    * validate the order after payment 
    */
    #[Route('/order/validate/{uuid}', name: 'app_OrderController_validate')]
    public function validate(Request $request, string $uuid, OrderRepository $orderRepository, CartRepository $cartRepository): Response
    {
        $user = $this->getUser();

        if ($user){
            $order = $orderRepository->findByUuid($uuid);

            $order->setSuccess(true);

            $orderRepository->save($order,true);

            $cart = $user->getCart();

            $cart->removeAllBooks();

            $cartRepository->save($cart,true);

            return $this->render('order/order-validation.html.twig',[
                'orderId' => $order->getId(),
            ]);

            
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
