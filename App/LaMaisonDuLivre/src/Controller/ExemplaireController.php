<?php
// src/Controller/DocumentController.php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Exemplaire;
use App\Repository\DocumentRepository;
use App\Repository\ExemplaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExemplaireController extends AbstractController
{
    #[Route('/exemplaires', name: 'exemplaire_index')]
    public function listExemplaires(ExemplaireRepository $exemplaireRepository): Response
    {
        // Récupérer tous les exemplaires
        $exemplaires = $exemplaireRepository->findAll();

        return $this->render('exemplaire/index.html.twig', [
            'exemplaires' => $exemplaires,
        ]);
    }



    #[Route('/exemplaire/{id}', name: 'exemplaire_show')]
    public function show(ExemplaireRepository $exemplaireRepository, DocumentRepository $documentRepository, int $id): Response
    {
        $exemplaire = $exemplaireRepository->find($id);
    
        if (!$exemplaire) {
            throw $this->createNotFoundException("Exemplaire non trouvé");
        }
    
        $document = $exemplaire->getDocument();
    
        if (!$document) {
            throw $this->createNotFoundException("Aucun document lié à cet exemplaire");
        }
    
        $exemplaires = $exemplaireRepository->findBy(['document' => $document]);
    
        return $this->render('exemplaire/list_by_document.html.twig', [
            'document' => $document,
            'exemplaires' => $exemplaires,
        ]);
    }
    
}
