-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 18 mai 2025 à 08:59
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
-- Structure de la table `product_image`
--

CREATE TABLE `product_image` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image_url`) VALUES
(1, 215, 'assets/images/products/chateau_montrose_2016.png'),
(2, 216, 'assets/images/products/chateau_lynch_bages_2015.png'),
(3, 218, 'assets/images/products/chateau_palmer_2012.png'),
(4, 230, 'assets/images/products/leflaive_puligny_2018.png'),
(5, 245, 'assets/images/products/esclans_garrus_2021.png'),
(6, 248, 'assets/images/products/miraval_rose_2022.png'),
(7, 261, 'assets/images/products/dom_perignon_2013.png'),
(8, 275, 'assets/images/products/macallan_18_sherry.png'),
(9, 276, 'assets/images/products/hennessy_xo.png'),
(10, 221, 'assets/images/products/sassicaia_2018.png'),
(11, 222, 'assets/images/products/cheval_blanc_2014.png'),
(12, 225, 'assets/images/products/chave_hermitage_2016.png'),
(13, 240, 'assets/images/products/coche_dury_corton_charlemagne_2016.png'),
(14, 241, 'assets/images/products/chateau_yquem_2015.png'),
(15, 250, 'assets/images/products/tempier_bandol_rose_2021.png'),
(16, 260, 'assets/images/products/krug_grande_cuvee_169.png'),
(17, 282, 'assets/images/products/clase_azul_reposado.png'),
(18, 285, 'assets/images/products/louis_xiii_cognac.png'),
(19, 286, 'assets/images/products/johnnie_walker_blue.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
