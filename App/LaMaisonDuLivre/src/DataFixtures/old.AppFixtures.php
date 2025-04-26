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
        $entityManager = $manager;
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


        // Ajouter cette ligne avant la boucle
        $documents = []; // Initialise le tableau des documents

        for ($i = 0; $i < 30; $i++) {
            $type = $faker->randomElement(['livre', 'video', 'sonore', 'periodique']);
            
            // Création du document parent
            switch ($type) {
                case 'livre':
                    $document = new Livre();
                    $document->setIsbn($faker->isbn13());
                    $document->setNombrePage($faker->numberBetween(100, 1000));
                    $document->setGenre($faker->word);
                    break;
            
                case 'video':
                    $document = new Video();
                    $document->setDuree($faker->numberBetween(30, 180));
                    $document->setFormat('mp4');
                    $document->setRealisateur($faker->name);
                    break;
            
                case 'sonore':
                    $document = new Sonore();
                    $document->setDuree($faker->numberBetween(60, 300));
                    $document->setFormat('mp3');
                    $document->setInterprete($faker->name);
                    break;
            
                case 'periodique':
                    $document = new TitrePeriodique();
                    $document->setNumero($faker->numberBetween(1, 100));
                    $document->setDatePublication($faker->dateTimeBetween('-5 years'));
                    $document->setFormat($faker->word);
                    break;
            }
            
            // Attributs communs à tous les types de document
            $document->setTitre($faker->sentence(3));
            $document->setAnnee($faker->dateTimeBetween('-20 years', 'now'));
            $document->setDescritpion($faker->paragraph(2));
            $document->setThème($faker->word);

            $manager->persist($document); // Persister le document parent
            $documents[] = $document; // Ajouter le document au tableau

            // Relation Ecrire avec des auteurs
            $nbAuteurs = rand(1, 3);
            $selectedAuteurs = $faker->randomElements($auteurs, $nbAuteurs);
            foreach ($selectedAuteurs as $auteur) {
                $ecrire = new Ecrire();
                $ecrire->setDocument($document); // Associer chaque document à ses auteurs
                $ecrire->setAuteur($auteur);
                $manager->persist($ecrire);
            }
        }

        $manager->flush();
        
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
            $utilisateur->setAbonnement($faker->randomElement($abonnements));
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
                $ex->setDocument($doc);
                $manager->persist($ex);
                $exemplaires[] = $ex;
            }
        }

        // Emprunts + EmpruntExemplaires
        for ($i = 0; $i < 20; $i++) {
            $emprunt = new Emprunt();
            $emprunt->setDateReservation($faker->dateTimeBetween('-1 year'));
            $emprunt->setDateRendu($faker->dateTimeBetween('-6 months', 'now'));
            $emprunt->setUtilisateur($faker->randomElement($utilisateurs));
            $manager->persist($emprunt);

            foreach ($faker->randomElements($exemplaires, rand(1, 2)) as $exemplaire) {
                $empEx = new EmpruntExemplaire();
                $empEx->setEmprunt($emprunt);
                $empEx->setExemplaire($exemplaire);
                $manager->persist($empEx);
            }
        }

    $manager->flush();
    }
}
