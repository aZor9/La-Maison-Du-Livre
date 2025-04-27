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