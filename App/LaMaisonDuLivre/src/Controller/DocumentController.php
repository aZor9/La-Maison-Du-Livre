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

        return $this->render('document.html.twig', [
            'documents' => $documents,
            'search' => $search,
            'type' => $type,
        ]);
    }
}