<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuteurController extends AbstractController
{

    #[Route('/admin/auteurs', name: 'admin_auteurs')]
    public function manageAuteurs(
        Request $request,
        AuteurRepository $auteurRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer les auteurs existants avec une recherche
        $search = $request->query->get('search', '');
        $auteurs = $auteurRepository->findBySearch($search);

        // Créer un nouvel auteur
        $auteur = new Auteur();
        $form = $this->createFormBuilder($auteur)
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'form-input w-full py-2 px-4 border border-gray-300 rounded-lg'],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-input w-full py-2 px-4 border border-gray-300 rounded-lg'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['class' => 'form-textarea w-full py-2 px-4 border border-gray-300 rounded-lg'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer l\'auteur',
                'attr' => ['class' => 'bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($auteur);
            $entityManager->flush();

            $this->addFlash('success', 'Auteur créé avec succès.');

            return $this->redirectToRoute('admin_auteurs');
        }

        return $this->render('admin/auteurs.html.twig', [
            'auteurs' => $auteurs,
            'search' => $search,
            'form' => $form->createView(),
        ]);
    }
}