<?php

namespace App\Entity;

use App\Repository\EcrireRepository;
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

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Document::class, inversedBy: 'ecritures')]
    #[ORM\JoinColumn(name: "IdDocument", referencedColumnName: "IdDocument", onDelete: "CASCADE")]
    private ?Document $document = null;

    // #[ORM\Column]
    // #[ORM\Id]
    // #[ORM\GeneratedValue(strategy: "NONE")]
    // private ?int $IdAuteur = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Auteur::class, inversedBy: 'ecritures')]
    #[ORM\JoinColumn(name: "IdAuteur", referencedColumnName: "IdAuteur", onDelete: "CASCADE")]
    private ?Auteur $auteur = null;

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
