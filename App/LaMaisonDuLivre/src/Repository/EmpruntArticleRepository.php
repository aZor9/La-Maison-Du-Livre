<?php

namespace App\Repository;

use App\Entity\EmpruntArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmpruntArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmpruntArticle::class);
    }

    // Ajoutez vos méthodes personnalisées ici
}