<?php

namespace App\Controller;

use App\DTO\NumberOfBooksInCart;
use App\Entity\Book;
use App\Form\NumberOfBooksInCartType;
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
    * check arrayOne is countable then add the number of default values into the array of DTO in 2nd parameter
    */
    public function addDefaultNumber($arrayOne, NumberOfBooksInCart $arrayTwo)
    {
        if(is_countable($arrayOne)){
            for($i = 0; $i < count($arrayOne); $i++){
                $arrayTwo->initialize(1);
            }
        }
    }

    /**
    * display the user's cart
    */
    #[Route('/cart', name: 'app_CartController_displayCart')]
    public function displayCart(
        Request $request, 
        NumberOfBooksInCart $numberOfBooksInCart
        ): Response
    {
        $user = $this->getUser();
   
        if($user) {
            $cart = $user->getCart();

            if ($cart->getBooks()) {
                $data = $cart->getBooks();
                $this->addDefaultNumber($data, $numberOfBooksInCart);
            } else {
                $data = null;
            }

            $form = $this->createForm(NumberOfBooksInCartType::class, $numberOfBooksInCart);

            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()){
                $total = 0;
                $numberOfBooksInCart = $form->getData();
                for ($i=0; $i < $numberOfBooksInCart->getLength(); $i++) { 
                    $total += $numberOfBooksInCart->numberOfBooks[$i] * $data->toArray()[$i]->getPrice();
                }
                
                return $this->redirectToRoute('app_OrderController_new', [
                    'total' => $total,
                    'numberOfBooksInCart' => $numberOfBooksInCart->numberOfBooks,
                ]);
                
            }
            
            return $this->render('cart/display.html.twig',[
                'books' => $data,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
    * delete book from cart
    */
    #[Route('/cart/{id}/delete', name: 'app_CartController_deteleBook')]
    public function deteleBook(CartRepository $cartRepository, Book $book, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();

        if($user){
            $cart = $user->getCart();

            $cart->removeBook($book);

            $cartRepository->save($cart, true);

            return $this->redirectToRoute('app_CartController_displayCart');

        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
