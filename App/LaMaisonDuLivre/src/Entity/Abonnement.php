<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Table(name: 'abonnement')]
#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    // #[ORM\Column]
    #[ORM\Id]
    #[ORM\Column(name: "IdAbonnement", type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private ?int $IdAbonnement = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $StatutAbonnement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateAbonnement = null;

    #[ORM\Column(nullable: true)]
    private ?int $Duree = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 19, scale: 4, nullable: true)]
    private ?string $Tarif = null;

    #[ORM\Column(nullable: true)]
    private ?int $Remise = null;

    public function getIdabonnement(): ?int
    {
        return $this->IdAbonnement;
    }

    public function setIdabonnement(int $IdAbonnement): static
    {
        $this->IdAbonnement = $IdAbonnement;

        return $this;
    }

    public function getStatutabonnement(): ?string
    {
        return $this->StatutAbonnement;
    }

    public function setStatutabonnement(?string $StatutAbonnement): static
    {
        $this->StatutAbonnement = $StatutAbonnement;

        return $this;
    }

    public function getDateabonnement(): ?\DateTimeInterface
    {
        return $this->DateAbonnement;
    }

    public function setDateabonnement(?\DateTimeInterface $DateAbonnement): static
    {
        $this->DateAbonnement = $DateAbonnement;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->Duree;
    }

    public function setDuree(?int $Duree): static
    {
        $this->Duree = $Duree;

        return $this;
    }

    public function getTarif(): ?string
    {
        return $this->Tarif;
    }

    public function setTarif(?string $Tarif): static
    {
        $this->Tarif = $Tarif;

        return $this;
    }

    public function getRemise(): ?int
    {
        return $this->Remise;
    }

    public function setRemise(?int $Remise): static
    {
        $this->Remise = $Remise;

        return $this;
    }
    
    
    public function isNearExpiration(): bool
    {
        if ($this->StatutAbonnement === 'en cours (1an)' && $this->DateAbonnement) {
            $diff = $this->DateAbonnement->diff(new \DateTime());
            return $diff->y === 0 && $diff->m === 11; // Entre 11 et 12 mois
        }
        
        if ($this->StatutAbonnement === 'en cours (6mois)' && $this->DateAbonnement) {
            $diff = $this->DateAbonnement->diff(new \DateTime());
            return $diff->y === 0 && $diff->m === 5; // Entre 5 et 6 mois
        }
        
        return false;
    }
    
    public function isExpired(): bool
    {
            if ($this->StatutAbonnement === 'en cours (1an)' && $this->DateAbonnement) {
                $diff = $this->DateAbonnement->diff(new \DateTime());
                return $diff->y >= 1; // Plus d'un an
        }

        if ($this->StatutAbonnement === 'en cours (6mois)' && $this->DateAbonnement) {
            $diff = $this->DateAbonnement->diff(new \DateTime());
            return $diff->y === 0 && $diff->m >= 6; // Plus de 6 mois
        }
        
        return false;   
    }

    public function __toString(): string
    {
        return $this->StatutAbonnement ?? 'Aucun abonnement';
    }
}