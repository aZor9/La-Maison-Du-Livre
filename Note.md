Outils : 
- Tailwind CSS pour le design rapide et réactif
- FontAwesome pour les icônes
- Google Fonts pour une jolie typo (Playfair Display pour les titres et Raleway pour le texte)


```
PS C:\Users\hugol\Downloads\EPSI SN2\Projet Solution Applicative\Projet-Solution-Applicative\App\LaMaisonDuLivre> php bin/console make:auth           
       
 ! [CAUTION] "make:auth" is deprecated, use any of the "make:security" commands instead.                                                                                                                                               

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
```



si serveur local deja demarrer alors : `symfony local:server:stop`
si erreur "invalid csrf token" lors du login : supprimer les cookies