# Run App 

## Installation de Symfony 
- PHP &rarr; https://www.php.net/downloads.php (v8.3.11)
- Symfony &rarr; https://symfony.com/download (7.2.4)
- Composer &rarr; https://getcomposer.org/download/ (2.8.6) (si necessaire)
- MySQL &rarr; https://dev.mysql.com/downloads/installer/ (8.0.41) (si necessaire)

## Lancement de l'applicaiton web 

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