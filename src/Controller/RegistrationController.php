<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Passwords;
use App\Form\RegistrationFormType;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Passwords $passwords, Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setdateInscription(new \Datetime());
            $plainPassword = $form->get('plainPassword')->getData();
            $plainPassword2 = $form->get('plainPassword2')->getData();
            if ($plainPassword !== $plainPassword2) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form,
                ]);
            }

            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setStatus('Activer');

            $passwords->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $passwords->setUser($user);
            $entityManager->persist($passwords);

            $entityManager->persist($user);
            $entityManager->flush();


            return $security->login($user, AppCustomAuthenticator::class, 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
