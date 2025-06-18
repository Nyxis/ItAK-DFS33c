<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorTypeForm;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/editor')]
final class EditorController extends AbstractController
{
   #[Route('', name: 'app_admin_editor_index')]
public function index(EditorRepository $editorRepository): Response
{
    $editors = $editorRepository->findAll();

    return $this->render('admin/editor/index.html.twig', [
        'editors' => $editors,
    ]);
}

    #[Route('/new', name: 'app_admin_editor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorTypeForm::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($editor);
            $entityManager->flush();

            $this->addFlash('success', 'Éditeur ajouté avec succès !');
            return $this->redirectToRoute('app_admin_editor_index');
        }

        return $this->render('admin/editor/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_editor_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Editor $editor): Response
    {
        return $this->render('admin/editor/show.html.twig', [
            'editor' => $editor,
        ]);
    }
}
