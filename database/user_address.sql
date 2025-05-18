-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 18 mai 2025 à 13:47
-- Version du serveur : 8.0.40
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `olivia-dondas_bibine`
--

-- --------------------------------------------------------

--
-- Structure de la table `user_address`
--

CREATE TABLE `user_address` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` enum('billing','shipping') NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `type`, `street`, `city`, `postcode`, `country`, `is_default`) VALUES
(1, 2, 'shipping', '51, RUE GABRIEL AUDISIO - TERRE DE JADE', '', '', 'France', 1),
(2, 3, 'shipping', '51, RUE GABRIEL AUDISIO - TERRE DE JADE, APPARTEMENT 1-5 1ER ETAGE BATIMENT A,', '', '', 'France', 1),
(3, 4, 'shipping', '51, RUE GABRIEL AUDISIO - TERRE DE JADE, APPARTEMENT 1-5 1ER ETAGE BATIMENT A,', '', '', 'France', 1),
(4, 5, 'shipping', '51, RUE GABRIEL AUDISIO - TERRE DE JADE, APPARTEMENT 1-5 1ER ETAGE BATIMENT A,', '', '', 'France', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
