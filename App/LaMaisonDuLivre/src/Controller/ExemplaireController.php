<?php

namespace App\Controller;

use App\Entity\Exemplaire;
use App\Entity\Empruntexemplaire;
use App\Repository\ExemplaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DocumentRepository;

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
            // Passer en "utilisé"
            $exemplaire->setStatut('utilise');

            if ($empruntExemplaire) {
                $emprunt = $empruntExemplaire->getEmprunt();
                if ($emprunt && $emprunt->getDateRendu() === null) {
                    // Réassigner l'utilisateur ou d'autres informations si nécessaire
                    $utilisateur = $emprunt->getUtilisateur();
                    if ($utilisateur) {
                        $emprunt->setUtilisateur($utilisateur); // Réassignation explicite
                    }
                }
            }
        } elseif ($exemplaire->getStatut() === 'utilise') {
            // Passer en "disponible" et nettoyer
            $exemplaire->setStatut('disponible');

            if ($empruntExemplaire) {
                $entityManager->remove($empruntExemplaire);
            }

            if (isset($emprunt)) {
                $entityManager->remove($emprunt);
            }
        }
    
        // Sauvegarder les modifications
        $entityManager->flush();
    
        return $this->redirectToRoute('exemplaire_index');
    }


    #[Route('/exemplaire/{id}/changer-etat', name: 'exemplaire_changer_etat', methods: ['POST'])]
    public function changerEtat(int $id, EntityManagerInterface $entityManager): Response
    {
        $exemplaire = $entityManager->getRepository(Exemplaire::class)->find($id);
    
        if (!$exemplaire) {
            throw $this->createNotFoundException('Exemplaire non trouvé.');
        }
    
        // Récupérer le nouvel état depuis la requête (par exemple via un formulaire ou une requête AJAX)
        $nouvelEtat = $_POST['etatPhysique'] ?? null;
    
        if (!in_array($nouvelEtat, ['neuf', 'bon', 'usé'], true)) {
            throw $this->createNotFoundException('État invalide.');
        }
    
        // Mettre à jour l'état de l'exemplaire
        $exemplaire->setEtatPhysique($nouvelEtat);
    
        // Sauvegarder les modifications
        $entityManager->flush();
    
        return $this->redirectToRoute('exemplaire_index');
    }


    #[Route('/exemplaire/new/{documentId}', name: 'exemplaire_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, DocumentRepository $documentRepository, int $documentId): Response
    {
        $document = $documentRepository->find($documentId);
    
        if (!$document) {
            throw $this->createNotFoundException('Document non trouvé.');
        }
    
        $exemplaire = new Exemplaire();
        $exemplaire->setDocument($document);
        $exemplaire->setEtatphysique('neuf'); // Exemple de valeur par défaut
        $exemplaire->setStatut('disponible'); // Exemple de valeur par défaut
    
        $entityManager->persist($exemplaire);
        $entityManager->flush();
    
        $this->addFlash('success', 'Exemplaire ajouté avec succès.');
    
        return $this->redirectToRoute('document_show', ['id' => $documentId]);
    }



    #[Route('/exemplaire/delete/{id}', name: 'exemplaire_delete', methods: ['POST'])]
    public function delete(Request $request, Exemplaire $exemplaire, EntityManagerInterface $entityManager): Response
    {
        if (!$exemplaire) {
            throw $this->createNotFoundException('Exemplaire non trouvé.');
        }

        $documentId = $exemplaire->getDocument()->getIdDocument();

        $entityManager->remove($exemplaire);
        $entityManager->flush();

        $this->addFlash('success', 'Exemplaire supprimé avec succès.');

        return $this->redirectToRoute('document_show', ['id' => $documentId]);
    }

    #[Route('/exemplaires/delete/{id}', name: 'exemplaires_delete', methods: ['POST'])]
    public function deleted(Request $request, Exemplaire $exemplaire, EntityManagerInterface $entityManager): Response
    {
        if (!$exemplaire) {
            throw $this->createNotFoundException('Exemplaire non trouvé.');
        }

        $documentId = $exemplaire->getDocument()->getIdDocument();

        $entityManager->remove($exemplaire);
        $entityManager->flush();

        $this->addFlash('success', 'Exemplaire supprimé avec succès.');

        return $this->redirectToRoute('exemplaire_index');
    }

}