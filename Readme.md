# 📚 La Maison Du Livre (Médiathèque)
# Run App 

## 1. Installation des dépendances 
- PHP &rarr; https://www.php.net/downloads.php (v8.3.11)
- Symfony &rarr; https://symfony.com/download (7.2.4)
- Composer &rarr; https://getcomposer.org/download/ (2.8.6) (si necessaire)
- MySQL &rarr; https://dev.mysql.com/downloads/installer/ (8.0.41) (si necessaire)

## 2. Lancement de l'applicaiton web 

```
cd .\App\LaMaisonDuLivre\
```

```
symfony server:start
```

## Lien de l'application web
```
https://127.0.0.1:8000     
```

#
# Mise a jour de la Base de donnée
```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
##
En cas d'erreur (affiche une liste de problème à résoudre) : 
```
php bin/console doctrine:schema:validate
``` 
##
Entrer dans la console MySQL : 
```
mysql -u root -p
```



php bin/console doctrine:migrations:diff
php bin/console make:migration
php bin/console doctrine:migrations:migrate


composer require symfony/orm-pack
composer require symfony/maker-bundle --dev




utilisation de : 
- fakerphp/faker (v1.24.1)
- Locking doctrine/data-fixtures (2.0.2)
- Locking doctrine/doctrine-fixtures-bundle (4.1.0)


Fixture : generation des données (cela fait egalement une purge, je crois) :  src/DataFixtures/AppFixtures.php
Generer les données : php bin/console doctrine:fixtures:load -n    (-n valide la question)
Supprime toute les données puis les generes : php bin/console doctrine:fixtures:load --purge-with-truncate

re-init
php bin/console doctrine:database:drop --force : tout supprimer
php bin/console doctrine:database:create : recreer
 

installation sur autre PC : 
composer est deja present, donc faire "php composer.phar install" une fois dans App\LaMaisonDuLivre
https://www.wampserver.com/ pour installer wamp puis dire de faire certaine commande pour init la bdd donc create, etc..
puis modifier DATABASE_URL dans .env pour connecter les deux, mdp, user, etc..
aller sur http://localhost/phpmyadmin/ pour voir la BDD









Tailwind CSS pour le design rapide et réactif

FontAwesome pour les icônes

Google Fonts pour une jolie typo (Playfair Display pour les titres et Raleway pour le texte)

Tu as un header, un hero section avec une image d’accueil et un formulaire de recherche intégré, puis une section Quick Links en cartes interactives.








PS C:\Users\hugol\Downloads\EPSI SN2\Projet Solution Applicative\Projet-Solution-Applicative\App\LaMaisonDuLivre> php bin/console make:auth           
       
 !
 ! [CAUTION] "make:auth" is deprecated, use any of the "make:security" commands instead.                                
 !                                                                                                                      

 What style of authentication do you want? [Empty authenticator]:
  [0] Empty authenticator
  [1] Login form authenticator
 > 1

 The class name of the authenticator to create (e.g. AppCustomAuthenticator):
 > LoginFormAuthenticator

 Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
 > SecurityController

 Enter the User class that you want to authenticate (e.g. App\Entity\User) []:
 > App\Entity\Utilisateur

 Which field on your App\Entity\Utilisateur class will people enter when logging in?:
  [0 ] IdUtilisateur
  [1 ] Nom
  [2 ] Prenom
  [3 ] Surnom
  [4 ] DateNaissance
  [5 ] Adresse1
  [6 ] Adresse2
  [7 ] Ville
  [8 ] Pays
  [9 ] Mail
  [10] NumeroTelephone
  [11] Situation
  [12] Role
  [13] LienJustificatif
  [14] Statut
  [15] motdepasse
  [16] abonnement
 > 3

 Do you want to generate a '/logout' URL? (yes/no) [yes]:
 >

 Do you want to support remember me? (yes/no) [yes]:
 > 

 How should remember me be activated? [Activate when the user checks a box]:
  [0] Activate when the user checks a box
  [1] Always activate remember me
 > 

 created: src/Security/LoginFormAuthenticator.php
 updated: config/packages/security.yaml
 created: src/Controller/SecurityController.php
 created: templates/security/login.html.twig

 
  Success! 
 

 Next:
 - Customize your new authenticator.
 - Finish the redirect "TODO" in the App\Security\LoginFormAuthenticator::onAuthenticationSuccess() method.
 - Review & adapt the login template: templates/security/login.html.twig.