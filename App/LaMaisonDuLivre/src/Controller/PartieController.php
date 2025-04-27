<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartieController extends AbstractController
{
    #[Route('/navbar', name: 'navbar')]
    public function navbar(): Response
    {
        return $this->render('partie/navbar.html.twig');
    }

    #[Route('/footer', name: 'footer')]
    public function footer(): Response
    {
        return $this->render('partie/footer.html.twig');
    }
}
