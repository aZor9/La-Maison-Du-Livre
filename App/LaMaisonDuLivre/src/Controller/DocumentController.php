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

            $entityManager->persist($document);
            $entityManager->flush();

            $this->addFlash('success', 'Document créé avec succès.');

            return $this->redirectToRoute('document_index');
        }

        return $this->render('document/new.html.twig', [
            'form' => $form->createView(),
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
    public function edit(Request $request, Document $document): Response
    {
        // Vérification des rôles
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas l\'autorisation d\'accéder à cette page.');
        }

        // Créer le formulaire d'édition
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $auteurs = $form->get('auteurs')->getData();

            // Récupérer les entités `Ecrire` depuis la base de données
            $ecritures = $this->entityManager->getRepository(Ecrire::class)->findBy(['document' => $document]);
            foreach ($ecritures as $ecriture) {
                $this->entityManager->remove($ecriture);
            }

            // Supprimer les relations existantes
            foreach ($ecritures as $ecriture) {
                $ecriture = $this->entityManager->getRepository(Ecrire::class)->findOneBy([
                    'document' => $document,
                    'auteur' => $auteurs,
                ]);

            foreach ($auteurs as $auteur) {
                $ecriture = new Ecrire();
                $ecriture->setDocument($document);
                $ecriture->setAuteur($auteur);
                // $entityManager->persist($ecriture);
                $this->entityManager->persist($ecriture);
            }

            if ($document instanceof Livre) {
                $isbn = $form->get('isbn')->getData();
                $nombrePage = $form->get('nombrePage')->getData();
                $genre = $form->get('genre')->getData();

            } elseif ($document instanceof Sonore) {
                $duree = $form->get('duree')->getData();
                $format = $form->get('format')->getData();
                $interprete = $form->get('interprete')->getData();

            } elseif ($document instanceof Video) {
                $duree = $form->get('duree')->getData();
                $format = $form->get('format')->getData();
                $realisateur = $form->get('realisateur')->getData();

            } elseif ($document instanceof TitrePeriodique) {
                $numero = $form->get('numero')->getData();
                $datePublication = $form->get('datepublication')->getData();
                $format = $form->get('format')->getData();
            }
    
            // Sauvegarder les modifications
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->flush();
            $this->entityManager->flush();
    
            // Rediriger après la mise à jour
            return $this->redirectToRoute('document_show', ['id' => $document->getIdDocument()]);
            }
        }
    
        return $this->render('document/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }
    
    

    #[Route('/document/{id}/reserver', name: 'document_reserver', methods: ['POST'])]
    public function reserver(
        Document $document,
        ExemplaireRepository $exemplaireRepository,
        EntityManagerInterface $em
    ): Response {
        // Chercher un exemplaire disponible (en fonction du statut)
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
        $emprunt->setDateReservation(new \DateTime()); // Date actuelle
        $emprunt->setUtilisateur($this->getUser()); // Utilisateur connecté

        // Persister l'emprunt
        $em->persist($emprunt);

        // Lier l'emprunt à l'exemplaire via la table `empruntexemplaire`
        $empruntExemplaire = new Empruntexemplaire();
        $empruntExemplaire->setEmprunt($emprunt);
        $empruntExemplaire->setExemplaire($exemplaire);

        // Persister la liaison
        $em->persist($empruntExemplaire);

        // Sauvegarder les modifications
        $em->flush();
    
        $this->addFlash('success', 'Exemplaire réservé avec succès.');
    
        return $this->redirectToRoute('document_show', ['id' => $document->getIdDocument()]);
    }
    




}