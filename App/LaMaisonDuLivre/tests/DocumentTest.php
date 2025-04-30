<?php

namespace App\Tests\Entity;

use App\Entity\Document;
use App\Entity\Exemplaire;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testSetAndGetTitre(): void
    {
        $document = new Document();
        $document->setTitre('Les Misérables');

        $this->assertEquals('Les Misérables', $document->getTitre());
    }

    public function testSetAndGetAnnee(): void
    {
        $document = new Document();
        $annee = new \DateTime('1862-01-01');
        $document->setAnnee($annee);

        $this->assertEquals($annee, $document->getAnnee());
    }

    public function testSetAndGetDescription(): void
    {
        $document = new Document();
        $document->setDescritpion('Un roman historique écrit par Victor Hugo.');

        $this->assertEquals('Un roman historique écrit par Victor Hugo.', $document->getDescritpion());
    }

    public function testSetAndGetTheme(): void
    {
        $document = new Document();
        $document->setTheme('Littérature');

        $this->assertEquals('Littérature', $document->getTheme());
    }

    public function testAddAndRemoveExemplaire(): void
    {
        $exemplaireMock = $this->createMock(Exemplaire::class);
        $exemplaireMock->expects($this->once())
            ->method('setDocument')
            ->with($this->isInstanceOf(Document::class));

        $document = new Document();
        $document->addExemplaire($exemplaireMock);

        $this->assertCount(1, $document->getExemplaires());
        $this->assertSame($exemplaireMock, $document->getExemplaires()->first());

        $document->removeExemplaire($exemplaireMock);
        $this->assertCount(0, $document->getExemplaires());
    }
}