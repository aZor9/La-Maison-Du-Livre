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

    // #[ORM\Column]
    // #[ORM\Id]
    // #[ORM\GeneratedValue(strategy: "NONE")]
    // private ?int $IdAuteur = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Document::class)]
    #[ORM\JoinColumn(name: "IdDocument", referencedColumnName: "IdDocument", onDelete: "CASCADE")]
    private ?Document $document = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Auteur::class)]
    #[ORM\JoinColumn(name: "IdAuteur", referencedColumnName: "IdAuteur", onDelete: "CASCADE")]
    private ?Auteur $auteur = null;

    public function getIddocument(): ?int
    {
        return $this->IdDocument;
    }

    public function setIddocument(int $IdDocument): static
    {
        $this->IdDocument = $IdDocument;

        return $this;
    }

    public function getIdauteur(): ?int
    {
        return $this->IdAuteur;
    }

    public function setIdauteur(int $IdAuteur): static
    {
        $this->IdAuteur = $IdAuteur;

        return $this;
    }
}





