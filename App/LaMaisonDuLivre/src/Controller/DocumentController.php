<?php

namespace App\Controller;

use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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


}