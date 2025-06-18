<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Editor;
use App\Form\EditorTypeForm;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin/editor')]
final class EditorController extends AbstractController
{
    #[Route('', name: 'app_admin_editor_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/editor/index.html.twig', [
            'controller_name' => 'EditorController',
        ]);
    }
    #[Route('/new', name: 'app_admin_editor_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  EntityManagerInterface $manager): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorTypeForm::class, $editor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //refs dans AuthorController
            $manager->persist($editor);
            $manager->flush();

            return $this->redirectToRoute(route: 'app_admin_editor_index');
        }

        return $this->render('admin/editor/new.html.twig', [
            'form' => $form,
        ]);
    }
}
