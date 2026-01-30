# Plateforme de Gestion des Résultats Académiques

Ce projet est une plateforme web de gestion des résultats académiques.  
Il est composé de deux parties distinctes :

- Un Back-End développé avec Laravel (API REST)
- Un Front-End développé avec Vue.js (interface utilisateur)

Le Back-End fournit uniquement les données via une API.  
Le Front-End consomme cette API et constitue la seule interface accessible par l’utilisateur.

---

## Architecture du projet

Le projet est organisé en plusieurs parties :

- Back-End (Laravel)
    - Gestion de la base de données
    - API REST (CRUD des filières, diplômes, étudiants, années)
- Front-End Administration (Vue.js)
    - Interface de gestion (administration)
- Front-End Résultats (Vue.js)
    - Interface de consultation des résultats

---

## Modélisation des données

Les principales entités sont :

- Filière  
  Représente un domaine ou une spécialité de formation.

- Diplôme  
  Appartient à une filière et regroupe les étudiants.

- Étudiant  
  Est associé à un diplôme et à une année.

- Année  
  Représente l’année académique.

Relations :

- Une filière possède plusieurs diplômes
- Un diplôme appartient à une filière
- Un étudiant est rattaché à un diplôme
- Un étudiant est associé à une année académique

---

## Prérequis

Avant de lancer le projet, il faut disposer de :

- PHP >= 8.1
- Composer
- Node.js et npm
- MySQL ou SQLite
- Git

---

## Installation du projet

### 1. Cloner le dépôt

```bash
git clone https://github.com/ker92/plateforme.git
cd plateforme
