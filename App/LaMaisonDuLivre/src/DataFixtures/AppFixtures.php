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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // --- Abonnements
        $abonnements = [];
        for ($i = 0; $i < 5; $i++) {
            $abonnement = new Abonnement();
            $abonnement->setStatutAbonnement('en cours')
                       ->setDateAbonnement($faker->dateTimeBetween('-1 years'))
                       ->setDuree(12);
            if ($i % 2 == 0) {
                $abonnement->setTarif(20)
                ->setRemise(0);
            }
            else {
                $abonnement->setTarif(10)
                ->setRemise(50);
            }
            $manager->persist($abonnement);
            $abonnements[] = $abonnement;
        }

        // --- Auteurs
        $auteurs = [];
        for ($i = 0; $i < 10; $i++) {
            $auteur = new Auteur();
            $auteur->setPrenom($faker->firstName)
                   ->setNom($faker->lastName)
                   ->setDescription($faker->paragraph);
            $manager->persist($auteur);
            $auteurs[] = $auteur;
        }

        // --- Documents
        $documents = [];
        for ($i = 0; $i < 30; $i++) {
            $type = $faker->randomElement(['livre', 'video', 'sonore', 'periodique']);

            switch ($type) {
                case 'livre':
                    $document = new Livre();
                    $document->setIsbn($faker->isbn13())
                             ->setNombrePage($faker->numberBetween(100, 1000))
                             ->setGenre($faker->word);
                    break;

                case 'video':
                    $document = new Video();
                    $document->setDuree($faker->numberBetween(30, 180))
                             ->setFormat('mp4')
                             ->setRealisateur($faker->name);
                    break;

                case 'sonore':
                    $document = new Sonore();
                    $document->setDuree($faker->numberBetween(60, 300))
                             ->setFormat('mp3')
                             ->setInterprete($faker->name);
                    break;

                case 'periodique':
                    $document = new TitrePeriodique();
                    $document->setNumero($faker->numberBetween(1, 100))
                             ->setDatePublication($faker->dateTimeBetween('-5 years'))
                             ->setFormat($faker->word);
                    break;
            }

            $document->setTitre($faker->sentence(3))
                     ->setAnnee($faker->dateTimeBetween('-20 years', 'now'))
                     ->setDescritpion($faker->paragraph(2))
                     ->setThème($faker->randomElement(['SF', 'Horreur', 'Tech', 'Amour', 'Aventure']));

            $manager->persist($document);
            $documents[] = $document;

            // --- Relation Ecrire (Document ↔ Auteur)
            $nbAuteurs = rand(1, 3);
            $selectedAuteurs = $faker->randomElements($auteurs, $nbAuteurs);
            foreach ($selectedAuteurs as $auteur) {
                $ecrire = new Ecrire();
                $ecrire->setDocument($document)
                       ->setAuteur($auteur);
                $manager->persist($ecrire);
            }
        }

        // --- Utilisateurs
        $utilisateurs = [];
        for ($i = 0; $i < 10; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($faker->lastName)
                        ->setPrenom($faker->firstName)
                        ->setDateNaissance($faker->dateTimeBetween('-60 years', '-18 years'))
                        ->setAdresse1($faker->streetAddress)
                        ->setAdresse2($faker->secondaryAddress)
                        ->setVille($faker->city)
                        ->setPays($faker->country)
                        ->setMail($faker->unique()->email)
                        ->setNumeroTelephone($faker->phoneNumber)
                        ->setSituation($faker->randomElement(['étudiant', 'chomage', 'travailleur']))
                        ->setRole('ROLE_USER')
                        ->setLienJustificatif($faker->url)
                        ->setStatut('actif')
                        ->setAbonnement($faker->randomElement($abonnements))
                        ->setMotDePasse($this->hasher->hashPassword($utilisateur, 'password123'));
            $manager->persist($utilisateur);
            $utilisateurs[] = $utilisateur;
        }

        // --- Exemplaires
        $exemplaires = [];
        foreach ($documents as $document) {
            for ($j = 0; $j < rand(1, 3); $j++) {
                $exemplaire = new Exemplaire();
                $exemplaire->setEtatPhysique($faker->randomElement(['neuf', 'bon', 'usé']))
                           ->setStatut('disponible')
                           ->setDocument($document);
                $manager->persist($exemplaire);
                $exemplaires[] = $exemplaire;
            }
        }

        // --- Emprunts et EmpruntExemplaires
        for ($i = 0; $i < 20; $i++) {
            $emprunt = new Emprunt();
            $emprunt->setDateReservation($faker->dateTimeBetween('-1 year'))
                    ->setDateRendu($faker->dateTimeBetween('-6 months', 'now'))
                    ->setUtilisateur($faker->randomElement($utilisateurs));
            $manager->persist($emprunt);

            foreach ($faker->randomElements($exemplaires, rand(1, 2)) as $exemplaire) {
                $empruntExemplaire = new EmpruntExemplaire();
                $empruntExemplaire->setEmprunt($emprunt)
                                  ->setExemplaire($exemplaire);
                $manager->persist($empruntExemplaire);
            }
        }

        // --- Envoi en base de toutes les entités
        $manager->flush();
    }
}
