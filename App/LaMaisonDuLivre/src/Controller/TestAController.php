<?php

// src/Controller/TestController.php
namespace App\Controller;

use App\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TestAController extends AbstractController
{
    #[Route('/test/testA', name: 'app_test2')]
    public function index(EntityManagerInterface $em): Response
    {
        $documents = $em->getRepository(Document::class)->findAll();
        
        return $this->render('test/testA.html.twig', [
            'documents' => $documents,
        ]);
    }
}
