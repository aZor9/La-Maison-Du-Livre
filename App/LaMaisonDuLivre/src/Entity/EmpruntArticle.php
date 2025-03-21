<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class EmpruntArticle
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Article::class)]
    #[ORM\JoinColumn(name: "idArticle", referencedColumnName: "idArticle", nullable: false)]
    private $article;
    
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Emprunt::class)]
    #[ORM\JoinColumn(name: "idEmprunt", referencedColumnName: "idEmprunt", nullable: false)]
    private $emprunt;
    

    public function getArticle(): ?Article { return $this->article; }
    public function setArticle(?Article $article): self { $this->article = $article; return $this; }

    public function getEmprunt(): ?Emprunt { return $this->emprunt; }
    public function setEmprunt(?Emprunt $emprunt): self { $this->emprunt = $emprunt; return $this; }
}
