<?php

// src/Controller/TestController.php
namespace App\Controller;

use App\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(EntityManagerInterface $em): Response
    {
        $documents = $em->getRepository(Document::class)->findAll();
        
        return $this->render('test/index.html.twig', [
            'documents' => $documents,
        ]);
    }
}
