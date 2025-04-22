<?php

namespace App\Entity;

use App\Repository\TitreperiodiqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'titreperiodique')]
#[ORM\Entity(repositoryClass: TitreperiodiqueRepository::class)]
class Titreperiodique
{
    #[ORM\Column]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private ?int $IdDocument = null;

    #[ORM\Column(nullable: true)]
    private ?int $Numero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DatePublication = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Type = null;

    public function getIddocument(): ?int
    {
        return $this->IdDocument;
    }

    public function setIddocument(int $IdDocument): static
    {
        $this->IdDocument = $IdDocument;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(?int $Numero): static
    {
        $this->Numero = $Numero;

        return $this;
    }

    public function getDatepublication(): ?\DateTimeInterface
    {
        return $this->DatePublication;
    }

    public function setDatepublication(?\DateTimeInterface $DatePublication): static
    {
        $this->DatePublication = $DatePublication;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }
}
