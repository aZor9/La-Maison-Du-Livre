<?php

namespace App\Controller;

use App\Entity\Exemplaire;
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
