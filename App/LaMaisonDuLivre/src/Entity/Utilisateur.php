<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["utilisateur" => Utilisateur::class, "client" => Client::class, "employe" => Employe::class])]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nom;

    #[ORM\Column(type: 'string', length: 50)]
    private $prenom;

    #[ORM\Column(type: 'date')]
    private $dateNaissance;

    #[ORM\Column(type: 'string', length: 50)]
    private $adresse1;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $adresse2;

    #[ORM\Column(type: 'string', length: 50)]
    private $ville;

    #[ORM\Column(type: 'string', length: 50)]
    private $pays;

    #[ORM\Column(type: 'string', length: 50)]
    private $mail;

    #[ORM\Column(type: 'string', length: 50)]
    private $numeroTelephone;

    #[ORM\Column(type: 'string', length: 50)]
    private $situation;

    // Getters & Setters
    public function getIdUtilisateur(): ?int { return $this->id; }
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }
    
    public function getPrenom(): ?string { return $this->prenom; }
    public function setPrenom(string $prenom): self { $this->prenom = $prenom; return $this; }

    public function getDateNaissance(): ?\DateTimeInterface { return $this->dateNaissance; }
    public function setDateNaissance(\DateTimeInterface $dateNaissance): self { $this->dateNaissance = $dateNaissance; return $this; }

    public function getAdresse1(): ?string { return $this->adresse1; }
    public function setAdresse1(string $adresse1): self { $this->adresse1 = $adresse1; return $this; }

    public function getAdresse2(): ?string { return $this->adresse2; }
    public function setAdresse2(?string $adresse2): self { $this->adresse2 = $adresse2; return $this; }

    public function getVille(): ?string { return $this->ville; }
    public function setVille(string $ville): self { $this->ville = $ville; return $this; }

    public function getPays(): ?string { return $this->pays; }
    public function setPays(string $pays): self { $this->pays = $pays; return $this; }

    public function getMail(): ?string { return $this->mail; }
    public function setMail(string $mail): self { $this->mail = $mail; return $this; }

    public function getNumeroTelephone(): ?string { return $this->numeroTelephone; }
    public function setNumeroTelephone(string $numeroTelephone): self { $this->numeroTelephone = $numeroTelephone; return $this; }

    public function getSituation(): ?string { return $this->situation; }
    public function setSituation(string $situation): self { $this->situation = $situation; return $this; }
}
