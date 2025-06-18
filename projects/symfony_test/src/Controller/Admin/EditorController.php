<?php
namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/editor')]
class EditorController extends AbstractController
{
    #[Route('/', name: 'admin_editor_index')]
    public function index(EditorRepository $editorRepository): Response
    {
        $editors = $editorRepository->findAll();
        
        return $this->render('admin/editor/index.html.twig', [
            'editors' => $editors,
        ]);
    }

    #[Route('/new', name: 'admin_editor_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($editor);
            $em->flush();
            return $this->redirectToRoute('admin_editor_success');
        }

        return $this->render('admin/editor/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/success', name: 'admin_editor_success')]
    public function success(): Response
    {
        return $this->render('admin/editor/success.html.twig');
    }
} 