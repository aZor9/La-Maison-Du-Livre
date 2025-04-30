<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Exemplaire;

// #[ORM\Entity]
#[ORM\Table(name: 'document')]
#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ORM\InheritanceType("JOINED")]
// #[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "livre" => Livre::class,
    "titreperiodique" => Titreperiodique::class,
    "video" => Video::class,
    "sonore" => Sonore::class
])]
class Document
{
    // #[ORM\Column]
    #[ORM\Id]
    #[ORM\Column(name: "id_document", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $id_document = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Annee = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Descritpion = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Thème = null;

    public function getid_document(): ?int
    {
        return $this->id_document;
    }
    
    public function getIdDocument(): ?int
    {
        return $this->id_document;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(?string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->Annee;
    }

    public function setAnnee(?\DateTimeInterface $Annee): static
    {
        $this->Annee = $Annee;

        return $this;
    }

    public function getDescritpion(): ?string
    {
        return $this->Descritpion;
    }

    public function setDescritpion(?string $Descritpion): static
    {
        $this->Descritpion = $Descritpion;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->Thème;
    }

    public function setTheme(?string $Thème): static
    {
        $this->Thème = $Thème;
        
        return $this;
    }
    
    // App\Entity\Document.php
    public function getType(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }


    
    // #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'documents')]
    // #[ORM\JoinTable(name: 'auteur_document')]
    // #[ORM\JoinColumn(name: 'id_document', referencedColumnName: 'id_document')]
    // #[ORM\InverseJoinColumn(name: 'IdAuteur', referencedColumnName: 'IdAuteur')]
    // private Collection $auteurs;
    
    #[ORM\OneToMany(mappedBy: 'document', targetEntity: Ecrire::class)]
    private Collection $ecritures;
    
    #[ORM\OneToMany(mappedBy: 'document', targetEntity: Exemplaire::class)]
    private Collection $exemplaires;
    
    
    public function __construct()
    {
        $this->ecritures  = new ArrayCollection();
        $this->exemplaires = new ArrayCollection();
    }
    
    public function getEcritures(): Collection
    {
        return $this->ecritures;
    }
    
    public function addEcriture(Ecrire $ecriture): static
    {
        if (!$this->ecritures->contains($ecriture)) {
            $this->ecritures->add($ecriture);
            $ecriture->setDocument($this);
        }
        
        return $this;
    }
    
    public function removeEcriture(Ecrire $ecriture): static
    {
        if ($this->ecritures->removeElement($ecriture)) {
            // Optionnel : supprimer la relation de l'autre côté si nécessaire
            $ecriture->setDocument(null);
        }
        
        return $this;
    }
    
    
    
    
    public function getExemplaires(): Collection
    {
        return $this->exemplaires;
    }
    
    public function addExemplaire(Exemplaire $exemplaire): static
    {
        if (!$this->exemplaires->contains($exemplaire)) {
            $this->exemplaires->add($exemplaire);
            $exemplaire->setDocument($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): static
    {
        if ($this->exemplaires->removeElement($exemplaire)) {
            if ($exemplaire->getDocument() === $this) {
                $exemplaire->setDocument(null);
            }
        }

        return $this;
    }


}
