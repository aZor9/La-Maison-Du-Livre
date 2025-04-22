<?php

namespace App\Entity;

use App\Repository\EcrireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ecrire')]
#[ORM\Index(name: 'IdAuteur', columns: ['IdAuteur'])]
#[ORM\Entity(repositoryClass: EcrireRepository::class)]
class Ecrire
{
    // #[ORM\Column]
    // #[ORM\Id]
    // #[ORM\GeneratedValue(strategy: "NONE")]
    // private ?int $IdDocument = null;

    // #[ORM\Id]
    // #[ORM\ManyToOne(targetEntity: Document::class)]
    // #[ORM\JoinColumn(name: "IdDocument", referencedColumnName: "IdDocument", onDelete: "CASCADE")]
    // private ?Document $document = null;
    
    #[ORM\Id]
    #[ORM\Column(name: "IdDocument", type: "integer")]
    #[ORM\GeneratedValue]
    private ?int $IdDocument = null;
    
    // #[ORM\Column]
    // #[ORM\Id]
    // #[ORM\GeneratedValue(strategy: "NONE")]
    // private ?int $IdAuteur = null;

    // #[ORM\Id]
    // #[ORM\ManyToOne(targetEntity: Auteur::class)]
    // #[ORM\JoinColumn(name: "IdAuteur", referencedColumnName: "IdAuteur", onDelete: "CASCADE")]
    // private ?Auteur $auteur = null;

    #[ORM\Id]
    #[ORM\Column(name: "IdAuteur", type: "integer")]
    #[ORM\GeneratedValue]
    private ?int $IdAuteur = null;
    
    public function getDocument(): ?Document
    {
        return $this->document;
    }
    
    public function setDocument(?Document $document): static
    {
        $this->document = $document;
    
        return $this;
    }
    
    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }
    
    public function setAuteur(?Auteur $auteur): static
    {
        $this->auteur = $auteur;
    
        return $this;
    }
    
}





