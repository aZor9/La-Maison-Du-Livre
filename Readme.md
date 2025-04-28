# 📚 La Maison Du Livre (Médiathèque)

# 🖥️ Lancer le projet

---

### 1. 🔧 Prérequis / Dépendances (versions utilisées)

- PHP → [https://www.php.net/downloads.php](https://www.php.net/downloads.php) (v8.3.11)  
- Symfony → [https://symfony.com/download](https://symfony.com/download) (7.2.4)  
- Composer → [https://getcomposer.org/download/](https://getcomposer.org/download/) (2.8.6) *(si nécessaire)*  
- MySQL → [https://dev.mysql.com/downloads/installer/](https://dev.mysql.com/downloads/installer/) (8.0.41) *(si nécessaire)*  
- WampServer → [https://www.wampserver.com/](https://www.wampserver.com/)  

---

## 🚀 Installation & exécution :

---

### ✅ 1. Cloner le projet et se placer dans le dossier

```bash
cd App\LaMaisonDuLivre
```

---

### ✅ 2. Installer les dépendances PHP

- Si Composer **n’est pas installé** :

```bash
php composer.phar install
```

- Sinon, simplement :

```bash
composer install
```

---

### ✅ 3. Configurer la base de données

- Modifier le fichier `.env` à la racine du projet :  

```
DATABASE_URL="mysql://root:@127.0.0.1:3306/lamaisondulivre?serverVersion=8.0"
```

⚠️ Adapter selon ton mot de passe / utilisateur si besoin.
`lamaisondulivre` correpond au nom de la base de donnée.

---

### ✅ 4. Lancer WAMP

**Lancer WAMP** (icône verte dans la barre des tâches)

---

### ✅ 5. Créer & préparer la base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

(Répondre `yes` si une confirmation est demandée)

---

### ✅ 6. (Optionnel) Charger des données de test

```bash
php bin/console doctrine:fixtures:load -n
```

---

### ✅ 7. Lancer le serveur Symfony

```bash
symfony server:start
```

➡️ Accéder à l’application :  
```
https://127.0.0.1:8000
```

---

### ✅ 8. Visualiser la base de données

🔗 Dans ton navigateur :  
[http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)

Tu devrais voir une base nommée `lamaisondulivre` avec toutes les tables.

---

## 🛠️ Commandes utiles :

---

### 🔁 Réinitialiser totalement la base de données

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
`php bin/console make:migration` ou `php bin/console doctrine:migrations:diff`

---

### 🧪 Fixtures (données de test)

- **Fichier de génération** : `src/DataFixtures/AppFixtures.php`  
- Utilise :
  - `fakerphp/faker` (v1.24.1)
  - `doctrine/data-fixtures` (2.0.2)
  - `doctrine/doctrine-fixtures-bundle` (4.1.0)

### 🔧 Arret du serveur Symfony
si serveur local est déjà demarré : 
```
symfony local:server:stop
```

#### Générer les données sans confirmation (purge implicite) :

```bash
php bin/console doctrine:fixtures:load -n
```

#### Supprimer les anciennes données avant d’en injecter de nouvelles :

```bash
php bin/console doctrine:fixtures:load --purge-with-truncate
```



---

### 🐬 Connexion à MySQL via terminal

```bash
mysql -u root -p
```