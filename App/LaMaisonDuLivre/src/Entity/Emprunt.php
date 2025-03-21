<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $idEmprunt;

    #[ORM\Column(type: 'date')]
    private $dateReservation;

    #[ORM\Column(type: 'date')]
    private $dateRenduPrevision;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateRendu;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: "idUtilisateur", referencedColumnName: "idUtilisateur", nullable: false)]
    private $utilisateur;

    #[ORM\OneToMany(mappedBy: 'emprunt', targetEntity: EmpruntArticle::class, cascade: ['persist', 'remove'])]
    private $empruntArticles;

    public function __construct() { $this->empruntArticles = new ArrayCollection(); }

    public function getIdEmprunt(): ?int { return $this->idEmprunt; }
    public function getDateReservation(): ?\DateTimeInterface { return $this->dateReservation; }
    public function setDateReservation(\DateTimeInterface $dateReservation): self { $this->dateReservation = $dateReservation; return $this; }

    public function getDateRenduPrevision(): ?\DateTimeInterface { return $this->dateRenduPrevision; }
    public function setDateRenduPrevision(\DateTimeInterface $dateRenduPrevision): self { $this->dateRenduPrevision = $dateRenduPrevision; return $this; }

    public function getDateRendu(): ?\DateTimeInterface { return $this->dateRendu; }
    public function setDateRendu(?\DateTimeInterface $dateRendu): self { $this->dateRendu = $dateRendu; return $this; }

    public function getUtilisateur(): ?Utilisateur { return $this->utilisateur; }
    public function setUtilisateur(?Utilisateur $utilisateur): self { $this->utilisateur = $utilisateur; return $this; }
}