<?php

namespace App\Entity;

use App\Repository\EmpruntexemplaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Table(name: 'empruntexemplaire')]
#[ORM\Index(name: 'IdExemplaire', columns: ['IdExemplaire'])]
#[ORM\Entity(repositoryClass: EmpruntexemplaireRepository::class)]
class Empruntexemplaire
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Emprunt::class, inversedBy: 'empruntexemplaires')]
    #[ORM\JoinColumn(name: 'IdEmprunt', referencedColumnName: 'IdEmprunt')]
    private ?Emprunt $emprunt = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Exemplaire::class, inversedBy: 'empruntexemplaires')]
    #[ORM\JoinColumn(name: 'IdExemplaire', referencedColumnName: 'IdExemplaire')]
    private ?Exemplaire $exemplaire = null;

    public function getEmprunt(): ?Emprunt
    {
        return $this->emprunt;
    }

    public function setEmprunt(?Emprunt $emprunt): static
    {
        $this->emprunt = $emprunt;

        return $this;
    }

    public function getExemplaire(): ?Exemplaire
    {
        return $this->exemplaire;
    }

    public function setExemplaire(?Exemplaire $exemplaire): static
    {
        $this->exemplaire = $exemplaire;

        return $this;
    }
}

