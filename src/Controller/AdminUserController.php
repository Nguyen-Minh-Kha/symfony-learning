<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    #[Route('/admin/users/create', name: "app_AdminUserController_create", methods: ['GET', 'POST'])]
    public function create(Request $request, UserRepository $userRepository): Response
    {
        if ($request->isMethod(Request::METHOD_GET)) {

            //create form and render 
            $form = $this->createForm(UserType::class);

            return $this->render('admin_user/create.html.twig', [
                'userForm' => $form->createView(),
            ]);
        } elseif ($request->isMethod(Request::METHOD_POST)) {

            $user = new User();

            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $user = $form->getData();

                $user->setCreatedAt(new DateTime())
                    ->setUpdatedAt(new DateTime());

                $userRepository->save($user, true);

                return $this->redirectToRoute('app_AdminUserController_create');
            }
        }
    }
}
