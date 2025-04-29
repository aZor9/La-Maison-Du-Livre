<?php

namespace App\Controller;

use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Document;
use App\Form\DocumentType; 

class DocumentController extends AbstractController
{
    #[Route('/documents', name: 'app_documents')]
    public function index(DocumentRepository $documentRepository, Request $request): Response
    {
        // Récupérer les paramètres de recherche et de filtre
        $search = $request->query->get('search', '');
        $type = $request->query->get('type', '');

        // Rechercher les documents en fonction des critères
        $documents = $documentRepository->findBySearchAndType($search, $type);

        return $this->render('document/index.html.twig', [
            'documents' => $documents,
            'search' => $search,
            'type' => $type,
        ]);
    }

    #[Route('/document/{id}', name: 'document_show')]
    public function show(DocumentRepository $documentRepository, int $id): Response
    {
        $document = $documentRepository->find($id);

        if (!$document) {
            return $this->redirectToRoute('document_not_found', ['id' => $id]);
        }

        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);
    }


    #[Route('/document-inexistant/{id}', name: 'document_not_found')]
    public function notFound(int $id): Response
    {
        return $this->render('document/not_found.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/document/{id}/edit', name: 'document_edit')]
    public function edit(Request $request, Document $document): Response
    {
        // Vérification des rôles
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas l\'autorisation d\'accéder à cette page.');
        }
    
        // Crée le formulaire d'édition
        $form = $this->createForm(DocumentType::class, $document);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide, on enregistre les modifications
            $entityManager = $this->getDoctrine()->getManager();
            
            // On met à jour l'entité Document avec les données du formulaire (il n'est pas nécessaire de manipuler l'année manuellement)
            $entityManager->flush();
    
            // Rediriger après la mise à jour
            return $this->redirectToRoute('document_show', ['id' => $document->getId()]);
        }
    
        return $this->render('document/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }
    
    


}