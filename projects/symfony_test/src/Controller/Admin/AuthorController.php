<?php
namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/author')]
class AuthorController extends AbstractController
{
    #[Route('/', name: 'admin_author_index')]
    public function index(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();
        
        return $this->render('admin/author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/new', name: 'admin_author_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('admin_author_success');
        }

        return $this->render('admin/author/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/success', name: 'admin_author_success')]
    public function success(): Response
    {
        return $this->render('admin/author/success.html.twig');
    }
} 