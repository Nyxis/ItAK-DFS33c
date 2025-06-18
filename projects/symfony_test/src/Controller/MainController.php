<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\EditorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        // Si l'utilisateur est connecté, rediriger selon son rôle
        if ($this->getUser()) {
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin_index');
            } else {
                return $this->redirectToRoute('user_home');
            }
        }
        
        // Si pas connecté, rediriger vers la page de connexion
        return $this->redirectToRoute('app_login');
    }
    
    #[Route('/home', name: 'user_home')]
    #[IsGranted('ROLE_USER')]
    public function userHome(
        BookRepository $bookRepository,
        AuthorRepository $authorRepository,
        EditorRepository $editorRepository
    ): Response {
        return $this->render('main/user_home.html.twig', [
            'books_count' => $bookRepository->count([]),
            'authors_count' => $authorRepository->count([]),
            'editors_count' => $editorRepository->count([]),
        ]);
    }
} 