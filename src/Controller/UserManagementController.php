<?php

namespace App\Controller;

use App\Entity\Passwords;
use App\Entity\User;
use App\Form\DeleteUserType;
use App\Form\EditUserType;
use App\Form\EditPasswordType;
use App\Repository\LogConnexionRepository;
use App\Repository\PasswordsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\VarDumper\VarDumper;



final class UserManagementController extends AbstractController
{
    #[Route('/admin-users-list', name: 'app_users_list')]
    public function usersList(Request $request, UserRepository $UserRepository, EntityManagerInterface $em): Response
    {
        $users = $UserRepository->findAll();
        $form = $this->createForm(DeleteUserType::class, null, [
            'users' => $users,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedUsers = $form->get('users')->getData();
            foreach ($selectedUsers as $user) {
                $em->remove($user);
            }
            $em->flush();

            $this->addFlash('notice', 'Utilisateur supprimées avec succès');
            return $this->redirectToRoute('app_users_list');
        }

        return $this->render('user_management/users_list.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }



    #[Route('/admin-edit-user/{id}', name: 'app_edit_user')]
    public function editUser(Request $request, User $user, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(EditUserType::class, $user);
        $user->setPlainPassword("eiourteiortuyJKHGFDJKSHKG./?/987987987");
        $user->setPlainPassword2("eiourteiortuyJKHGFDJKSHKG./?/987987987");

        $oldPassword = $user->getPassword();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $password = $user->getPassword();

                if ($oldPassword != $password) {
                    $password = $form->get('Password')->getData();
                    
                    $user->setPassword($userPasswordHasher->hashPassword($user, $password));
                    

                    $passwords = new Passwords();
                    $passwords->setPassword($userPasswordHasher->hashPassword($user, $password));
                    $passwords->setUser($user);
                    $em->persist($passwords);
                } 

                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', 'Utilisateur modifiée');
                return $this->redirectToRoute('app_users_list');
            }
        }

        return $this->render('user_management/edit_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/admin-delete-user/{id}', name: 'app_delete_user')]
    public function deleteUser(Request $request, User $user, EntityManagerInterface $em): Response
    {
        if ($user != null) {
            $em->remove($user);
            $em->flush();
            $this->addFlash('notice', 'Utilisateur supprimée');
        }
        return $this->redirectToRoute('app_users_list');
    }

    #[Route('/admin-log-connexion/{id}', name: 'app_log_connexion', requirements: ['id' => '\d+'])]
    public function logConnexion(User $user, LogConnexionRepository $logConnexionRepository): Response
    {
        $logConnexions = $logConnexionRepository->findBy(
            ['User' => $user],
            ['TimeConnexion' => 'DESC']
        );
        return $this->render('user_management/log_connexion.html.twig', [
            'logConnexions' => $logConnexions,
        ]);
    }



    #[Route('/private-edit-password/{id}', name: 'app_edit_password')]
    public function editPassword( Request $request, User $user, PasswordsRepository $PasswordsRepository, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher, PasswordHasherFactoryInterface $hasherFactory): Response
    {
        $form = $this->createForm(EditPasswordType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $actualPassword = $form->get('oldPassword')->getData();
    
            if (!$userPasswordHasher->isPasswordValid($user, $actualPassword)) {
                $this->addFlash('notice', 'Le mot de passe actuel est incorrect.');
                return $this->redirectToRoute('app_edit_password', ['id' => $user->getId()]);
            }

            $newPassword = $form->get('plainPassword')->getData();
            $plainPassword2 = $form->get('plainPassword2')->getData();
            if ($newPassword !== $plainPassword2) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->render('registration/register.html.twig', [
                    'form' => $form,
                ]);
            }
    
            $newPassword = $form->get('plainPassword')->getData();
            $passwordHasher = $hasherFactory->getPasswordHasher($user);
    
            foreach ($user->getUserPassword() as $oldPassword) {
                if ($passwordHasher->verify($oldPassword->getPassword(), $newPassword)) {
                    $this->addFlash('notice', 'Le nouveau mot de passe ne doit pas être un ancien mot de passe.');
                    return $this->redirectToRoute('app_edit_password', ['id' => $user->getId()]);
                }
            }
    
            $newPasswordHashed = $userPasswordHasher->hashPassword($user, $newPassword);
    
            $passwords = new Passwords();
            $passwords->setPassword($newPasswordHashed);
            $passwords->setUser($user);
            $em->persist($passwords);
    
            $user->setPassword($newPasswordHashed);
            $em->persist($user);
            $em->flush();
    
            $this->addFlash('notice', 'Mot de passe modifié avec succès.');
            return $this->redirectToRoute('app_profil');
        }
    
        return $this->render('user_management/edit_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }







}
