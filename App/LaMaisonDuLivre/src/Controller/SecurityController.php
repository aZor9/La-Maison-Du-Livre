<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, redirige vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Récupère l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupère le dernier nom d'utilisateur saisi
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode ne doit pas contenir de code car Symfony s'en charge automatiquement
        throw new \LogicException('Cette méthode peut être vide - elle sera interceptée par la clé logout de ton firewall.');
    }




    #[Route(path: '/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
    
        // Créez un formulaire pour l'inscription
        $form = $this->createFormBuilder($utilisateur)
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'form-input w-full py-2 px-4 border border-gray-300 rounded-lg'],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-input w-full py-2 px-4 border border-gray-300 rounded-lg'],
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-input w-full py-2 px-4 border border-gray-300 rounded-lg'],
            ])
            ->add('motDePasse', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'form-input w-full py-2 px-4 border border-gray-300 rounded-lg'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer un compte',
                'attr' => ['class' => 'bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700'],
            ])
            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Hacher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($utilisateur, $utilisateur->getMotDePasse());
            $utilisateur->setMotDePasse($hashedPassword);
    
            // Définir des valeurs par défaut
            $utilisateur->setRole('ROLE_USER');
            $utilisateur->setStatut('actif');
    
            // Sauvegarder l'utilisateur
            $entityManager->persist($utilisateur);
            $entityManager->flush();
    
            $this->addFlash('success', 'Compte créé avec succès. Vous pouvez maintenant vous connecter.');
    
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}