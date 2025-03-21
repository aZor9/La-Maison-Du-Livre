<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "document" => Document::class,
    "livre" => Livre::class,
    "titre_periodique" => TitrePeriodique::class,
    "sonore" => Sonore::class,
    "video" => Video::class
])]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $titre;

    #[ORM\Column(type: 'date')]
    private $annee;

    #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'documents')]
    #[ORM\JoinTable(name: 'ecrire')]
    #[ORM\Column(type: 'string', length: 50)]
    private $auteur;

    #[ORM\Column(type: 'text')]
    private $resume;

    // Getters & Setters
    public function getId(): ?int { return $this->id; }
    public function getTitre(): ?string { return $this->titre; }
    public function setTitre(string $titre): self { $this->titre = $titre; return $this; }

    public function getAnnee(): ?\DateTimeInterface { return $this->annee; }
    public function setAnnee(\DateTimeInterface $annee): self { $this->annee = $annee; return $this; }

    public function getAuteur(): ?string { return $this->auteur; }
    public function setAuteur(string $auteur): self { $this->auteur = $auteur; return $this; }

    public function getResume(): ?string { return $this->resume; }
    public function setResume(string $resume): self { $this->resume = $resume; return $this; }
}
