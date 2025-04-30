<?php

namespace App\Tests\Entity;

use App\Entity\Utilisateur;
use PHPUnit\Framework\TestCase;

class UtilisateurTest extends TestCase
{
    public function testSetAndGetNom(): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setNom('Dupont');

        $this->assertEquals('Dupont', $utilisateur->getNom());
    }

    public function testSetAndGetMail(): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setMail('dupont@example.com');

        $this->assertEquals('dupont@example.com', $utilisateur->getMail());
    }

    public function testSetAndGetPassword(): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setMotDePasse('password123');

        $this->assertEquals('password123', $utilisateur->getPassword());
    }

    public function testSetAndGetRoles(): void
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setRole('ROLE_ADMIN');

        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $utilisateur->getRoles());
    }
}