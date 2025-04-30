<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Empruntexemplaire;

#[ORM\Table(name: 'emprunt')]
#[ORM\Index(name: 'IdUtilisateur', columns: ['IdUtilisateur'])]
#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\Column(name: "IdEmprunt", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $IdEmprunt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateReservation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateRendu = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: "IdUtilisateur", referencedColumnName: "IdUtilisateur")]
    private ?Utilisateur $utilisateur = null;

    public function getIdemprunt(): ?int
    {
        return $this->IdEmprunt;
    }

    public function getDatereservation(): ?\DateTimeInterface
    {
        return $this->DateReservation;
    }

    public function setDatereservation(?\DateTimeInterface $DateReservation): static
    {
        $this->DateReservation = $DateReservation;

        return $this;
    }

    public function getDaterendu(): ?\DateTimeInterface
    {
        return $this->DateRendu;
    }

    public function setDaterendu(?\DateTimeInterface $DateRendu): static
    {
        $this->DateRendu = $DateRendu;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }


    #[ORM\OneToMany(mappedBy: 'emprunt', targetEntity: Empruntexemplaire::class)]
    private Collection $empruntexemplaires;

    public function __construct()
    {
        $this->empruntexemplaires = new ArrayCollection();
    }

    public function getEmpruntexemplaires(): Collection
    {
        return $this->empruntexemplaires;
    }

    public function addEmpruntexemplaire(Empruntexemplaire $ex): static
    {
        if (!$this->empruntexemplaires->contains($ex)) {
            $this->empruntexemplaires->add($ex);
            $ex->setEmprunt($this);
        }

        return $this;
    }

    public function removeEmpruntexemplaire(Empruntexemplaire $ex): static
    {
        if ($this->empruntexemplaires->removeElement($ex)) {
            if ($ex->getEmprunt() === $this) {
                $ex->setEmprunt(null);
            }
        }

        return $this;
    }
}