-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 12 mai 2025 à 09:53
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
-- Structure de la table `brand`
--

CREATE TABLE `brand` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Château Margaux'),
(2, 'Domaine de la Romanée-Conti'),
(3, 'Moët & Chandon'),
(4, 'Dom Pérignon'),
(5, 'Veuve Clicquot'),
(6, 'Hennessy'),
(7, 'Jack Daniel\'s'),
(8, 'Absolut'),
(9, 'Château Lafite Rothschild'),
(10, 'Château Latour'),
(11, 'Domaine Leflaive'),
(12, 'Cloudy Bay'),
(13, 'Château d\'Esclans'),
(14, 'Minuty'),
(15, 'Domaines Ott'),
(16, 'Bollinger'),
(17, 'Krug'),
(18, 'Johnnie Walker'),
(19, 'Grey Goose'),
(20, 'Patrón'),
(21, 'Ruinart'),
(22, 'Laurent-Perrier'),
(23, 'E. Guigal'),
(24, 'Gérard Bertrand'),
(25, 'Domaine Tempier');

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int NOT NULL,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Vin rouge'),
(2, 'Vin blanc'),
(3, 'Rosé'),
(4, 'Champagne'),
(5, 'Spiritueux');

-- --------------------------------------------------------

--
-- Structure de la table `grape`
--

CREATE TABLE `grape` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `grape`
--

