<?php

namespace App\Controller\Admin;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CommentRepository;
use App\Repository\EditorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin_index')]
    public function index(
        BookRepository $bookRepository,
        AuthorRepository $authorRepository,
        EditorRepository $editorRepository,
        CommentRepository $commentRepository
    ): Response {
        return $this->render('admin/index.html.twig', [
            'books_count' => $bookRepository->count([]),
            'authors_count' => $authorRepository->count([]),
            'editors_count' => $editorRepository->count([]),
            'comments_count' => $commentRepository->count([]),
        ]);
    }
} 