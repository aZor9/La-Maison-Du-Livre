<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Utilisateur();
        $admin->setNom('Admin')
              ->setPrenom('Super')
              ->setDateNaissance(new \DateTime('1990-01-01'))
              ->setAdresse1('1 rue de l\'administration')
              ->setAdresse2('')
              ->setVille('AdminCity')
              ->setPays('AdminLand')
              ->setMail('admin@example.com')
              ->setNumeroTelephone('0600000000')
              ->setSituation('employé')
              ->setRole('ROLE_SUPER_ADMIN')
              ->setLienJustificatif('')
              ->setStatut('actif')
              ->setMotDePasse($this->hasher->hashPassword($admin, 'admin123'));

        $manager->persist($admin);
        $manager->flush();
    }
}
