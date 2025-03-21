<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Livre extends Document
{
    #[ORM\Column(type: 'string', length: 50)]
    private $isbn;

    #[ORM\Column(type: 'integer')]
    private $nombrePage;

    #[ORM\Column(type: 'string', length: 50)]
    private $genre;

    public function getIsbn(): ?string { return $this->isbn; }
    public function setIsbn(string $isbn): self { $this->isbn = $isbn; return $this; }

    public function getNombrePage(): ?int { return $this->nombrePage; }
    public function setNombrePage(int $nombrePage): self { $this->nombrePage = $nombrePage; return $this; }

    public function getGenre(): ?string { return $this->genre; }
    public function setGenre(string $genre): self { $this->genre = $genre; return $this; }
}
