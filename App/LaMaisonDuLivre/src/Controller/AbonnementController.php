<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AbonnementController extends AbstractController
{
    #[Route('/profile/abonnement', name: 'app_abonnement')]
    public function index(): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        if (!$user) {
            $this->addFlash('error', 'Utilisateur non authentifié.');
            return $this->redirectToRoute('app_login'); // Redirigez vers la page de connexion si non connecté
        }

        return $this->render('profile/abonnement.html.twig', [
            'controller_name' => 'AbonnementController',
            'utilisateur' => $user, // Passer l'utilisateur à la vue
        ]);
    }

  
    #[Route('/profile/abonnement', name: 'app_abonnement_justificatif', methods: ['POST'])]
    public function submitJustificatif(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté
        if (!$user) {
            $this->addFlash('error', 'Utilisateur non authentifié.');
            return $this->redirectToRoute('app_abonnement');
        }
    
        $lien = $request->request->get('justificatif');
        if (!$lien) {
            $this->addFlash('error', 'Aucun lien de justificatif fourni.');
            return $this->redirectToRoute('app_abonnement');
        }
    
        // Mettre à jour le lien_justificatif de l'utilisateur
        $user->setLienJustificatif($lien); // Assurez-vous que le setter existe dans l'entité Utilisateur
        $em->persist($user); // Nécessaire pour marquer l'utilisateur comme modifié
        $em->flush(); // Applique les modifications dans la base de données
    
        $this->addFlash('success', 'Votre justificatif a été mis à jour avec succès.');
    
        return $this->redirectToRoute('app_abonnement');
    }
}