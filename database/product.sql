-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 19 mai 2025 à 10:25
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
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `category_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `featured` tinyint(1) DEFAULT '0',
  `region_id` int DEFAULT NULL,
  `grape_id` int DEFAULT NULL,
  `color` enum('red','white','rose') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `brand_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `created_at`, `featured`, `region_id`, `grape_id`, `color`, `brand_id`) VALUES
(215, 'Château Montrose 2016', 'Grand cru classé Saint-Estèphe au bouquet complexe', 189.00, 25, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL, NULL),
(216, 'Château Lynch-Bages 2015', 'Pauillac puissant aux arômes de cassis et de cèdre', 125.00, 30, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL, NULL),
(217, 'Domaine de la Janasse Châteauneuf-du-Pape 2018', 'Rhône méridional généreux aux notes d\'épices', 65.00, 40, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL, NULL),
(218, 'Château Palmer 2012', 'Margaux d\'exception à la texture soyeuse', 320.00, 15, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL, NULL),
(219, 'Domaine Armand Rousseau Gevrey-Chambertin 2017', 'Bourgogne élégant aux tanins fondus', 180.00, 20, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL, NULL),
(220, 'Château Rayas Châteauneuf-du-Pape 2016', 'Cult wine du Rhône, rare et intense', 450.00, 8, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL, NULL),
(221, 'Tenuta San Guido Sassicaia 2018', 'Super toscan au bouquet complexe', 220.00, 18, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL, NULL),
(222, 'Château Cheval Blanc 2014', 'Grand cru Saint-Émilion au style inimitable', 390.00, 12, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL, NULL),
(223, 'Domaine du Pegau Châteauneuf-du-Pape 2017', 'Rhône traditionnel aux notes de garrigue', 75.00, 35, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL, NULL),
(224, 'Château Léoville Las Cases 2015', 'Saint-Julien classique et racé', 210.00, 22, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL, NULL),
(225, 'Domaine Jean-Louis Chave Hermitage 2016', 'Syrah du nord Rhône d\'une grande pureté', 230.00, 14, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL, NULL),
(226, 'Château Ausone 2013', 'Saint-Émilion mythique au potentiel exceptionnel', 680.00, 7, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL, NULL),
(227, 'Domaine Leroy Vosne-Romanée 2018', 'Bourgogne de prestige au nez envoûtant', 950.00, 5, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL, NULL),
(228, 'Château Cos d\'Estournel 2017', 'Saint-Estèphe exotique au style unique', 185.00, 20, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL, NULL),
(229, 'Domaine Jamet Côte-Rôtie 2016', 'Syrah du nord Rhône aux arômes floraux', 110.00, 25, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL, NULL),
(230, 'Domaine Leflaive Puligny-Montrachet 2018', 'Bourgogne blanc d\'exception', 250.00, 15, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(231, 'Château Smith Haut Lafitte Blanc 2017', 'Grand cru blanc de Graves', 120.00, 20, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(232, 'Domaine Zind-Humbrecht Riesling Rangen 2016', 'Riesling alsacien de terroir', 65.00, 30, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(233, 'Domaine des Comtes Lafon Meursault 2017', 'Bourgogne blanc onctueux', 180.00, 18, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(234, 'Didier Dagueneau Pouilly-Fumé Pur Sang 2018', 'Sauvignon de Loire mythique', 220.00, 12, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(235, 'Domaine Weinbach Gewurztraminer Altenbourg 2019', 'Gewurztraminer aromatique', 45.00, 40, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(236, 'Château Grillet 2016', 'Viognier rare de la vallée du Rhône', 350.00, 8, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(237, 'Domaine Huet Vouvray Moelleux 2015', 'Chenin doux de Loire', 55.00, 25, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(238, 'Domaine Roulot Meursault 2018', 'Bourgogne blanc précis et minéral', 190.00, 15, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(239, 'Egon Müller Scharzhofberger Riesling Kabinett 2017', 'Riesling allemand d\'exception', 180.00, 20, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(240, 'Domaine Coche-Dury Corton-Charlemagne 2016', 'Grand cru bourguignon légendaire', 1200.00, 5, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(241, 'Château d\'Yquem 2015', 'Sauternes mythique au nectar doré', 380.00, 10, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(242, 'Domaine Tempier Bandol Blanc 2019', 'Blanc de Bandol aux accents méditerranéens', 50.00, 35, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(243, 'Domaine Guffens-Heynen Mâcon-Pierreclos 2018', 'Bourgogne blanc accessible', 35.00, 50, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(244, 'Domaine de Chevalier Blanc 2017', 'Grand cru classé de Graves', 130.00, 22, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(245, 'Château d\'Esclans Garrus 2021', 'Rosé de prestige de Provence', 110.00, 15, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(246, 'Domaines Ott Château de Selle 2022', 'Rosé emblématique de Provence', 45.00, 30, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(247, 'Château Minuty M de Minuty 2022', 'Rosé frais et fruité', 28.00, 50, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(248, 'Miraval Rosé 2022', 'Rosé star de Provence', 32.00, 40, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(249, 'Château Sainte Marguerite Symphonie 2022', 'Rosé complexe de Provence', 25.00, 45, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(250, 'Domaine Tempier Bandol Rosé 2021', 'Rosé de garde de Provence', 42.00, 35, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(251, 'Château de Pibarnon Bandol Rosé 2021', 'Rosé structuré de Bandol', 38.00, 30, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(252, 'Clos Cibonne Tibouren Cuvée Caroline 2021', 'Rosé rare au tibouren', 50.00, 25, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(253, 'Château La Coste Rosé 2022', 'Rosé bio de Provence', 27.00, 40, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(254, 'Domaine de la Bégude Rosé 2022', 'Rosé corse aux notes minérales', 23.00, 50, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(255, 'Château de Roquefort Corail 2022', 'Rosé fruité de Provence', 20.00, 60, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(256, 'Domaine de la Sanglière Rosé 2022', 'Rosé traditionnel de Provence', 18.00, 70, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(257, 'Château Vignelaure Rosé 2021', 'Rosé de terroir de Provence', 35.00, 30, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(258, 'Mas de Cadenet Rosé 2022', 'Rosé frais et gourmand', 22.00, 55, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(259, 'Château des Demoiselles Rosé 2022', 'Rosé élégant de Provence', 26.00, 45, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(260, 'Krug Grande Cuvée 169ème Édition', 'Assemblage complexe et riche', 220.00, 12, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(261, 'Dom Pérignon Vintage 2013', 'Champagne de prestige', 190.00, 15, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(262, 'Bollinger La Grande Année 2014', 'Brut millésimé de caractère', 120.00, 20, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(263, 'Louis Roederer Cristal 2015', 'Champagne iconique', 250.00, 10, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(264, 'Pol Roger Sir Winston Churchill 2013', 'Cuvée prestige puissante', 280.00, 8, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(265, 'Taittinger Comtes de Champagne Blanc de Blancs 2012', 'Chardonnay pur et élégant', 160.00, 15, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(266, 'Veuve Clicquot La Grande Dame 2012', 'Cuvée prestige de la maison', 180.00, 12, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(267, 'Laurent-Perrier Grand Siècle Iteration No. 25', 'Assemblage multi-millésimé', 150.00, 18, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(268, 'Billecart-Salmon Brut Réserve', 'Champagne frais et délicat', 65.00, 30, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(269, 'Ruinart Blanc de Blancs', 'Chardonnay pur et minéral', 75.00, 25, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(270, 'Philipponnat Clos des Goisses 2013', 'Champagne de parcellaire', 210.00, 10, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(271, 'Jacques Selosse Substance', 'Champagne d\'auteur oxydatif', 350.00, 6, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(272, 'Egly-Ouriet Grand Cru Brut', 'Champagne de vigneron puissant', 90.00, 20, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(273, 'Drappier Carte d\'Or Brut', 'Champagne pinot noir dominant', 45.00, 40, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(274, 'Larmandier-Bernier Terre de Vertus', 'Champagne nature et minéral', 70.00, 25, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(275, 'Macallan 18 ans Sherry Oak', 'Single malt écossais riche et épicé', 350.00, 10, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(276, 'Hennessy XO', 'Cognac d\'exception aux arômes complexes', 220.00, 15, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(277, 'Patrón Añejo', 'Tequila vieillie en fût de chêne', 90.00, 20, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(278, 'Grey Goose Vodka', 'Vodka française ultra-premium', 50.00, 30, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(279, 'Havana Club 7 años', 'Rhum cubain vieilli 7 ans', 40.00, 25, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(280, 'Chartreuse VEP Jaune', 'Liqueur monastique vieillie', 120.00, 12, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(281, 'Dalmore King Alexander III', 'Single malt écossais composite', 250.00, 8, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(282, 'Clase Azul Reposado', 'Tequila mexicaine haut de gamme', 150.00, 15, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(283, 'Rhum Agricole Neisson 12 ans', 'Rhum martiniquais d\'exception', 110.00, 18, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(284, 'Bombay Sapphire Premier Cru', 'Gin premium aux botaniques rares', 60.00, 22, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(285, 'Louis XIII Cognac', 'Cognac de luxe légendaire', 3000.00, 3, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(286, 'Johnnie Walker Blue Label', 'Blended Scotch whisky d\'exception', 200.00, 10, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL, NULL),
(287, 'Absolut Elyx', 'Vodka haut de gamme distillée en cuivre', 70.00, 20, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(288, 'Plantation XO 20th Anniversary', 'Rhum vieux multicaraïbes', 55.00, 25, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL),
(289, 'Bulleit Bourbon 10 ans', 'Bourbon américain vieilli', 50.00, 30, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `fk_product_region` (`region_id`),
  ADD KEY `fk_product_grape` (`grape_id`),
  ADD KEY `fk_product_brand` (`brand_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_brand` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_product_grape` FOREIGN KEY (`grape_id`) REFERENCES `grape` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_region` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
