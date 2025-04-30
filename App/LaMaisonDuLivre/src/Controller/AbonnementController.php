<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Entity\Abonnement;
use App\Form\AbonnementType;
use App\Form\UtilisateurType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


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

    #[Route('/profile/abonnement/justificatif', name: 'app_abonnement_justificatif', methods: ['POST'])]
    public function updateJustificatif(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();

        if (!$utilisateur) {
            $this->addFlash('error', 'Vous devez être connecté pour mettre à jour votre justificatif.');
            return $this->redirectToRoute('app_login');
        }

        // Récupérer le lien envoyé depuis le formulaire
        $lienJustificatif = $request->request->get('justificatif');

        if (!filter_var($lienJustificatif, FILTER_VALIDATE_URL)) {
            $this->addFlash('error', 'Le lien fourni n\'est pas valide.');
            return $this->redirectToRoute('app_abonnement');
        }

        // Mettre à jour le lien justificatif
        $utilisateur->setLienJustificatif($lienJustificatif);
        $entityManager->persist($utilisateur);
        $entityManager->flush();

        $this->addFlash('success', 'Votre justificatif a été mis à jour avec succès.');
        return $this->redirectToRoute('app_abonnement');
    }
}