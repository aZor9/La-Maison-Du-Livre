<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
class Video extends Document
{
    #[ORM\Column(type: 'integer')]
    private $duree;

    #[ORM\Column(type: 'string', length: 50)]
    private $format;

    #[ORM\Column(type: 'string', length: 50)]
    private $realisateur;

    public function getDuree(): ?int { return $this->duree; }
    public function setDuree(int $duree): self { $this->duree = $duree; return $this; }

    public function getFormat(): ?string { return $this->format; }
    public function setFormat(string $format): self { $this->format = $format; return $this; }

    public function getRealisateur(): ?string { return $this->realisateur; }
    public function setRealisateur(string $realisateur): self { $this->realisateur = $realisateur; return $this; }
}
