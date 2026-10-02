#  API - Gestion des Étudiants (Backend)

Ce dépôt contient l'API backend du projet de gestion des étudiants. 
Elle est développée en PHP et communique avec une base de données MySQL.

## Prérequis

- XAMPP (ou WAMP/MAMP) pour Apache et MySQL
- PHP 8.0 ou supérieur
- MySQL Workbench
- Postman pour tester l'API

##  Installation

1. Cloner le dépôt
2. Placer le dossier dans C:\xampp\htdocs\
3. Créer la base de données (script SQL fourni)
4. Créer le fichier db.php avec vos identifiants
5. Démarrer Apache dans XAMPP

##  Routes de l'API

| Méthode | Action | URL | Description |
|---------|--------|-----|-------------|
| GET | liste_etudiants | ... | Liste tous les étudiants |
| POST | ajout_etudiant | ... | Ajoute un étudiant |
| ... | ... | ... | ... |

##  Technologies utilisées

- PHP 8 (Backend)
- PDO (Connexion sécurisée)
- MySQL (Base de données)
- JSON (Format d'échange)

##  Auteur

- Khady Mbaye - Stagiaire
- Encadreur : Mamour Deme