<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Sonore extends Document
{
    #[ORM\Column(type: 'integer')]
    private $duree;

    #[ORM\Column(type: 'string', length: 50)]
    private $format;

    #[ORM\Column(type: 'string', length: 50)]
    private $interprete;

    public function getDuree(): ?int { return $this->duree; }
    public function setDuree(int $duree): self { $this->duree = $duree; return $this; }

    public function getFormat(): ?string { return $this->format; }
    public function setFormat(string $format): self { $this->format = $format; return $this; }

    public function getInterprete(): ?string { return $this->interprete; }
    public function setInterprete(string $interprete): self { $this->interprete = $interprete; return $this; }
}
