<?php

namespace App\Controller;

use App\Entity\Exemplaire;
use App\Entity\Empruntexemplaire;
use App\Repository\ExemplaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ExemplaireController extends AbstractController
{
    #[Route('/exemplaires', name: 'exemplaire_index')]
    public function listExemplaires(
        ExemplaireRepository $exemplaireRepository
    ): Response {
        $exemplaires = $exemplaireRepository->findAll();
        $exemplairesAvecInfos = [];

        foreach ($exemplaires as $exemplaire) {
            $empruntActif = null;

            // Parcourir les emprunts liés à l'exemplaire
            foreach ($exemplaire->getEmpruntexemplaires() as $empruntExemplaire) {
                $emprunt = $empruntExemplaire->getEmprunt();

                // Vérifier si l'emprunt est actif (non rendu)
                if ($emprunt && $emprunt->getDateRendu() === null) {
                    $empruntActif = $emprunt;
                    break;
                }
            }

            $exemplairesAvecInfos[] = [
                'exemplaire' => $exemplaire,
                'emprunt' => $empruntActif,
            ];
        }

        return $this->render('exemplaire/index.html.twig', [
            'exemplairesAvecInfos' => $exemplairesAvecInfos,
        ]);
    }

    
    #[Route('/exemplaire/{id}/changer-statut', name: 'exemplaire_changer_statut', methods: ['POST'])]
    public function changerStatut(int $id, EntityManagerInterface $entityManager): Response
    {
        $exemplaire = $entityManager->getRepository(Exemplaire::class)->find($id);
    
        if (!$exemplaire) {
            throw $this->createNotFoundException('Exemplaire non trouvé.');
        }
    
        // Récupérer le dernier emprunt lié à cet exemplaire
        $empruntExemplaire = $entityManager->getRepository(Empruntexemplaire::class)
            ->findOneBy(['exemplaire' => $exemplaire], ['emprunt' => 'DESC']); // Trier par le dernier emprunt
    
        if ($exemplaire->getStatut() === 'reserve') {
            // Passer en "utilise" et définir la date de rendu dans un mois
            $exemplaire->setStatut('utilise');
    
            if ($empruntExemplaire) {
                $emprunt = $empruntExemplaire->getEmprunt();
                $emprunt->setDateRendu((new \DateTime())->modify('+1 month')); // Ajouter un mois
            }
        } elseif ($exemplaire->getStatut() === 'utilise') {
            // Passer en "disponible" et supprimer les informations obsolètes
            $exemplaire->setStatut('disponible');
    
            if ($empruntExemplaire) {
                $entityManager->remove($empruntExemplaire); // Supprimer la liaison emprunt-exemplaire
                $entityManager->remove($empruntExemplaire->getEmprunt()); // Supprimer l'emprunt
            }
        }
    
        // Sauvegarder les modifications
        $entityManager->flush();
    
        return $this->redirectToRoute('exemplaire_index');
    }


}
