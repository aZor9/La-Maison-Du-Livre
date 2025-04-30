<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Table(name: 'auteur')]
#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\Column(name: "IdAuteur", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $IdAuteur = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    public function getIdauteur(): ?int
    {
        return $this->IdAuteur;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }


    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Ecrire::class)]
    private Collection $ecritures;

    
    public function __construct()
    {
        $this->ecritures = new ArrayCollection();
    }
    
    public function getEcritures(): Collection
    {
        return $this->ecritures;
    }
    
    public function addEcriture(Ecrire $ecriture): static
    {
        if (!$this->ecritures->contains($ecriture)) {
            $this->ecritures->add($ecriture);
            $ecriture->setAuteur($this);
        }
    
        return $this;
    }
    
    public function removeEcriture(Ecrire $ecriture): static
    {
        if ($this->ecritures->removeElement($ecriture)) {
            // $ecriture->setAuteur(null); // (actuellement en test)
        }
    
        return $this;
    }
}