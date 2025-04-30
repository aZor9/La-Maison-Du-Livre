<?php

namespace App\Service;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;

class AbonnementService
{
    private $utilisateurRepository;
    private $entityManager;

    public function __construct(UtilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->entityManager = $entityManager;
    }

    public function handleExpiredAbonnements(): void
    {
        $utilisateurs = $this->utilisateurRepository->findAll();

        foreach ($utilisateurs as $utilisateur) {
            $abonnement = $utilisateur->getAbonnement();

            if ($abonnement && $abonnement->isExpired()) {
                // Supprimer les informations liées à l'abonnement
                $utilisateur->setAbonnement(null);
                $utilisateur->setLienJustificatif(null);

                $this->entityManager->persist($utilisateur);
                $this->entityManager->remove($abonnement);
            }
        }

        $this->entityManager->flush();
    }
}