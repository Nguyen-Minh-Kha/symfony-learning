<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminUserController extends AbstractController
{
    #[Route('/admin/users/create', name: "app_AdminUserController_create", methods: ['GET', 'POST'])]
    public function create(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher): Response
    {
        //create form and render 
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $user
                ->setRoles($user->getRoles()[0])
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime());

            $cryptedPass = $hasher->hashPassword($user, $user->getPassword());

            $user->setPassword($cryptedPass);

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_AdminUserController_list');
        }

        return $this->render('admin_user/create.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/users', name: "app_AdminUserController_list", methods: ['GET'])]
    public function list(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        if ($request->isMethod(Request::METHOD_GET)) {
            $users = $userRepository->findAll();

            $data = $paginator->paginate(
                $users,
                $request->query->getInt('page', 1),
                10
            );

            return $this->render('admin_user/list.html.twig', [
                'users' => $data,
            ]);
        }
    }

    #[Route('/admin/users/{id}', name: "app_AdminUserController_update", methods: ['GET', 'POST'])]
    public function update(User $user, Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserType::class, $user, [
            'mode' => 'update'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setUpdatedAt(new DateTime());

            $cryptedPass = $hasher->hashPassword($user, $user->getPassword());

            $user->setPassword($cryptedPass);
            
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_AdminUserController_list');
        }

        return $this->render('admin_user/update.html.twig', [
            'user' => $user,
            'userForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/users/{id}/delete', name: "app_AdminUserController_delete", methods: ['GET'])]
    public function delete(User $user, UserRepository $userRepository)
    {
        $userRepository->remove($user, true);

        return $this->redirectToRoute('app_AdminUserController_list');
    }
}