INSERT INTO `grape` (`id`, `name`, `description`) VALUES
(1, 'Merlot', NULL),
(2, 'Cabernet Sauvignon', NULL),
(3, 'Cabernet Franc', NULL),
(4, 'Pinot Noir', NULL),
(5, 'Chardonnay', NULL),
(6, 'Sauvignon Blanc', NULL),
(7, 'Riesling', NULL),
(8, 'Syrah/Shiraz', NULL),
(9, 'Grenache', NULL),
(10, 'Mourvèdre', NULL),
(11, 'Nebbiolo', NULL),
(12, 'Sangiovese', NULL),
(13, 'Tempranillo', NULL),
(14, 'Albariño', NULL),
(15, 'Macabeo', NULL),
(16, 'Viognier', NULL),
(17, 'Chenin Blanc', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','paid','shipped','completed','cancelled') COLLATE utf8mb4_general_ci DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_item`
--

CREATE TABLE `order_item` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `category_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `featured` tinyint(1) DEFAULT '0',
  `region_id` int DEFAULT NULL,
  `grape_id` int DEFAULT NULL,
  `color` enum('red','white','rose') COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `created_at`, `featured`, `region_id`, `grape_id`, `color`) VALUES
(215, 'Château Montrose 2016', 'Grand cru classé Saint-Estèphe au bouquet complexe', 189.00, 25, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL),
(216, 'Château Lynch-Bages 2015', 'Pauillac puissant aux arômes de cassis et de cèdre', 125.00, 30, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL),
(217, 'Domaine de la Janasse Châteauneuf-du-Pape 2018', 'Rhône méridional généreux aux notes d\'épices', 65.00, 40, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL),
(218, 'Château Palmer 2012', 'Margaux d\'exception à la texture soyeuse', 320.00, 15, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL),
(219, 'Domaine Armand Rousseau Gevrey-Chambertin 2017', 'Bourgogne élégant aux tanins fondus', 180.00, 20, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL),
(220, 'Château Rayas Châteauneuf-du-Pape 2016', 'Cult wine du Rhône, rare et intense', 450.00, 8, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL),
(221, 'Tenuta San Guido Sassicaia 2018', 'Super toscan au bouquet complexe', 220.00, 18, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL),
(222, 'Château Cheval Blanc 2014', 'Grand cru Saint-Émilion au style inimitable', 390.00, 12, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL),
(223, 'Domaine du Pegau Châteauneuf-du-Pape 2017', 'Rhône traditionnel aux notes de garrigue', 75.00, 35, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL),
(224, 'Château Léoville Las Cases 2015', 'Saint-Julien classique et racé', 210.00, 22, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL),
(225, 'Domaine Jean-Louis Chave Hermitage 2016', 'Syrah du nord Rhône d\'une grande pureté', 230.00, 14, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL),
(226, 'Château Ausone 2013', 'Saint-Émilion mythique au potentiel exceptionnel', 680.00, 7, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL),
(227, 'Domaine Leroy Vosne-Romanée 2018', 'Bourgogne de prestige au nez envoûtant', 950.00, 5, 1, '2025-05-12 00:43:02', 1, NULL, NULL, NULL),
(228, 'Château Cos d\'Estournel 2017', 'Saint-Estèphe exotique au style unique', 185.00, 20, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL),
(229, 'Domaine Jamet Côte-Rôtie 2016', 'Syrah du nord Rhône aux arômes floraux', 110.00, 25, 1, '2025-05-12 00:43:02', 0, NULL, NULL, NULL),
(230, 'Domaine Leflaive Puligny-Montrachet 2018', 'Bourgogne blanc d\'exception', 250.00, 15, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(231, 'Château Smith Haut Lafitte Blanc 2017', 'Grand cru blanc de Graves', 120.00, 20, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(232, 'Domaine Zind-Humbrecht Riesling Rangen 2016', 'Riesling alsacien de terroir', 65.00, 30, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(233, 'Domaine des Comtes Lafon Meursault 2017', 'Bourgogne blanc onctueux', 180.00, 18, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(234, 'Didier Dagueneau Pouilly-Fumé Pur Sang 2018', 'Sauvignon de Loire mythique', 220.00, 12, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(235, 'Domaine Weinbach Gewurztraminer Altenbourg 2019', 'Gewurztraminer aromatique', 45.00, 40, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(236, 'Château Grillet 2016', 'Viognier rare de la vallée du Rhône', 350.00, 8, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(237, 'Domaine Huet Vouvray Moelleux 2015', 'Chenin doux de Loire', 55.00, 25, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(238, 'Domaine Roulot Meursault 2018', 'Bourgogne blanc précis et minéral', 190.00, 15, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(239, 'Egon Müller Scharzhofberger Riesling Kabinett 2017', 'Riesling allemand d\'exception', 180.00, 20, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(240, 'Domaine Coche-Dury Corton-Charlemagne 2016', 'Grand cru bourguignon légendaire', 1200.00, 5, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(241, 'Château d\'Yquem 2015', 'Sauternes mythique au nectar doré', 380.00, 10, 2, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(242, 'Domaine Tempier Bandol Blanc 2019', 'Blanc de Bandol aux accents méditerranéens', 50.00, 35, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(243, 'Domaine Guffens-Heynen Mâcon-Pierreclos 2018', 'Bourgogne blanc accessible', 35.00, 50, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(244, 'Domaine de Chevalier Blanc 2017', 'Grand cru classé de Graves', 130.00, 22, 2, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(245, 'Château d\'Esclans Garrus 2021', 'Rosé de prestige de Provence', 110.00, 15, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(246, 'Domaines Ott Château de Selle 2022', 'Rosé emblématique de Provence', 45.00, 30, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(247, 'Château Minuty M de Minuty 2022', 'Rosé frais et fruité', 28.00, 50, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(248, 'Miraval Rosé 2022', 'Rosé star de Provence', 32.00, 40, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(249, 'Château Sainte Marguerite Symphonie 2022', 'Rosé complexe de Provence', 25.00, 45, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(250, 'Domaine Tempier Bandol Rosé 2021', 'Rosé de garde de Provence', 42.00, 35, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(251, 'Château de Pibarnon Bandol Rosé 2021', 'Rosé structuré de Bandol', 38.00, 30, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(252, 'Clos Cibonne Tibouren Cuvée Caroline 2021', 'Rosé rare au tibouren', 50.00, 25, 3, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(253, 'Château La Coste Rosé 2022', 'Rosé bio de Provence', 27.00, 40, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(254, 'Domaine de la Bégude Rosé 2022', 'Rosé corse aux notes minérales', 23.00, 50, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(255, 'Château de Roquefort Corail 2022', 'Rosé fruité de Provence', 20.00, 60, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(256, 'Domaine de la Sanglière Rosé 2022', 'Rosé traditionnel de Provence', 18.00, 70, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(257, 'Château Vignelaure Rosé 2021', 'Rosé de terroir de Provence', 35.00, 30, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(258, 'Mas de Cadenet Rosé 2022', 'Rosé frais et gourmand', 22.00, 55, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(259, 'Château des Demoiselles Rosé 2022', 'Rosé élégant de Provence', 26.00, 45, 3, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(260, 'Krug Grande Cuvée 169ème Édition', 'Assemblage complexe et riche', 220.00, 12, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(261, 'Dom Pérignon Vintage 2013', 'Champagne de prestige', 190.00, 15, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(262, 'Bollinger La Grande Année 2014', 'Brut millésimé de caractère', 120.00, 20, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(263, 'Louis Roederer Cristal 2015', 'Champagne iconique', 250.00, 10, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(264, 'Pol Roger Sir Winston Churchill 2013', 'Cuvée prestige puissante', 280.00, 8, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(265, 'Taittinger Comtes de Champagne Blanc de Blancs 2012', 'Chardonnay pur et élégant', 160.00, 15, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(266, 'Veuve Clicquot La Grande Dame 2012', 'Cuvée prestige de la maison', 180.00, 12, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(267, 'Laurent-Perrier Grand Siècle Iteration No. 25', 'Assemblage multi-millésimé', 150.00, 18, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(268, 'Billecart-Salmon Brut Réserve', 'Champagne frais et délicat', 65.00, 30, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(269, 'Ruinart Blanc de Blancs', 'Chardonnay pur et minéral', 75.00, 25, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(270, 'Philipponnat Clos des Goisses 2013', 'Champagne de parcellaire', 210.00, 10, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(271, 'Jacques Selosse Substance', 'Champagne d\'auteur oxydatif', 350.00, 6, 4, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(272, 'Egly-Ouriet Grand Cru Brut', 'Champagne de vigneron puissant', 90.00, 20, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(273, 'Drappier Carte d\'Or Brut', 'Champagne pinot noir dominant', 45.00, 40, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(274, 'Larmandier-Bernier Terre de Vertus', 'Champagne nature et minéral', 70.00, 25, 4, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(275, 'Macallan 18 ans Sherry Oak', 'Single malt écossais riche et épicé', 350.00, 10, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(276, 'Hennessy XO', 'Cognac d\'exception aux arômes complexes', 220.00, 15, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(277, 'Patrón Añejo', 'Tequila vieillie en fût de chêne', 90.00, 20, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(278, 'Grey Goose Vodka', 'Vodka française ultra-premium', 50.00, 30, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(279, 'Havana Club 7 años', 'Rhum cubain vieilli 7 ans', 40.00, 25, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(280, 'Chartreuse VEP Jaune', 'Liqueur monastique vieillie', 120.00, 12, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(281, 'Dalmore King Alexander III', 'Single malt écossais composite', 250.00, 8, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(282, 'Clase Azul Reposado', 'Tequila mexicaine haut de gamme', 150.00, 15, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(283, 'Rhum Agricole Neisson 12 ans', 'Rhum martiniquais d\'exception', 110.00, 18, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(284, 'Bombay Sapphire Premier Cru', 'Gin premium aux botaniques rares', 60.00, 22, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(285, 'Louis XIII Cognac', 'Cognac de luxe légendaire', 3000.00, 3, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(286, 'Johnnie Walker Blue Label', 'Blended Scotch whisky d\'exception', 200.00, 10, 5, '2025-05-12 00:43:03', 1, NULL, NULL, NULL),
(287, 'Absolut Elyx', 'Vodka haut de gamme distillée en cuivre', 70.00, 20, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(288, 'Plantation XO 20th Anniversary', 'Rhum vieux multicaraïbes', 55.00, 25, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL),
(289, 'Bulleit Bourbon 10 ans', 'Bourbon américain vieilli', 50.00, 30, 5, '2025-05-12 00:43:03', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `product_image`
--

CREATE TABLE `product_image` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'France',
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id`, `name`, `country`, `description`) VALUES
(1, 'Bordeaux', 'France', NULL),
(2, 'Bourgogne', 'France', NULL),
(3, 'Vallée de la Loire', 'France', NULL),
(4, 'Rhône', 'France', NULL),
(5, 'Champagne', 'France', NULL),
(6, 'Alsace', 'France', NULL),
(7, 'Provence', 'France', NULL),
(8, 'Languedoc-Roussillon', 'France', NULL),
(9, 'Piémont', 'France', NULL),
(10, 'Toscane', 'France', NULL),
(11, 'Napa Valley', 'France', NULL),
(12, 'Marlborough', 'France', NULL),
(13, 'Rioja', 'France', NULL),
(14, 'Galice', 'France', NULL),
(15, 'Catalogne', 'France', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

CREATE TABLE `review` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `rating` int NOT NULL,
  `review_date` datetime DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Structure de la table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `subcategory`
--

INSERT INTO `subcategory` (`id`, `name`, `category_id`) VALUES
(1, 'Bordeaux', 1),
(2, 'Bourgogne', 1),
(3, 'Côtes du Rhône', 1),
(4, 'Cabernet Sauvignon', 1),
(5, 'Merlot', 1),
(6, 'Chardonnay', 2),
(7, 'Sauvignon Blanc', 2),
(8, 'Riesling', 2),
(9, 'Chablis', 2),
(10, 'Sancerre', 2),
(11, 'Provence', 3),
(12, 'Côtes de Provence', 3),
(13, 'Tavel', 3),
(14, 'Bandol', 3),
(15, 'Rosé de Loire', 3),
(16, 'Brut', 4),
(17, 'Rosé Champagne', 4),
(18, 'Millésimé', 4),
(19, 'Blanc de Blancs', 4),
(20, 'Blanc de Noirs', 4),
(21, 'Whisky', 5),
(22, 'Rhum', 5),
(23, 'Vodka', 5),
(24, 'Cognac', 5),
(25, 'Tequila', 5);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `birth_date` date NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'client' COMMENT 'client, admin, etc.',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `last_name`, `first_name`, `email`, `password`, `birth_date`, `role`, `created_at`) VALUES
(1, 'Escobar', 'Pablo', 'escobar.pablo@gmail.com', '$2y$10$5S6l6jarLQenNDK.efmK..ga2vi308OqE8VswkugDyfzW3aGhHKMe', '1999-12-12', 'client', '2025-04-29 08:27:11'),
(2, 'Dondas', 'Olivia', 'olivia.dondas@gmail.com', '$2y$10$eN1AmOWYGg9HBebn/NW0DuqH28iePhCQiT2RktuHXCCr2BKHYCXCm', '1989-08-29', 'user', '2025-05-09 13:45:17'),
(3, 'Enirevec', 'Eliane', 'eliane.enirevec@gmail.com', '$2y$10$buQBOCb/pCKMzBoy3Y4RyOasaLESkoc16phCUcjNEAaeTyT7ktDIq', '1991-01-09', 'user', '2025-05-09 14:04:47');

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
-- Index pour la table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `grape`
--
ALTER TABLE `grape`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `fk_product_region` (`region_id`),
  ADD KEY `fk_product_grape` (`grape_id`);

--
-- Index pour la table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT pour la table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `grape`
--
ALTER TABLE `grape`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- AUTO_INCREMENT pour la table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_grape` FOREIGN KEY (`grape_id`) REFERENCES `grape` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_region` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
