<?php

namespace App\Controller;

use App\Form\ProfileType;
use DateTime;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{

    /**
    * signup method 
    */
    #[Route('/signup', name: 'app_SecurityController_signup')]
    public function signup(UserRepository $userRepository, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(RegistrationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();

            $user
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime());

            $cryptedPass = $hasher->hashPassword($user, $user->getPassword());

            $user->setPassword($cryptedPass);

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_home_index');
        }

        return $this->render('security/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
    * customize the users profile
    */
    #[Route('/user/profile', name: 'app_SecurityController_myProfile')]
    public function myProfile(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        if($user){
            $form = $this->createForm(ProfileType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                
                $user->setUpdatedAt(new DateTime());
                
                $userRepository->save($user,true);
                
                return $this->redirectToRoute('app_home_index');
            }
            return $this->render('security/myProfile.html.twig',[
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
