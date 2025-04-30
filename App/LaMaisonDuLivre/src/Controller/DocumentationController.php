<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentationController extends AbstractController
{
    #[Route('/cookie', name: 'cookie')]
    public function cookie(): Response
    {
        return $this->render('documentation/cookie.html.twig');
    }
    
    #[Route('/cgs', name: 'cgs')]
    public function cgs(): Response
    {
        return $this->render('documentation/cgs.html.twig');
    }

    #[Route('/mentions-legales', name: 'mentions')]
    public function mentions(): Response
    {
        return $this->render('documentation/mentions_legales.html.twig');
    }

    #[Route('/don', name: 'don')]
    public function don(): Response
    {
        return $this->render('documentation/don.html.twig');
    }
}
