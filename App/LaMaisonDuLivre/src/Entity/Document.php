<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Exemplaire;


#[ORM\Table(name: 'document')]
#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    // #[ORM\Column]
    #[ORM\Id]
    #[ORM\Column(name: "IdDocument", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $IdDocument = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Annee = null;

    // #[ORM\Column(length: 50, nullable: true)]
    // private ?string $Auteur = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Descritpion = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Thème = null;

    public function getIddocument(): ?int
    {
        return $this->IdDocument;
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

    // public function getAuteur(): ?string
    // {
    //     return $this->Auteur;
    // }

    // public function setAuteur(?string $Auteur): static
    // {
    //     $this->Auteur = $Auteur;

    //     return $this;
    // }

    public function getDescritpion(): ?string
    {
        return $this->Descritpion;
    }

    public function setDescritpion(?string $Descritpion): static
    {
        $this->Descritpion = $Descritpion;

        return $this;
    }

    public function getThème(): ?string
    {
        return $this->Thème;
    }

    public function setThème(?string $Thème): static
    {
        $this->Thème = $Thème;

        return $this;
    }



    // #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'documents')]
    // #[ORM\JoinTable(name: 'auteur_document')]
    // #[ORM\JoinColumn(name: 'IdDocument', referencedColumnName: 'IdDocument')]
    // #[ORM\InverseJoinColumn(name: 'IdAuteur', referencedColumnName: 'IdAuteur')]
    // private Collection $auteurs;
    
    #[ORM\OneToMany(mappedBy: 'document', targetEntity: Ecrire::class)]
    private Collection $ecritures;


    
    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->exemplaires = new ArrayCollection();
    }
    
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }
    
    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs->add($auteur);
            $auteur->addDocument($this);
        }
        
        return $this;
    }
    
    public function removeAuteur(Auteur $auteur): static
    {
        if ($this->auteurs->removeElement($auteur)) {
            $auteur->removeDocument($this);
        }
        
        return $this;
    }
    
    
    
    
    
    #[ORM\OneToMany(mappedBy: 'document', targetEntity: Exemplaire::class)]
    private Collection $exemplaires;
    
    
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
