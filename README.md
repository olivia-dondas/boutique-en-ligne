# Bibine - Boutique en ligne de vin

## Description
Bibine est une boutique en ligne spécialisée dans la vente de vin. Le site permet aux utilisateurs de naviguer dans différentes catégories de vins, d'ajouter des produits à leur panier, et de passer des commandes. Le site inclut également une fonctionnalité de notation et de commentaire sur les produits.

## Technologies utilisées
- **PHP** : Langage principal pour le backend.
- **MySQL** : Base de données relationnelle.
- **HTML/CSS/JS** : Technologies utilisées pour le frontend.

## Installation

1. Clonez ce repository sur votre machine :
    ```bash
    git clone https://github.com/ton-repository/bibine.git
    ```
2. Configurez votre base de données MySQL et importez les tables SQL nécessaires.
3. Lancez le serveur PHP localement avec votre outil préféré (comme MAMP ou XAMPP).

## Structure du projet
- `src/` : Contient tous les fichiers PHP du projet.
- `public/` : Contient les fichiers accessibles au public, comme les images et le frontend.
- `database/` : Contient les scripts de création de base de données (MCD, SQL).

## Fonctionnalités
- **Gestion des utilisateurs** : Inscription, connexion, gestion du profil utilisateur.
- **Catalogue de produits** : Navigation par catégories de vin, vue détaillée des produits.
- **Panier et commande** : Ajouter des produits au panier, passer des commandes et suivre l'état des commandes.
- **Avis produits** : Laisser un avis et une note sur chaque produit.

## Base de données
La base de données comporte plusieurs tables, dont :
- **user** : Utilisateur (id, nom, email, mot de passe, rôle).
- **product** : Produits (id, nom, description, prix, stock, catégorie).
- **cart** : Panier d'achat de l'utilisateur.
- **order** : Commande de l'utilisateur.
- **review** : Avis laissé sur les produits.

## Auteurs et contributeurs
- **Olivia**
- **Scott** 
- **Théo** 
