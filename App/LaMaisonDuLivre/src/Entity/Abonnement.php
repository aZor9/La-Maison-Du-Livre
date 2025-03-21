<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Abonnement
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 50)]
    private $idAbonnement;

    #[ORM\Column(type: 'decimal', precision: 19, scale: 4)]
    private $tarif;

    public function getId(): ?string { return $this->idAbonnement; }
    public function setId(string $idAbonnement): self { $this->idAbonnement = $idAbonnement; return $this; }

    public function getTarif(): ?float { return $this->tarif; }
    public function setTarif(float $tarif): self { $this->tarif = $tarif; return $this; }
}
