<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderConfirmationType;
use App\Repository\CartRepository;
use App\Repository\OrderRepository;
use DateTime;
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
            $data = $request->get('data');

            $cart = $user->getCart();

            $form = $this->createForm(OrderConfirmationType::class);

            $form->handleRequest($request);

            if($form->isSubmitted()){
                $order = new Order();

                $order->setUser($user);

                foreach ($cart->getBooks() as $book){
                    $order->addBook($book);
                }

                $order->setTotalPrice($data['total'])
                ->setNumberOfBooksInCart($data['numberOfBooksInCart'])
                ->setOrderedDate(new DateTime());

                $user->addOrder($order);

                $orderRepository->save($order,true);

                $cart->removeAllBooks();

                $cartRepository->save($cart,true);

                return $this->redirectToRoute('app_CartController_displayCart');

            }

            return $this->render('order/order-confirmation.html.twig', [
                'form' => $form->createView(),
                'books' => $cart->getBooks(),
                'numberOfBooksInCart' => $data["numberOfBooksInCart"],
                'total' => $data['total']
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
