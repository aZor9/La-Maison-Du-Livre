<?php

namespace App\Entity;

use App\Repository\TitreperiodiqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Table(name: 'titreperiodique')]
#[ORM\Entity(repositoryClass: TitreperiodiqueRepository::class)]
class Titreperiodique extends Document
{
    // #[ORM\Column]
    // #[ORM\Id]
    // #[ORM\GeneratedValue(strategy: "NONE")]
    // private ?int $id_document = null;

    #[ORM\Column(nullable: true, type: "integer")]
    private ?int $Numero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DatePublication = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Format = null;

    public function getid_document(): ?int
    {
        return $this->id_document;
    }

    public function setid_document(int $id_document): static
    {
        $this->id_document = $id_document;

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

    public function getFormat(): ?string
    {
        return $this->Format;
    }

    public function setFormat(?string $Format): static
    {
        $this->Format = $Format;

        return $this;
    }
}
