<?php

namespace App\Controller;

use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Document;
use App\Entity\Emprunt;
use App\Entity\Empruntexemplaire;
use App\Entity\Ecrire;
use App\Entity\Auteur;

use App\Form\DocumentType; 
use App\Repository\ExemplaireRepository;
use App\Repository\EcrireRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EmpruntRepository;


class DocumentController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/documents', name: 'app_documents')]
    public function index(DocumentRepository $documentRepository, EcrireRepository $ecrireRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
    
        $documents = $documentRepository->findBySearch($search);
    
        $documentsAvecAuteurs = [];
        foreach ($documents as $document) {
            $ecritures = $ecrireRepository->findBy(['document' => $document]);
            $auteurs = [];
            foreach ($ecritures as $ecriture) {
                $auteurs[] = $ecriture->getAuteur();
            }
            $documentsAvecAuteurs[] = [
                'document' => $document,
                'auteurs' => $auteurs,
            ];
        }
    
        return $this->render('document/index.html.twig', [
            'documents' => $documents,
            'search' => $search,
            'documentsAvecAuteurs' => $documentsAvecAuteurs,
        ]);
    }



    #[Route('/document/new', name: 'document_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ajouter les relations avec les auteurs
            $auteurs = $form->get('auteurs')->getData();
            foreach ($auteurs as $auteur) {
                $ecriture = new Ecrire();
                $ecriture->setDocument($document);
                $ecriture->setAuteur($auteur);
                $entityManager->persist($ecriture);
            }

                
            // Gestion des champs spécifiques selon le type de document
            if ($document instanceof Livre) {
                $document->setIsbn($form->get('isbn')->getData());
                $document->setNombrePage($form->get('nombrePage')->getData());
                $document->setGenre($form->get('genre')->getData());
            } elseif ($document instanceof Sonore) {
                $document->setDuree($form->get('duree')->getData());
                $document->setFormat($form->get('format')->getData());
                $document->setInterprete($form->get('interprete')->getData());
            } elseif ($document instanceof Video) {
                $document->setDuree($form->get('duree')->getData());
                $document->setFormat($form->get('format')->getData());
                $document->setRealisateur($form->get('realisateur')->getData());
            } elseif ($document instanceof TitrePeriodique) {
                $document->setNumero($form->get('numero')->getData());
                $document->setDatePublication($form->get('datepublication')->getData());
                $document->setFormat($form->get('format')->getData());
            }
    

            $entityManager->persist($document);
            $entityManager->flush();

            $this->addFlash('success', 'Document créé avec succès.');

            return $this->redirectToRoute('document_index');
        }

        // Récupérer la valeur du champ "type"
        $type = $form->get('type')->getData();
        // Vérifiez si $type est null ou vide
        if (!$type) {
            $type = $document->getType() ?? 'inconnu'; // Utilisez une méthode getType() si elle existe dans l'entité
        }


        return $this->render('document/new.html.twig', [
            'form' => $form->createView(),
            'type' => $type,
        ]);
    }



    #[Route('/document/{id}', name: 'document_show')]
    public function show(DocumentRepository $documentRepository, ExemplaireRepository $exemplaireRepository, int $id): Response
    {
        $document = $documentRepository->find($id);
    
        if (!$document) {
            return $this->redirectToRoute('document_not_found', ['id' => $id]);
        }
    
        $exemplaires = $exemplaireRepository->findBy(['document' => $document]);
    
        $auteurs = [];
        foreach ($document->getEcritures() as $ecriture) {
            $auteurs[] = $ecriture->getAuteur();
        }

        return $this->render('document/show.html.twig', [
            'document' => $document,
            'exemplaires' => $exemplaires,
            'auteurs' => $auteurs,
        ]);
    }
    


    #[Route('/document-inexistant/{id}', name: 'document_not_found')]
    public function notFound(int $id): Response
    {
        return $this->render('document/not_found.html.twig', [
            'id' => $id,
        ]);
    }


    #[Route('/document/{id}/edit', name: 'document_edit')]
    public function edit(Request $request, Document $document, EntityManagerInterface $entityManager): Response
    {
        // Vérification des rôles
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas l\'autorisation d\'accéder à cette page.');
        }
    
        // Créer le formulaire d'édition
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des relations `Ecrire`
            $auteurs = $form->get('auteurs')->getData();
    
            // Supprimer les relations existantes
            foreach ($document->getEcritures() as $ecriture) {
                $document->removeEcriture($ecriture);
                $entityManager->remove($ecriture); // Supprime l'entité de la base de données
            }
    
            // Ajouter les nouvelles relations
            foreach ($auteurs as $auteur) {
                $ecriture = new Ecrire();
                $ecriture->setAuteur($auteur);
                $document->addEcriture($ecriture); // Ajoute la relation
            }
    
            // Gestion des champs spécifiques selon le type de document
            if ($document instanceof Livre) {
                $document->setIsbn($form->get('isbn')->getData());
                $document->setNombrePage($form->get('nombrePage')->getData());
                $document->setGenre($form->get('genre')->getData());
            } elseif ($document instanceof Sonore) {
                $document->setDuree($form->get('duree')->getData());
                $document->setFormat($form->get('format')->getData());
                $document->setInterprete($form->get('interprete')->getData());
            } elseif ($document instanceof Video) {
                $document->setDuree($form->get('duree')->getData());
                $document->setFormat($form->get('format')->getData());
                $document->setRealisateur($form->get('realisateur')->getData());
            } elseif ($document instanceof TitrePeriodique) {
                $document->setNumero($form->get('numero')->getData());
                $document->setDatePublication($form->get('datepublication')->getData());
                $document->setFormat($form->get('format')->getData());
            }
    
            // Sauvegarder les modifications
            $entityManager->flush();
    
            
            // Avant de rediriger
            if ($document->getIdDocument() === null) {
                $this->addFlash('error', 'Le document n\'a pas encore été enregistré.');
                return $this->redirectToRoute('document_index');
            }

            // Rediriger après la mise à jour
            $this->addFlash('success', 'Le document a été modifié avec succès.');
            return $this->redirectToRoute('document_show', ['id' => $document->getIdDocument()]);
        }
        
        // Récupérer la valeur du champ "type"
        $type = $form->get('type')->getData();
        // Vérifiez si $type est null ou vide
        if (!$type) {
            $type = $document->getType() ?? 'inconnu'; // Utilisez une méthode getType() si elle existe dans l'entité
        }
    
        return $this->render('document/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
            'type' => $type,
        ]);
    }
    

    #[Route('/document/{id}/reserver', name: 'document_reserver', methods: ['POST'])]
    public function reserver(
        Document $document,
        ExemplaireRepository $exemplaireRepository,
        EmpruntRepository $empruntRepository,
        EntityManagerInterface $em
    ): Response {
        $utilisateur = $this->getUser();
    
        if (!$utilisateur) {
            $this->addFlash('danger', 'Vous devez être connecté pour réserver un document.');
            return $this->redirectToRoute('app_login');
        }
    
        // Vérifier la limite de réservations actives
        $activeReservations = $empruntRepository->countActiveReservationsByUser($utilisateur->getIdutilisateur());
        if ($activeReservations >= 10) {
            $this->addFlash('danger', 'Vous avez atteint la limite de 10 réservations simultanées.');
            return $this->redirectToRoute('document_show', ['id' => $document->getIdDocument()]);
        }
    
        // Chercher un exemplaire disponible
        $exemplaire = $exemplaireRepository->findOneBy([
            'document' => $document,
            'Statut' => 'disponible',
        ]);
    
        if (!$exemplaire) {
            $this->addFlash('danger', 'Aucun exemplaire disponible à la réservation.');
            return $this->redirectToRoute('document_show', ['id' => $document->getIdDocument()]);
        }
    
        // Réserver l'exemplaire
        $exemplaire->setStatut('reserve');
    
        // Créer un nouvel emprunt
        $emprunt = new Emprunt();
        $emprunt->setDateReservation(new \DateTime());
        $emprunt->setUtilisateur($utilisateur);
    
        // Lier l'emprunt à l'exemplaire
        $empruntExemplaire = new Empruntexemplaire();
        $empruntExemplaire->setEmprunt($emprunt);
        $empruntExemplaire->setExemplaire($exemplaire);
    
        $em->persist($emprunt);
        $em->persist($empruntExemplaire);
        $em->flush();
    
        $this->addFlash('success', 'Exemplaire réservé avec succès.');
        return $this->redirectToRoute('document_show', ['id' => $document->getIdDocument()]);
    }



    #[Route('/mes-emprunts', name: 'app_mes_emprunts')]
    public function mesEmprunts(
        EmpruntRepository $empruntRepository,
        Request $request
    ): Response {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();

        if (!$utilisateur) {
            $this->addFlash('error', 'Vous devez être connecté pour voir vos emprunts.');
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les emprunts de l'utilisateur
        $emprunts = $empruntRepository->findBy(['utilisateur' => $utilisateur]);

        // Extraire les documents empruntés
        $documentsAvecAuteurs = [];
        foreach ($emprunts as $emprunt) {
            foreach ($emprunt->getEmpruntexemplaires() as $empruntExemplaire) {
                $document = $empruntExemplaire->getExemplaire()->getDocument();
                $auteurs = [];
                foreach ($document->getEcritures() as $ecriture) {
                    $auteurs[] = $ecriture->getAuteur();
                }
                $documentsAvecAuteurs[] = [
                    'document' => $document,
                    'auteurs' => $auteurs,
                ];
            }
        }

        return $this->render('document/mes_emprunts.html.twig', [
            'documentsAvecAuteurs' => $documentsAvecAuteurs,
        ]);
    }
}