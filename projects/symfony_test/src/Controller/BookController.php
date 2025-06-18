<?php
namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book_index')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/book/{id}', name: 'app_book_show')]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
} 