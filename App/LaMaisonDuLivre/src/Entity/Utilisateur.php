<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Abonnement; 
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface; 


#[ORM\Table(name: 'utilisateur')]
#[ORM\Index(name: 'IdAbonnement', columns: ['IdAbonnement'])]
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    // #[ORM\Column]
    #[ORM\Id]
    #[ORM\Column(name: "IdUtilisateur", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $IdUtilisateur = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateNaissance = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Adresse1 = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Adresse2 = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Ville = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Pays = null;

    #[ORM\Column(length: 50)]
    private ?string $mail = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $NumeroTelephone = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Situation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Role = null;

    #[ORM\Column(length: 5000, nullable: true)]
    private ?string $LienJustificatif = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Statut = null;

    #[ORM\Column]
    private ?string $motdepasse = null;

    // #[ORM\Column(nullable: true)]
    // private ?int $IdAbonnement = null;

    #[ORM\ManyToOne(targetEntity: Abonnement::class)]
    #[ORM\JoinColumn(name: "IdAbonnement", referencedColumnName: "IdAbonnement")]
    private ?Abonnement $abonnement = null;

    public function getIdutilisateur(): ?int
    {
        return $this->IdUtilisateur;
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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->DateNaissance;
    }

    public function setDatenaissance(?\DateTimeInterface $DateNaissance): static
    {
        $this->DateNaissance = $DateNaissance;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->Adresse1;
    }

    public function setAdresse1(?string $Adresse1): static
    {
        $this->Adresse1 = $Adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->Adresse2;
    }

    public function setAdresse2(?string $Adresse2): static
    {
        $this->Adresse2 = $Adresse2;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(?string $Ville): static
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(?string $Pays): static
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getNumerotelephone(): ?string
    {
        return $this->NumeroTelephone;
    }

    public function setNumerotelephone(?string $NumeroTelephone): static
    {
        $this->NumeroTelephone = $NumeroTelephone;

        return $this;
    }

    public function getSituation(): ?string
    {
        return $this->Situation;
    }

    public function setSituation(?string $Situation): static
    {
        $this->Situation = $Situation;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(?string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    public function getLienjustificatif(): ?string
    {
        return $this->LienJustificatif;
    }

    public function setLienjustificatif(?string $LienJustificatif): static
    {
        $this->LienJustificatif = $LienJustificatif;

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

    public function getMotDePasse(): string
    {
        return $this->motdepasse;
    }

    public function setMotDePasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;
        return $this;
    }

    public function getAbonnement(): ?Abonnement
    {
        return $this->abonnement;
    }

    public function setAbonnement(?Abonnement $abonnement): static
    {
        $this->abonnement = $abonnement;

        return $this;
    }





    // Méthodes de UserInterface

    public function getRoles(): array
    {
        // Symfony attend un tableau de rôles => on transforme ton champ Role en tableau
        $roles = [];

        if ($this->Role) {
            $roles[] = $this->Role;
        }

        // Assure qu'il y a toujours au moins ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword(): ?string
    {
        return $this->motdepasse;
    }

    public function getSalt(): ?string
    {
        // Pas nécessaire avec bcrypt ou argon2i
        return null;
    }

    public function getUserIdentifier(): string
    {
        // Symfony 5.3+ -> utiliser getUserIdentifier à la place de getUsername
        return $this->mail;
    }

    public function eraseCredentials(): void
    {
        // Si on stockait temporairement des mots de passe en clair, on les effacerait ici
    }

    // Pour compatibilité (optionnel)
    public function getUsername(): string
    {
        return $this->mail;
    }
}
