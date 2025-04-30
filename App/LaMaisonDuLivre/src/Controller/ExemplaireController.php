<?php
// src/Controller/DocumentController.php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Exemplaire;
use App\Entity\EmpruntExemplaire;
use App\Entity\Emprunt;
use App\Repository\DocumentRepository;
use App\Repository\ExemplaireRepository;
use App\Repository\EmpruntexemplaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;

class ExemplaireController extends AbstractController
{

    #[Route('/exemplaires', name: 'exemplaire_index')]
    public function listExemplaires(
        ExemplaireRepository $exemplaireRepository,
        EmpruntExemplaireRepository $empruntExemplaireRepository,
        EmpruntRepository $empruntRepository
    ): Response {
        $exemplaires = $exemplaireRepository->findAll();
        $exemplairesAvecInfos = [];
    
        foreach ($exemplaires as $exemplaire) {
            // $empruntsExemplaire = $empruntExemplaireRepository->findBy(['exemplaire' => $exemplaire->getIdexemplaire()]);
            $empruntsExemplaire = $empruntExemplaireRepository->findBy(['exemplaire' => $exemplaire]);

            $empruntActif = null;
    
            foreach ($empruntsExemplaire as $empruntExemplaire) {
                // $emprunt = $empruntRepository->find($empruntExemplaire->getIdEmprunt());
                $emprunt = $empruntExemplaire->getEmprunt();

                if ($emprunt && $emprunt->getDateRendu() === null) {
                    $empruntActif = $emprunt;
                    break;
                }
            }
    
            // $exemplairesAvecInfos = [];

            foreach ($exemplaires as $ex) {
                $emprunt = null;
            
                foreach ($ex->getEmpruntexemplaires() as $empruntExemplaire) {
                    $e = $empruntExemplaire->getEmprunt();
                    if ($e && $e->getDateRendu() === null) {
                        $emprunt = $e;
                        break;
                    }
                }
            
                $exemplairesAvecInfos[] = [
                    'exemplaire' => $ex,
                    'emprunt' => $emprunt,
                ];
            }
            
            return $this->render('exemplaire/index.html.twig', [
                'exemplairesAvecInfos' => $exemplairesAvecInfos,
            ]);
        }
            
    }
    

    #[Route('/exemplaire/{id}/changer-statut', name: 'exemplaire_changer_statut', methods: ['POST'])]
    public function changerStatut(int $id, EntityManagerInterface $entityManager): Response
    {
        $exemplaire = $entityManager->getRepository(Exemplaire::class)->find($id);
    
        if (!$exemplaire) {
            throw $this->createNotFoundException('Exemplaire non trouvé.');
        }
    
        // Changer le statut de l'exemplaire
        if ($exemplaire->getStatut() === 'reserve') {
            $exemplaire->setStatut('utilise');
        } elseif ($exemplaire->getStatut() === 'utilise') {
            $exemplaire->setStatut('disponible');
        }
    
        $entityManager->flush();
    
        return $this->redirectToRoute('exemplaire_index');
    }
    

}
