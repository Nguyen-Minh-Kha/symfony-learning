<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\CartRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    /**
    * add book into the user's cart 
    */
    #[Route('/cart/{id}/add', name: 'app_CartController_addBook')]
    public function add(CartRepository $cartRepository, Book $book): Response
    {
        $cart = $this->getUser()->getCart();

        $cart->addBook($book);

        $cartRepository->save($cart, true);

        return $this->redirectToRoute('app_CartController_displayCart');
    }

    /**
    * display the user's cart
    */
    #[Route('/cart', name: 'app_CartController_displayCart')]
    public function displayCart(PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();

        // dd($user);

        if($user) {
            $cart = $user->getCart();

            if ($cart->getBooks()) {
                $data = $paginator->paginate(
                    $cart->getBooks(),
                    $request->query->getInt('page', 1),
                    10
                );
            } else {
                $data = null;
            }
            
            return $this->render('cart/display.html.twig',[
                'books' => $data,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
