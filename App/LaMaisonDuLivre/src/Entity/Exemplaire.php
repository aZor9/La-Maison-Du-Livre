<?php

namespace App\Entity;

use App\Repository\ExemplaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Document;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Empruntexemplaire;

#[ORM\Table(name: 'exemplaire')]
#[ORM\Index(name: 'id_document', columns: ['id_document'])]
#[ORM\Entity(repositoryClass: ExemplaireRepository::class)]
class Exemplaire
{
    #[ORM\Id]
    #[ORM\Column(name: "IdExemplaire", type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private ?int $IdExemplaire = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $EtatPhysique = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Statut = null;

    #[ORM\Column]
    private ?int $id_document = null;

    public function getIdexemplaire(): ?int
    {
        return $this->IdExemplaire;
    }

    public function setIdexemplaire(int $IdExemplaire): static
    {
        $this->IdExemplaire = $IdExemplaire;

        return $this;
    }

    public function getEtatphysique(): ?string
    {
        return $this->EtatPhysique;
    }

    public function setEtatphysique(?string $EtatPhysique): static
    {
        $this->EtatPhysique = $EtatPhysique;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(?string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    // public function getid_document(): ?int
    // {
    //     return $this->id_document;
    // }

    // public function setid_document(int $id_document): static
    // {
    //     $this->id_document = $id_document;

    //     return $this;
    // }


    #[ORM\ManyToOne(targetEntity: Document::class, inversedBy: 'exemplaires')]
    #[ORM\JoinColumn(name: 'id_document', referencedColumnName: 'id_document', nullable: false)]
    private ?Document $document = null;
    
    public function getDocument(): ?Document
    {
        return $this->document;
    }
    
    public function setDocument(?Document $document): static
    {
        $this->document = $document;
        return $this;
    }
    











    #[ORM\OneToMany(mappedBy: 'exemplaire', targetEntity: Empruntexemplaire::class)]
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
            $ex->setExemplaire($this);
        }

        return $this;
    }

    public function removeEmpruntexemplaire(Empruntexemplaire $ex): static
    {
        if ($this->empruntexemplaires->removeElement($ex)) {
            if ($ex->getExemplaire() === $this) {
                $ex->setExemplaire(null);
            }
        }

        return $this;
    }

}
