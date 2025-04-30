## 📌 Fonctionnalités à ajouter sur le site

### A finir : 
- Page 404 (page d'erreur)
- Ajout de document (a finir)
- Ajout de DateRendu (a finir)

### A faire (urgent) : 
- Test unitaire
- En cas de retard de rendu → envoi d’un mail ou message.
- Si l’abonnement arrive à échéance → envoi d’un mail ou message.
- Limite de 10 réservations simultanées par utilisateur.

### A faire (important) :
- Ajouter une date limite de retrait : passé ce délai, le livre est remis en rayon.
- Calcul des statistiques de retard.
- Système de pré-réservation ou liste d’attente pour un document déjà réservé.
- Si l’utilisateur se désabonne ou ne renouvelle pas → obligation de rendre les livres avant la fin de l’abonnement.
- Espace d’accueil spécifique pour le bureau des abonnés (ROLE_ADMIN).
- Ajout d’un filtre par thématique pour faciliter la recherche.
- Statut “approuvé” ou “refusé” pour les réductions ou certains profils client (optionnel si géré sur place).

---

## 📊 Données

### Diagramme associé :  
[Diagramme draw.io](https://app.diagrams.net/#G19sp4BRxlejqzP7HGdCD9-VZUDEMZeu-X#%7B%22pageId%22%3A%22929967ad-93f9-6ef4-fab6-5d389245f69c%22%7D)


### Matrice des données (en tableau) :

| Table             | Colonnes principales                                                         | Relations                                   |
|-------------------|------------------------------------------------------------------------------|---------------------------------------------|
| utilisateur       | id, nom, prenom, email, password, type                                       | Employe, Client (héritage via type)         |
| employe           | id, poste, date_embauche, utilisateur_id                                     | FK vers utilisateur.id                      |
| client            | id, adresse, telephone, utilisateur_id                                       | FK vers utilisateur.id                      |
| document          | id, titre, date_publication, genre, disponible, type                         | Livre, Sonore, Video, TitrePeriodique       |
| livre             | id, nb_pages, isbn, document_id                                              | FK vers document.id                         |
| sonore            | id, duree, format, document_id                                               | FK vers document.id                         |
| video             | id, duree, resolution, document_id                                           | FK vers document.id                         |
| titre_periodique  | id, frequence, issn, document_id                                             | FK vers document.id                         |
| auteur            | id, nom, prenom                                                              | Liaison via ecrire                          |
| ecrire            | id, auteur_id, document_id                                                   | FK vers auteur.id, document.id              |
| article           | id, numero, titre_article, titre_periodique_id                               | FK vers titre_periodique.id                 |
| abonnement        | id, date_debut, date_fin, client_id, titre_periodique_id                     | FK vers client.id, titre_periodique.id      |
| emprunt           | id, date_emprunt, date_retour_prevue, date_retour_reelle, utilisateur_id     | FK vers utilisateur.id                      |
| emprunt_article   | id, emprunt_id, article_id                                                   | FK vers emprunt.id, article.id              |




### Diagramme de Classes :


```mermaid
classDiagram
    class Utilisateur {
        +int : id
        +string : nom
        +string : prenom
        +Date : dateNaissance
        +string : email
        +string : motDePasse
        +string : adresse1
        +string : adresse2
        +string : pays
        +string : numeroTelephone
        +string : situation
        +string : role
        +string : lienJustificatif
        +string : statut
        +inscription()
        +connexion()
        +modifierProfil()
		+findByEmail()
		+getUsername()
    }

    class Abonnement {
        +int : id
        +string : statut
        +Date : dateDebut
        +Date : dateFin
        +float : tarif
		+isNearExpiration()
		+isExpired()
    }

    class Document {
        +int : id
        +string : titre
        +string : auteur
        +string : theme
        +string : description
        +reservation()
		+findBySearch()
    }

    class Livre {
        +string : isbn
        +int : nombrePages
        +string : genre
    }

    class Auteur {
        +int : id
        +string : prenom
        +string : nom
        +string : description
		+findBySearch()
		+addEcriture()
		+removeEcriture()
    }


    class TitrePeriodique {
        +int : numero
        +Date : datePublication
        +string : format
    }

    class Sonore {
        +int : duree
        +string : format
        +string : interprete
    }

    class Video {
        +int : duree
        +string : format
        +string : realisateur
    }

	    class Emprunt {
        +int : id
        +Date : dateReservation
        +Date : dateRendu
		+addEmpruntexemplaire()
		+removeEmpruntexemplaire()
    }

    class Exemplaire {
        +int : id
        +string : etatPhysique
        +string : statut
        +changerEtatPhysique()
        +changerStatut()
    }

    Utilisateur *-- Abonnement
    Utilisateur --* Emprunt 
    Document --* Exemplaire
    Document -- Auteur : ecrire
    Document <|-- TitrePeriodique
    Document <|-- Sonore
    Document <|-- Video
    Document <|-- Livre
    Emprunt -- Exemplaire : EmpruntExemplaire

```

##### Légende : 
- `la flèche noire` : à une clé primaire de ..
- `la flèche blanche` :  à comme heritage ..
- `texte` sur une ligne : nom d'une table d'association 
- chaque attribut à un `getter` et un `setter`