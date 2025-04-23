<?php

namespace App\DataFixtures;

use App\Entity\Abonnement;
use App\Entity\Auteur;
use App\Entity\Document;
use App\Entity\Livre;
use App\Entity\Sonore;
use App\Entity\TitrePeriodique;
use App\Entity\Video;
use App\Entity\Ecrire;
use App\Entity\Utilisateur;
use App\Entity\Exemplaire;
use App\Entity\Emprunt;
use App\Entity\EmpruntExemplaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Abonnements
        $abonnements = [];
        for ($i = 0; $i < 5; $i++) {
            $abonnement = new Abonnement();
            $abonnement->setStatutAbonnement($faker->word);
            $abonnement->setDateAbonnement($faker->dateTimeBetween('-1 years'));
            $abonnement->setDuree($faker->numberBetween(1, 12));
            $abonnement->setTarif($faker->randomFloat(2, 10, 100));
            $abonnement->setRemise($faker->numberBetween(0, 50));
            $manager->persist($abonnement);
            $abonnements[] = $abonnement;
        }

        // Auteurs
        $auteurs = [];
        for ($i = 0; $i < 10; $i++) {
            $auteur = new Auteur();
            $auteur->setPrenom($faker->firstName);
            $auteur->setNom($faker->lastName);
            $auteur->setDescription($faker->paragraph);
            $manager->persist($auteur);
            $auteurs[] = $auteur;
        }

        // Documents (polymorphes)
        $documents = [];

        for ($i = 0; $i < 30; $i++) {
            $document = new Document();
            $document->setTitre($faker->sentence(3));
            $document->setAnnee($faker->dateTimeBetween('-20 years', 'now'));
            $document->setDescritpion($faker->paragraph(2));
            $document->setThème($faker->word);
            $manager->persist($document);
            $documents[] = $document;

            // Relation Ecrire
            $nbAuteurs = rand(1, 3);
            $selectedAuteurs = $faker->randomElements($auteurs, $nbAuteurs);
            foreach ($selectedAuteurs as $auteur) {
                $ecrire = new Ecrire();
                $ecrire->setDocument($document);
                $ecrire->setAuteur($auteur);
                $manager->persist($ecrire);
            }

            // Type de document (héritage)
            $type = $faker->randomElement(['livre', 'video', 'sonore', 'periodique']);
            switch ($type) {
                case 'livre':
                    $livre = new Livre();
                    $livre->setIdDocument($document); // Associe le document parent
                    $livre->setIsbn($faker->isbn13());
                    $livre->setNombrePage($faker->numberBetween(100, 1000));
                    $livre->setGenre($faker->word);
                    $manager->persist($livre);
                    break;
                case 'video':
                    $video = new Video();
                    $video->setIdDocument($document);
                    $video->setDuree($faker->numberBetween(30, 180));
                    $video->setFormat('mp4');
                    $video->setRealisateur($faker->name);
                    $manager->persist($video);
                    break;
                case 'sonore':
                    $sonore = new Sonore();
                    $sonore->setIdDocument($document);
                    $sonore->setDuree($faker->numberBetween(60, 300));
                    $sonore->setFormat('mp3');
                    $sonore->setInterprete($faker->name);
                    $manager->persist($sonore);
                    break;
                case 'periodique':
                    $periodique = new TitrePeriodique();
                    $periodique->setIdDocument($document);
                    $periodique->setNumero($faker->numberBetween(1, 100));
                    $periodique->setDatePublication($faker->dateTimeBetween('-5 years'));
                    $periodique->setType($faker->word);
                    $manager->persist($periodique);
                    break;
            }
        }

        // Utilisateurs
        $utilisateurs = [];
        for ($i = 0; $i < 10; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($faker->lastName);
            $utilisateur->setPrenom($faker->firstName);
            $utilisateur->setDateNaissance($faker->dateTimeBetween('-60 years', '-18 years'));
            $utilisateur->setAdresse1($faker->streetAddress);
            $utilisateur->setAdresse2($faker->secondaryAddress);
            $utilisateur->setVille($faker->city);
            $utilisateur->setPays($faker->country);
            $utilisateur->setMail($faker->unique()->email);
            $utilisateur->setNumeroTelephone($faker->phoneNumber);
            $utilisateur->setSituation('étudiant');
            $utilisateur->setRole('client');
            $utilisateur->setLienJustificatif($faker->url);
            $utilisateur->setStatut('actif');
            $utilisateur->setIdAbonnement($faker->randomElement($abonnements));
            $manager->persist($utilisateur);
            $utilisateurs[] = $utilisateur;
        }

        // Exemplaires
        $exemplaires = [];
        foreach ($documents as $doc) {
            for ($j = 0; $j < rand(1, 3); $j++) {
                $ex = new Exemplaire();
                $ex->setEtatPhysique($faker->randomElement(['neuf', 'bon', 'usé']));
                $ex->setStatut('disponible');
                $ex->setIdDocument($doc);
                $manager->persist($ex);
                $exemplaires[] = $ex;
            }
        }

        // Emprunts + EmpruntExemplaires
        for ($i = 0; $i < 20; $i++) {
            $emprunt = new Emprunt();
            $emprunt->setDateReservation($faker->dateTimeBetween('-1 year'));
            $emprunt->setDateRendu($faker->dateTimeBetween('-6 months', 'now'));
            $emprunt->setIdUtilisateur($faker->randomElement($utilisateurs));
            $manager->persist($emprunt);

            foreach ($faker->randomElements($exemplaires, rand(1, 2)) as $exemplaire) {
                $empEx = new EmpruntExemplaire();
                $empEx->setIdEmprunt($emprunt);
                $empEx->setIdExemplaire($exemplaire);
                $manager->persist($empEx);
            }
        }

        $manager->flush();
    }
}
