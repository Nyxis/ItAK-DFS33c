<?php
namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/book')]
class BookController extends AbstractController
{
    #[Route('/', name: 'admin_book_index')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        
        return $this->render('admin/book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/new', name: 'admin_book_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('admin_book_success');
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/success', name: 'admin_book_success')]
    public function success(): Response
    {
        return $this->render('admin/book/success.html.twig');
    }
} 