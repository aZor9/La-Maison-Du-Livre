<?php

namespace App\Tests\Entity;

use App\Entity\Exemplaire;
use PHPUnit\Framework\TestCase;

class ExemplaireTest extends TestCase
{
    public function testSetAndGetEtatPhysique(): void
    {
        $exemplaire = new Exemplaire();
        $exemplaire->setEtatPhysique('neuf');

        $this->assertEquals('neuf', $exemplaire->getEtatPhysique());
    }

    public function testSetAndGetStatut(): void
    {
        $exemplaire = new Exemplaire();
        $exemplaire->setStatut('disponible');

        $this->assertEquals('disponible', $exemplaire->getStatut());
    }

    public function testSetAndGetDocument(): void
    {
        $documentMock = $this->createMock(\App\Entity\Document::class);
        $exemplaire = new Exemplaire();
        $exemplaire->setDocument($documentMock);

        $this->assertSame($documentMock, $exemplaire->getDocument());
    }

    public function testAddAndRemoveEmpruntexemplaire(): void
    {
        $empruntexemplaireMock = $this->createMock(\App\Entity\Empruntexemplaire::class);
        $empruntexemplaireMock->expects($this->once())
            ->method('setExemplaire')
            ->with($this->isInstanceOf(Exemplaire::class));

        $exemplaire = new Exemplaire();
        $exemplaire->addEmpruntexemplaire($empruntexemplaireMock);

        $this->assertCount(1, $exemplaire->getEmpruntexemplaires());
        $this->assertSame($empruntexemplaireMock, $exemplaire->getEmpruntexemplaires()->first());

        $exemplaire->removeEmpruntexemplaire($empruntexemplaireMock);
        $this->assertCount(0, $exemplaire->getEmpruntexemplaires());
    }

    public function testSetAndGetIdExemplaire(): void
    {
        $exemplaire = new Exemplaire();
        $exemplaire->setIdexemplaire(123);

        $this->assertEquals(123, $exemplaire->getIdexemplaire());
    }
}