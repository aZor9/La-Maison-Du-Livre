<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Employe extends Utilisateur
{
    #[ORM\Column(type: 'string', length: 50)]
    private $statut;

    public function getStatut(): ?string { return $this->statut; }
    public function setStatut(string $statut): self { $this->statut = $statut; return $this; }
}
