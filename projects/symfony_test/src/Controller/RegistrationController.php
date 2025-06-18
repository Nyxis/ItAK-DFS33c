<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $user = new User();
            $user->setFirstname($request->request->get('firstname'));
            $user->setLastname($request->request->get('lastname'));
            $user->setUsername($request->request->get('username'));
            $user->setEmail($request->request->get('email'));
            
            // Hacher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $request->request->get('password')
            );
            $user->setPassword($hashedPassword);
            
            // Gérer les rôles depuis les cases à cocher
            $roles = $request->request->all('roles') ?: [];
            if (!in_array('ROLE_USER', $roles)) {
                $roles[] = 'ROLE_USER'; // Toujours ajouter ROLE_USER
            }
            $user->setRoles($roles);
            
            $entityManager->persist($user);
            $entityManager->flush();
            
            $this->addFlash('success', 'Utilisateur créé avec succès ! Vous pouvez maintenant vous connecter.');
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('registration/register.html.twig');
    }
} 