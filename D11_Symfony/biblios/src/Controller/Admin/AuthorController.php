<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorTypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin/author')]
final class AuthorController extends AbstractController
{
    #[Route('', name: 'app_admin_author_index')]
    public function index(): Response
    {
        return $this->render('admin/author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/new', name: 'app_admin_author_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorTypeForm::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Entity manager prise en cmpte nvlle entité
            $manager->persist($author); //Existe aussi remove()
            //Ecrire dans la DB
            $manager->flush();
            //Eviter doublons form
            return $this->redirectToRoute(route: 'app_admin_author_index');
        }
        return $this->render('admin/author/new.html.twig', [
            'form' => $form,
        ]);
    }
};
