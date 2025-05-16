# 🍷 **Bibine - Boutique en ligne de vin** 🍇

Bienvenue sur **Bibine**, la boutique en ligne où vous pouvez découvrir, acheter et apprécier des vins de qualité ! 🍾🍷  
Naviguez à travers notre sélection de vins, laissez des avis et trouvez vos nouveaux coups de cœur. Cheers ! 🥂

## 🚀 **Qu'est-ce que Bibine ?**
**Bibine** est une plateforme de vente en ligne dédiée aux passionnés de vin. Que vous soyez amateur ou connaisseur, nous vous offrons un large choix de vins classés par catégorie. Ajoutez des produits à votre panier, passez des commandes, et donnez votre avis sur vos vins préférés !

## 🔧 **Technologies utilisées**
- **PHP** : Langage utilisé pour le backend et la gestion des commandes.
- **MySQL** : Base de données pour gérer les utilisateurs, les produits et les commandes.
- **HTML/CSS/JS** : Pour créer une expérience utilisateur fluide et moderne.

## 🛠️ **Comment installer Bibine ?**
1. Clonez ce repository sur votre machine :
    ```bash
    git clone https://github.com/olivia-dondas/boutique-en-ligne.git
    ```
2. Configurez votre base de données MySQL et importez les tables SQL fournies dans le dossier `database/`.
3. Lancez le serveur PHP de votre choix (ex. : MAMP, XAMPP, ou tout autre serveur local).

## 🗂️ **Structure du projet**
Voici l'organisation des fichiers de Bibine :
- `src/` : Contient tous les fichiers PHP pour la logique backend.
- `public/` : Contient les fichiers publics comme les images et le frontend.
- `database/` : Contient les scripts SQL pour la création de la base de données.

## 🛒 **Fonctionnalités principales**
- **Gestion des utilisateurs** : Créez un compte, connectez-vous et gérez votre profil.
- **Catalogue de produits** : Explorez nos vins par catégorie et découvrez de nouveaux produits.
- **Panier et commande** : Ajoutez des produits à votre panier et passez des commandes facilement.
- **Avis produits** : Partagez votre opinion en laissant un avis et une note sur les produits.

## 💾 **Base de données**
La base de données contient plusieurs tables importantes :
- **user** : Informations sur les utilisateurs (id, nom, email, mot de passe, rôle).
- **product** : Détails sur les produits (id, nom, description, prix, stock, catégorie).
- **cart** : Le panier d'achat de chaque utilisateur.
- **order** : Les commandes passées par les utilisateurs.
- **review** : Les avis laissés par les utilisateurs sur les produits.


