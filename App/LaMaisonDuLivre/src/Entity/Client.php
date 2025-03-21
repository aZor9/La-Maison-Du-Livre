<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Client extends Utilisateur
{
    #[ORM\Column(type: 'string', length: 50)]
    private $statutAbonnement;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateFinAbonnement;

    #[ORM\ManyToOne(targetEntity: Abonnement::class)]
    #[ORM\JoinColumn(referencedColumnName: "idAbonnement", nullable: false)]
    private $abonnement;

    public function getStatutAbonnement(): ?string { return $this->statutAbonnement; }
    public function setStatutAbonnement(string $statutAbonnement): self { $this->statutAbonnement = $statutAbonnement; return $this; }

    public function getDateFinAbonnement(): ?\DateTimeInterface { return $this->dateFinAbonnement; }
    public function setDateFinAbonnement(?\DateTimeInterface $dateFinAbonnement): self { $this->dateFinAbonnement = $dateFinAbonnement; return $this; }

    public function getAbonnement(): ?Abonnement { return $this->abonnement; }
    public function setAbonnement(?Abonnement $abonnement): self { $this->abonnement = $abonnement; return $this; }
}