<?php

namespace App\Tests\Entity;

use App\Entity\Auteur;
use App\Entity\Ecrire;
use PHPUnit\Framework\TestCase;

class AuteurTest extends TestCase
{
    public function testSetAndGetNom(): void
    {
        $auteur = new Auteur();
        $auteur->setNom('Eglantine');

        $this->assertEquals('Eglantine', $auteur->getNom());
    }

    public function testSetAndGetPrenom(): void
    {
        $auteur = new Auteur();
        $auteur->setPrenom('Cerisier');

        $this->assertEquals('Cerisier', $auteur->getPrenom());
    }

    public function testSetAndGetDescription(): void
    {
        $auteur = new Auteur();
        $auteur->setDescription('Auteur célèbre pour ses romans et poèmes.');

        $this->assertEquals('Auteur célèbre pour ses romans et poèmes.', $auteur->getDescription());
    }

    public function testAddAndRemoveEcriture(): void
    {
        $ecritureMock = $this->createMock(Ecrire::class);
        $ecritureMock->expects($this->once())
            ->method('setAuteur')
            ->with($this->isInstanceOf(Auteur::class));

        $auteur = new Auteur();
        $auteur->addEcriture($ecritureMock);

        $this->assertCount(1, $auteur->getEcritures());
        $this->assertSame($ecritureMock, $auteur->getEcritures()->first());

        $auteur->removeEcriture($ecritureMock);
        $this->assertCount(0, $auteur->getEcritures());
    }
}