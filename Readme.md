# 📚 La Maison Du Livre (Médiathèque)

Projet Symfony représentant une médiathèque avec gestion de documents, utilisateurs, prêts, abonnements, etc.

---

## 🖥️ Lancer le projet

---

### 1. 🔧 Prérequis / Dépendances (versions utilisées)

- 🐘 PHP → [https://www.php.net/downloads.php](https://www.php.net/downloads.php) (v8.3.11)  
- 🎵 Symfony → [https://symfony.com/download](https://symfony.com/download) (7.2.4)  
- 📦 Composer → [https://getcomposer.org/download/](https://getcomposer.org/download/) (2.8.6) *(si nécessaire)*  
- 🐬 MySQL → [https://dev.mysql.com/downloads/installer/](https://dev.mysql.com/downloads/installer/) (8.0.41) *(si nécessaire)*  
- 🧪 WampServer → [https://www.wampserver.com/](https://www.wampserver.com/)  
- 🎨 Tailwind CSS → utilisé pour un design rapide et réactif  

---

## 🚀 Installation & exécution

---

### ✅ 1. Cloner le projet

Pour cela, ouvrez un terminal et placez-vous dans le dossier où vous souhaitez stocker le projet :

```bash
cd chemin/vers/dossier
```

Puis, clonez le dépôt :

```bash
git clone https://github.com/aZor9/La-Maison-Du-Livre.git
```

Vous avez désormais tout le code sur votre machine.

---

### ✅ 2. Accéder au dossier du projet

```bash
cd La-Maison-Du-Livre
```

---

### ✅ 3. Installer les dépendances PHP

Si Composer **n’est pas installé** :

```bash
php composer.phar install
```

Sinon :

```bash
composer install
```

---

### ✅ 4. Configurer la base de données

Dans le fichier `.env`, modifiez cette ligne si besoin :

```
DATABASE_URL="mysql://root:password@127.0.0.1:3306/lamaisondulivre?serverVersion=8.0"
```

⚠️ Remplacez `root` (utilisateur) et `password` (mot de passe) si votre configuration locale est différente.

---

### ✅ 5. Lancer WAMP

Lancer **WAMP Server** et attendez que l’icône devienne verte dans la barre des tâches.

---

### ✅ 6. Créer et préparer la base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

(Répondre `yes` si une confirmation est demandée)

---

### ✅ 7. (Optionnel) Charger des données de test

```bash
php bin/console doctrine:fixtures:load -n
```

---

### ✅ 8. Lancer le serveur Symfony

```bash
symfony server:start
```

➡️ Rendez-vous sur :  
```
https://127.0.0.1:8000
```

---

### ✅ 9. Visualiser la base de données

Depuis un navigateur :

[http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)

Vous devriez voir une base `lamaisondulivre` avec toutes les tables créées.

---

## 🛠️ Commandes utiles

---

### 🔁 Réinitialisation complète de la base de données

```bash
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load -n
```

---

### 📦 Doctrine & Migrations

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:validate
```

---

### 🧪 Fixtures (données de test)

- Fichier : `src/DataFixtures/AppFixtures.php`  
- Utilise :
  - `fakerphp/faker` (v1.24.1)
  - `doctrine/data-fixtures` (2.0.2)
  - `doctrine/doctrine-fixtures-bundle` (4.1.0)

#### Générer les données sans confirmation :

```bash
php bin/console doctrine:fixtures:load -n
```

#### Supprimer les anciennes données avant injection :

```bash
php bin/console doctrine:fixtures:load --purge-with-truncate
```

---

### 🔧 Autres commandes pratiques

- Arrêter le serveur Symfony (si déjà en cours d'exécution) :

```bash
symfony local:server:stop
```

- Connexion MySQL via terminal :

```bash
mysql -u root -p
```

---

## ⚠️ Astuces & Dépannage

---

- 💥 **Erreur "invalid CSRF token" lors du login ?**  
  Supprimez les cookies du navigateur concernés puis réessayez.

- 🔁 **Impossible de démarrer Symfony car un serveur est déjà actif ?**  
  Utilisez :  
  ```bash
  symfony local:server:stop
  ```