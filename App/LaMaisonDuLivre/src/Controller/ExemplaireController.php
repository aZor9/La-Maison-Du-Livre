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


    // #[Route('/exemplaire/{id}', name: 'exemplaire_show')]
    // public function show(int $id, ExemplaireRepository $exemplaireRepository, EmpruntExemplaireRepository $empruntExemplaireRepository, EmpruntRepository $empruntRepository): Response
    // {
    //     // Récupérer l'exemplaire spécifique
    //     $exemplaire = $exemplaireRepository->find($id);
        
    //     // Récupérer les emprunts associés à cet exemplaire
    //     $empruntsExemplaire = $empruntExemplaireRepository->findBy(['idExemplaire' => $id]);
        
    //     // Si l'exemplaire est réservé, on récupère l'emprunt et l'utilisateur
    //     $reservation = null;
    //     if (count($empruntsExemplaire) > 0) {
    //         foreach ($empruntsExemplaire as $empruntExemplaire) {
    //             $emprunt = $empruntRepository->find($empruntExemplaire->getIdEmprunt());
    //             if ($emprunt && $emprunt->getDateRendu() === null) {
    //                 $reservation = [
    //                     'utilisateur' => $emprunt->getUtilisateur(),
    //                     'dateReservation' => $emprunt->getDateReservation(),
    //                     'dateRendu' => $emprunt->getDateRendu()
    //                 ];
    //                 break; // On prend le premier emprunt actif
    //             }
    //         }
    //     }

    //     return $this->render('exemplaire/show.html.twig', [
    //         'exemplaire' => $exemplaire,
    //         'reservation' => $reservation,
    //     ]);
    // }

    #[Route('/exemplaire/{id}/changer-statut', name: 'exemplaire_changer_statut')]
    public function changerStatut(int $id, EmpruntExemplaireRepository $empruntExemplaireRepository, EmpruntRepository $empruntRepository): Response
    {
        $empruntsExemplaire = $empruntExemplaireRepository->findBy(['idExemplaire' => $id]);
        
        foreach ($empruntsExemplaire as $empruntExemplaire) {
            $emprunt = $empruntRepository->find($empruntExemplaire->getIdEmprunt());
            if ($emprunt && $emprunt->getDateRendu() === null) {
                // Changer le statut de l'exemplaire
                if ($emprunt->getStatut() == 'reserve') {
                    $emprunt->setStatut('utilise');
                } elseif ($emprunt->getStatut() == 'utilise') {
                    $emprunt->setStatut('disponible');
                }
                // Sauvegarder les changements
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                
                // Rediriger vers la page des exemplaires
                return $this->redirectToRoute('exemplaire_index');
            }
        }
        
        return $this->redirectToRoute('exemplaire_index');
    }
    

}
