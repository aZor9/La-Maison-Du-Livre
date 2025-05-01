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
        // --- Auteurs célèbres
        $auteurs = [];
        $auteursData = [
            ['Jean', 'de La Fontaine', 'Auteur des célèbres fables.'],
            ['Victor', 'Hugo', 'Auteur des Misérables et Notre-Dame de Paris.'],
            ['Jules', 'Verne', 'Auteur de romans d\'aventures comme Vingt mille lieues sous les mers.'],
            ['Émile', 'Zola', 'Auteur de Germinal et chef de file du naturalisme.'],
            ['Marcel', 'Proust', 'Auteur de À la recherche du temps perdu.'],
        ];

        foreach ($auteursData as $data) {
            $auteur = new Auteur();
            $auteur->setPrenom($data[0])
                   ->setNom($data[1])
                   ->setDescription($data[2]);
            $manager->persist($auteur);
            $auteurs[] = $auteur;
        }

        // --- Documents
        $documents = [];

        // Livres
        $livresData = [
            ['Les Fables', 1668, 'Fables', '9781234567897', 300, 'roman'],
            ['Les Misérables', 1862, 'Roman', '9789876543210', 1200, 'roman'],
            ['Voyage au centre de la Terre', 1864, 'Aventure', '9782345678901', 400, 'roman'],
            ['Vingt mille lieues sous les mers', 1870, 'Aventure', '9781122334455', 500, 'sience fiction'],
            ['Germinal', 1885, 'Roman', '9785566778899', 600, 'roman'],
            ['À la recherche du temps perdu', 1913, 'Roman', '9789988776655', 2000, 'inconnu au bataillon'],

        ];

        foreach ($livresData as $index => $data) {
            $livre = new Livre();
            $livre->setTitre($data[0])
                  ->setAnnee(new \DateTime("{$data[1]}-01-01"))
                  ->setTheme($data[2])
                  ->setIsbn($data[3])
                  ->setNombrePage($data[4])
                  ->setGenre($data[5]);
            $manager->persist($livre);
            $documents[] = $livre;

            // Relation avec un auteur
            $ecrire = new Ecrire();
            $ecrire->setDocument($livre)
                   ->setAuteur($auteurs[$index % count($auteurs)]);
            $manager->persist($ecrire);
        }

        // Vidéos
        $videosData = [
            ['Les Misérables (Film)', 2012, 'Drame', 120, 'Blu-ray', 'Tom Hooper'],
            ['Voyage au centre de la Terre', 2008, 'Aventure', 90, 'DVD', 'Eric Brevig'],
            ['Le Petit Prince', 2015, 'Animation', 108, 'Blu-ray', 'Mark Osborne'],
            ['Germinal (Film)', 1993, 'Drame', 140, 'DVD', 'Claude Berri'],
            ['À la recherche du temps perdu (Série)', 2020, 'Série', 300, 'Blu-ray', 'Cédric Klapisch'],
        ];

        foreach ($videosData as $data) {
            $video = new Video();
            $video->setTitre($data[0])
                  ->setAnnee(new \DateTime("{$data[1]}-01-01"))
                  ->setTheme($data[2])
                  ->setDuree($data[3])
                  ->setFormat($data[4])
                  ->setRealisateur($data[5]);
            $manager->persist($video);
            $documents[] = $video;

            // Relation avec un auteur
            $ecrire = new Ecrire();
            $ecrire->setDocument($video)
                   ->setAuteur($auteurs[array_rand($auteurs)]);
            $manager->persist($ecrire);
        }

        // Titres périodiques
        $periodiquesData = [
            ['Le Monde', 2023, 'Actualités', 123],
            ['Science et Vie', 2023, 'Science', 456],
            ['Télérama', 2023, 'Culture', 789],
            ['L\'Express', 2023, 'Politique', 101],
            ['Paris Match', 2023, 'People', 112],
        ];

        foreach ($periodiquesData as $data) {
            $periodique = new TitrePeriodique();
            $periodique->setTitre($data[0])
                       ->setAnnee(new \DateTime("{$data[1]}-01-01"))
                       ->setTheme($data[2])
                       ->setNumero($data[3])
                       ->setDatePublication(new \DateTime("{$data[1]}-06-01"))
                       ->setFormat('Magazine');
            $manager->persist($periodique);
            $documents[] = $periodique;
            
            // Relation avec un auteur
            $ecrire = new Ecrire();
            $ecrire->setDocument($periodique)
                   ->setAuteur($auteurs[array_rand($auteurs)]);
            $manager->persist($ecrire);
        }



        // Sonores
        $sonoresData = [
            ['Les Fables de La Fontaine', 2000, 'Fables', 60, 'MP3', 'Jean-Pierre Marielle'],
            ['Germinal (Livre audio)', 2005, 'Roman', 120, 'MP3', 'Bernard Giraudeau'],
            ['À la recherche du temps perdu (Livre audio)', 2010, 'Roman', 180, 'MP3', 'André Dussollier'],
            ['Les Misérables (Livre audio)', 2015, 'Roman', 240, 'MP3', 'Richard Berry'],
            ['Vingt mille lieues sous les mers (Livre audio)', 2020, 'Aventure', 300, 'MP3', 'Jean Rochefort'],
        ];
        foreach ($sonoresData as $data) {
            $sonore = new Sonore();
            $sonore->setTitre($data[0])
                   ->setAnnee(new \DateTime("{$data[1]}-01-01"))
                   ->setTheme($data[2])
                   ->setDuree($data[3])
                   ->setFormat($data[4])
                   ->setInterprete($data[5]);
            $manager->persist($sonore);
            $documents[] = $sonore;

            // Relation avec un auteur
            $ecrire = new Ecrire();
            $ecrire->setDocument($sonore)
                   ->setAuteur($auteurs[array_rand($auteurs)]);
            $manager->persist($ecrire);
        }

        // --- Exemplaires
        foreach ($documents as $document) {
            for ($i = 0; $i < 3; $i++) {
                $exemplaire = new Exemplaire();
                $exemplaire->setEtatPhysique('neuf')
                           ->setStatut('disponible')
                           ->setDocument($document);
                $manager->persist($exemplaire);
            }
        }

        // --- Utilisateurs
        $utilisateurs = [];
        $utilisateursData = [
            ['Alice', 'Dupont', 'alice@example.com'],
            ['Bob', 'Martin', 'bob@example.com'],
            ['Charlie', 'Durand', 'charlie@example.com'],
            ['David', 'Leroy', 'davidleroy@example.com'],
            ['Eve', 'Moreau', 'Evemoreau@example.com'],
        ];

        foreach ($utilisateursData as $data) {
            $utilisateur = new Utilisateur();
            $utilisateur->setPrenom($data[0])
                        ->setNom($data[1])
                        ->setMail($data[2])
                        ->setDateNaissance($faker->dateTimeBetween('-50 years', '-18 years'))
                        ->setAdresse1('123 rue Exemple')
                        ->setVille('Montpellier')
                        ->setPays('France')
                        ->setNumeroTelephone('0600000000')
                        ->setSituation($faker->randomElement(['étudiant', 'chomage', 'travailleur']))
                        ->setLienJustificatif($faker->url)
                        ->setRole('ROLE_USER')
                        ->setStatut('null')
                        ->setMotDePasse($this->hasher->hashPassword($utilisateur, 'password123'));
            $manager->persist($utilisateur);
            $utilisateurs[] = $utilisateur;
        }

        // --- Emprunts
        foreach ($utilisateurs as $utilisateur) {
            $emprunt = new Emprunt();
            $emprunt->setDateReservation($faker->dateTimeBetween('-5 months', 'now'))
                    ->setUtilisateur($utilisateur);
            $manager->persist($emprunt);
        
            foreach (array_slice($documents, 0, 2) as $document) {
                // Vérifiez si le document a des exemplaires
                $exemplaire = $document->getExemplaires()->first();
                if ($exemplaire) {
                    $empruntExemplaire = new EmpruntExemplaire();
                    $empruntExemplaire->setEmprunt($emprunt)
                                      ->setExemplaire($exemplaire);
                    $manager->persist($empruntExemplaire);
                } else {
                    // Créez un exemplaire si aucun n'existe
                    $newExemplaire = new Exemplaire();
                    $newExemplaire->setEtatPhysique($faker->randomElement(['neuf', 'bon', 'usé']))
                                  ->setStatut('disponible')
                                  ->setDocument($document);
                    $manager->persist($newExemplaire);
        
                    $empruntExemplaire = new EmpruntExemplaire();
                    $empruntExemplaire->setEmprunt($emprunt)
                                      ->setExemplaire($newExemplaire);
                    $manager->persist($empruntExemplaire);
                }
            }
        }

        // --- Envoi en base
        $manager->flush();
    }
}