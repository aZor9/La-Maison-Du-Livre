<?php 

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UtilisateurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface; 

class AdminController extends AbstractController
{
    private $entityManager;

    // Injecter l'EntityManager dans le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/utilisateur', name: 'utilisateur_index')]
    public function index(Request $request, UtilisateurRepository $utilisateurRepository): Response
    {
        $search = $request->query->get('search', '');
    
        if (!empty($search)) {
            $utilisateurs = $utilisateurRepository->findByEmail($search);
        } else {
            $utilisateurs = $utilisateurRepository->findAll();
        }
    
        return $this->render('admin/utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
            'search' => $search,
        ]);
    }

    #[Route('/admin/utilisateur/{id}', name: 'utilisateur_show')]
    public function show(Request $request, UtilisateurRepository $utilisateurRepository, int $id): Response
    {
        $utilisateur = $utilisateurRepository->find($id);
    
        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }
    
        $form = $this->createForm(UtilisateurType::class, $utilisateur, [
            'is_admin' => true,
        ]);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les changements dans la base de données
            $this->entityManager->flush();

            // Message de succès
            $this->addFlash('success', 'Utilisateur mis à jour avec succès');

            // Rediriger vers la page d'index ou la page de détails
            return $this->redirectToRoute('utilisateur_index');
        }
    
        return $this->render('admin/utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }


}
