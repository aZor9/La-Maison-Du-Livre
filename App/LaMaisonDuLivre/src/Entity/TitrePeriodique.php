<?php


namespace App\Entity;
use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TitrePeriodique extends Document
{
    #[ORM\Column(type: 'integer')]
    private $numero;

    #[ORM\Column(type: 'date')]
    private $datePublication;

    #[ORM\Column(type: 'string', length: 50)]
    private $categorie;

    public function getNumero(): ?int { return $this->numero; }
    public function setNumero(int $numero): self { $this->numero = $numero; return $this; }

    public function getDatePublication(): ?\DateTimeInterface { return $this->datePublication; }
    public function setDatePublication(\DateTimeInterface $datePublication): self { $this->datePublication = $datePublication; return $this; }

    public function getType(): ?string { return $this->categorie; }
    public function setType(string $categorie): self { $this->categorie = $categorie; return $this; }
}
