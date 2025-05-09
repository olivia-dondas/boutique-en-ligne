-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 08 mai 2025 à 23:06
-- Version du serveur : 5.5.68-MariaDB
-- Version de PHP : 7.4.30

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
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(20, 'Patrón');

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','paid','shipped','completed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subcategory_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `created_at`, `subcategory_id`, `brand_id`) VALUES
(1, 'Château Margaux 2018', 'Grand vin de Bordeaux, élégant et complexe avec des notes de fruits noirs et d\'épices.', '589.99', 50, 1, '2025-05-02 10:00:00', 1, 1),
(2, 'Château Lafite Rothschild 2015', 'Vin prestigieux de Pauillac, intense et raffiné avec une grande capacité de garde.', '699.99', 45, 1, '2025-05-02 10:00:00', 1, 9),
(3, 'Château Latour 2016', 'Grand cru classé de Pauillac, puissant et structuré avec des tanins soyeux.', '649.99', 40, 1, '2025-05-02 10:00:00', 1, 10),
(4, 'Romanée-Conti 2017', 'L\'un des vins les plus prestigieux au monde, d\'une finesse et d\'une complexité incomparables.', '12500.00', 10, 1, '2025-05-02 10:00:00', 2, 2),
(5, 'Côte de Nuits 2019', 'Un grand bourgogne aux arômes de fruits rouges et d\'épices douces.', '189.99', 60, 1, '2025-05-02 10:00:00', 2, 2),
(6, 'Châteauneuf-du-Pape 2020', 'Vin puissant et chaleureux du sud de la vallée du Rhône.', '59.99', 80, 1, '2025-05-02 10:00:00', 3, NULL),
(7, 'Hermitage 2019', 'Grand vin de la vallée du Rhône, profond et complexe.', '79.99', 55, 1, '2025-05-02 10:00:00', 3, NULL),
(8, 'Côte-Rôtie 2018', 'Vin élégant et raffiné avec des notes de violette et d\'olive noire.', '89.99', 50, 1, '2025-05-02 10:00:00', 3, NULL),
(9, 'Silver Oak Cabernet Sauvignon 2018', 'Cabernet californien riche et velouté aux notes de cassis et de vanille.', '129.99', 70, 1, '2025-05-02 10:00:00', 4, NULL),
(10, 'Opus One 2019', 'Grand vin de Napa Valley, alliance parfaite de puissance et d\'élégance.', '349.99', 35, 1, '2025-05-02 10:00:00', 4, NULL),
(11, 'Caymus Special Selection 2017', 'Cabernet Sauvignon opulent et intense de la Napa Valley.', '199.99', 45, 1, '2025-05-02 10:00:00', 4, NULL),
(12, 'Petrus 2015', 'L\'un des Merlots les plus prestigieux au monde, d\'une profondeur et d\'une complexité exceptionnelles.', '3500.00', 8, 1, '2025-05-02 10:00:00', 5, NULL),
(13, 'Masseto 2018', 'Grand Merlot italien, dense et séducteur.', '699.99', 20, 1, '2025-05-02 10:00:00', 5, NULL),
(14, 'Château Pétrus 2016', 'Merlot d\'exception, riche et soyeux avec un potentiel de garde exceptionnel.', '3900.00', 5, 1, '2025-05-02 10:00:00', 5, NULL),
(15, 'Vieux Château Certan 2017', 'Grand vin de Pomerol dominé par le Merlot, élégant et profond.', '249.99', 30, 1, '2025-05-02 10:00:00', 5, NULL),
(16, 'Château Palmer 2018', 'Troisième grand cru classé de Margaux, soyeux et complexe.', '389.99', 40, 1, '2025-05-02 10:00:00', 1, NULL),
(17, 'Château Mouton Rothschild 2016', 'Premier grand cru classé de Pauillac, puissant et aristocratique.', '799.99', 25, 1, '2025-05-02 10:00:00', 1, NULL),
(18, 'Château Haut-Brion 2017', 'Premier grand cru classé, alliant puissance et finesse.', '599.99', 30, 1, '2025-05-02 10:00:00', 1, NULL),
(19, 'Chambertin Grand Cru 2019', 'Grand vin de Bourgogne, à la fois puissant et d\'une grande finesse.', '499.99', 25, 1, '2025-05-02 10:00:00', 2, NULL),
(20, 'Richebourg Grand Cru 2018', 'Un grand bourgogne d\'une richesse aromatique exceptionnelle.', '899.99', 15, 1, '2025-05-02 10:00:00', 2, NULL),
(21, 'Montrachet Grand Cru 2019', 'L\'un des plus grands vins blancs du monde, d\'une richesse et d\'une complexité incomparables.', '799.99', 20, 2, '2025-05-02 10:00:00', 6, 11),
(22, 'Corton-Charlemagne 2018', 'Grand cru de Bourgogne, puissant et minéral avec un grand potentiel de garde.', '299.99', 35, 2, '2025-05-02 10:00:00', 6, NULL),
(23, 'Meursault Premier Cru 2020', 'Vin blanc de Bourgogne, onctueux et complexe avec des notes beurrées et de noisette.', '129.99', 50, 2, '2025-05-02 10:00:00', 6, NULL),
(24, 'Puligny-Montrachet 2019', 'Grand vin blanc de Bourgogne, élégant et précis.', '159.99', 45, 2, '2025-05-02 10:00:00', 6, 11),
(25, 'Chassagne-Montrachet 2020', 'Vin blanc de Bourgogne, riche et complexe avec une belle minéralité.', '139.99', 40, 2, '2025-05-02 10:00:00', 6, NULL),
(26, 'Cloudy Bay Sauvignon Blanc 2022', 'Sauvignon Blanc néo-zélandais emblématique, expressif et vibrant.', '39.99', 100, 2, '2025-05-02 10:00:00', 7, 12),
(27, 'Sancerre Domaine Vacheron 2021', 'Sauvignon Blanc de la Loire, minéral et précis aux notes d\'agrumes.', '35.99', 85, 2, '2025-05-02 10:00:00', 7, NULL),
(28, 'Pouilly-Fumé Baron de L 2020', 'Grand Sauvignon de la Loire, complexe et raffiné.', '49.99', 60, 2, '2025-05-02 10:00:00', 7, NULL),
(29, 'Didier Dagueneau Silex 2019', 'L\'un des plus grands Sauvignons au monde, d\'une précision et d\'une pureté exceptionnelles.', '149.99', 30, 2, '2025-05-02 10:00:00', 7, NULL),
(30, 'Château d\'Yquem 2015', 'Le plus prestigieux des Sauternes, d\'une richesse et d\'une complexité incomparables.', '449.99', 25, 2, '2025-05-02 10:00:00', 7, NULL),
(31, 'Egon Müller Scharzhofberger Riesling Auslese 2018', 'Riesling allemand d\'exception, à la fois sucré et d\'une acidité vibrante.', '199.99', 30, 2, '2025-05-02 10:00:00', 8, NULL),
(32, 'Trimbach Clos Sainte Hune 2017', 'Grand Riesling d\'Alsace, sec, minéral et d\'une grande pureté.', '189.99', 35, 2, '2025-05-02 10:00:00', 8, NULL),
(33, 'Dr. Loosen Erdener Prälat Riesling 2019', 'Riesling allemand complexe et profond aux notes de fruits exotiques.', '79.99', 45, 2, '2025-05-02 10:00:00', 8, NULL),
(34, 'Domaine Raveneau Chablis Grand Cru Les Clos 2018', 'L\'un des plus grands Chablis, minéral et d\'une pureté cristalline.', '299.99', 25, 2, '2025-05-02 10:00:00', 9, NULL),
(35, 'Domaine William Fèvre Chablis Grand Cru 2020', 'Grand Chablis, tendu et minéral avec une belle profondeur.', '119.99', 40, 2, '2025-05-02 10:00:00', 9, NULL),
(36, 'Domaine Vincent Dauvissat Chablis 2021', 'Chablis classique, frais et précis avec des notes d\'agrumes et de silex.', '69.99', 60, 2, '2025-05-02 10:00:00', 9, NULL),
(37, 'Domaine Vacheron Sancerre 2022', 'Sancerre emblématique, vif et minéral aux notes d\'agrumes et de pierre à fusil.', '34.99', 75, 2, '2025-05-02 10:00:00', 10, NULL),
(38, 'Pascal Cotat Sancerre Les Monts Damnés 2021', 'Grand Sancerre, riche et complexe issu d\'un terroir exceptionnel.', '59.99', 45, 2, '2025-05-02 10:00:00', 10, NULL),
(39, 'Alphonse Mellot Sancerre Génération XIX 2020', 'Sancerre rare, profond et complexe avec un grand potentiel de garde.', '79.99', 35, 2, '2025-05-02 10:00:00', 10, NULL),
(40, 'Domaine de Ladoucette Pouilly-Fumé 2021', 'Grand classique de la Loire, élégant et raffiné.', '39.99', 65, 2, '2025-05-02 10:00:00', 10, NULL),
(41, 'Whispering Angel 2022', 'Rosé de Provence emblématique, frais et élégant avec des notes de fruits rouges et d\'agrumes.', '24.99', 150, 3, '2025-05-02 10:00:00', 11, 13),
(42, 'Château d\'Esclans Rock Angel 2021', 'Rosé de Provence premium, structuré et gastronomique.', '34.99', 100, 3, '2025-05-02 10:00:00', 11, 13),
(43, 'Château d\'Esclans Garrus 2020', 'L\'un des rosés les plus prestigieux au monde, vinifié et élevé comme un grand vin.', '99.99', 40, 3, '2025-05-02 10:00:00', 11, 13),
(44, 'Domaines Ott Château Romassan 2021', 'Grand rosé de Bandol, complexe et structuré avec un beau potentiel de garde.', '49.99', 75, 3, '2025-05-02 10:00:00', 14, 15),
(45, 'Minuty Prestige 2022', 'Rosé de Provence raffiné, élégant et expressif.', '29.99', 120, 3, '2025-05-02 10:00:00', 12, 14),
(46, 'Château Minuty Rose et Or 2021', 'Cuvée premium de Minuty, d\'une grande finesse.', '39.99', 85, 3, '2025-05-02 10:00:00', 12, 14),
(47, 'Château Minuty 281 2020', 'Rosé d\'exception, puissant et complexe avec une belle tension.', '79.99', 50, 3, '2025-05-02 10:00:00', 12, 14),
(48, 'Domaines Ott Clos Mireille 2021', 'Rosé de Provence emblématique, d\'une grande élégance.', '49.99', 70, 3, '2025-05-02 10:00:00', 12, 15),
(49, 'Domaine Tempier Bandol Rosé 2021', 'Référence des rosés de Bandol, structuré et complexe.', '44.99', 65, 3, '2025-05-02 10:00:00', 14, NULL),
(50, 'Clos Cibonne Cuvée Tradition 2020', 'Rosé atypique de Provence, élevé sous voile, aux notes épicées.', '34.99', 60, 3, '2025-05-02 10:00:00', 14, NULL),
(51, 'Château Pradeaux Bandol Rosé 2021', 'Rosé de caractère, profond et complexe.', '39.99', 55, 3, '2025-05-02 10:00:00', 14, NULL),
(52, 'Château de Pibarnon Bandol Rosé 2021', 'Grand rosé de Bandol, d\'une belle complexité et d\'une grande finesse.', '42.99', 60, 3, '2025-05-02 10:00:00', 14, NULL),
(53, 'Tavel Château d\'Aqueria 2021', 'Rosé charpenté et puissant de la vallée du Rhône.', '22.99', 90, 3, '2025-05-02 10:00:00', 13, NULL),
(54, 'Domaine de la Mordorée Tavel La Dame Rousse 2021', 'Grand Tavel, vineux et complexe avec une belle structure.', '28.99', 75, 3, '2025-05-02 10:00:00', 13, NULL),
(55, 'Château de Trinquevedel Tavel 2022', 'Rosé traditionnel de Tavel, riche et fruité.', '23.99', 85, 3, '2025-05-02 10:00:00', 13, NULL),
(56, 'Domaine Maby Tavel Prima Donna 2021', 'Tavel d\'exception, profond et complexe.', '29.99', 70, 3, '2025-05-02 10:00:00', 13, NULL),
(57, 'Château de Sancerre Rosé 2022', 'Rosé de Loire élégant et raffiné, aux notes de petits fruits rouges.', '21.99', 90, 3, '2025-05-02 10:00:00', 15, NULL),
(58, 'Domaine Vacheron Sancerre Rosé 2021', 'Rosé de Loire précis et minéral.', '29.99', 75, 3, '2025-05-02 10:00:00', 15, NULL),
(59, 'Henri Bourgeois Sancerre Rosé Les Baronnes 2022', 'Rosé de Loire frais et délicat.', '24.99', 85, 3, '2025-05-02 10:00:00', 15, NULL),
(60, 'Domaine des Baumard Cabernet d\'Anjou 2022', 'Rosé de Loire légèrement moelleux, fruité et gourmand.', '18.99', 100, 3, '2025-05-02 10:00:00', 15, NULL),
(61, 'Dom Pérignon Vintage 2012', 'Champagne d\'exception, symbole d\'élégance et de raffinement.', '219.99', 50, 4, '2025-05-02 10:00:00', 16, 4),
(62, 'Krug Grande Cuvée', 'Champagne iconique, riche et complexe, assemblage de plus de 120 vins de réserve.', '249.99', 45, 4, '2025-05-02 10:00:00', 16, 17),
(63, 'Louis Roederer Cristal 2014', 'Cuvée de prestige créée pour le Tsar de Russie, d\'une finesse et d\'une élégance incomparables.', '299.99', 40, 4, '2025-05-02 10:00:00', 16, NULL),
(64, 'Bollinger La Grande Année 2012', 'Grand champagne de caractère, vineux et complexe.', '179.99', 55, 4, '2025-05-02 10:00:00', 16, 16),
(65, 'Salon S 2008', 'Champagne rare et d\'exception, produit uniquement lors des grandes années.', '999.99', 15, 4, '2025-05-02 10:00:00', 16, NULL),
(66, 'Dom Pérignon Rosé 2008', 'Champagne rosé d\'exception, alliance parfaite de puissance et de délicatesse.', '399.99', 30, 4, '2025-05-02 10:00:00', 17, 4),
(67, 'Laurent-Perrier Cuvée Rosé', 'Champagne rosé emblématique, aux notes de fruits rouges frais.', '89.99', 70, 4, '2025-05-02 10:00:00', 17, NULL),
(68, 'Billecart-Salmon Brut Rosé', 'Champagne rosé d\'une grande finesse, élégant et raffiné.', '79.99', 75, 4, '2025-05-02 10:00:00', 17, NULL),
(69, 'Ruinart Rosé', 'Champagne rosé gourmand et fruité, d\'une belle fraîcheur.', '84.99', 65, 4, '2025-05-02 10:00:00', 17, NULL),
(70, 'Veuve Clicquot La Grande Dame Rosé 2008', 'Champagne rosé d\'exception, complexe et d\'une grande finesse.', '349.99', 25, 4, '2025-05-02 10:00:00', 17, 5),
(71, 'Dom Pérignon P2 2003', 'Deuxième plénitude de Dom Pérignon, complexe et d\'une grande profondeur.', '449.99', 20, 4, '2025-05-02 10:00:00', 18, 4),
(72, 'Krug Vintage 2006', 'Champagne millésimé d\'exception, riche et complexe.', '349.99', 30, 4, '2025-05-02 10:00:00', 18, 17),
(73, 'Louis Roederer Cristal Vinothèque 1995', 'Cristal d\'exception à maturité parfaite, d\'une complexité incomparable.', '1499.99', 10, 4, '2025-05-02 10:00:00', 18, NULL),
(74, 'Taittinger Comtes de Champagne 2008', 'Grand Blanc de Blancs, d\'une pureté et d\'une élégance remarquables.', '199.99', 40, 4, '2025-05-02 10:00:00', 19, NULL),
(75, 'Ruinart Blanc de Blancs', 'Champagne emblématique, frais et élégant, aux notes d\'agrumes et de fleurs blanches.', '89.99', 65, 4, '2025-05-02 10:00:00', 19, NULL),
(76, 'Delamotte Blanc de Blancs', 'Champagne élégant et raffiné, issu exclusivement de Chardonnay.', '69.99', 70, 4, '2025-05-02 10:00:00', 19, NULL),
(77, 'Salon Le Mesnil 2012', 'L\'un des plus grands Blancs de Blancs, d\'une pureté et d\'une précision exceptionnelles.', '899.99', 15, 4, '2025-05-02 10:00:00', 19, NULL),
(78, 'Bollinger PN VZ16', 'Blanc de Noirs d\'exception, intense et structuré.', '119.99', 45, 4, '2025-05-02 10:00:00', 20, 16),
(79, 'Cédric Bouchard Roses de Jeanne Côte de Béchalin', 'Rare Blanc de Noirs, d\'une pureté et d\'une précision incroyables.', '149.99', 30, 4, '2025-05-02 10:00:00', 20, NULL),
(80, 'Philipponnat Clos des Goisses 2011', 'Grand Blanc de Noirs issu d\'une parcelle unique, puissant et complexe.', '199.99', 25, 4, '2025-05-02 10:00:00', 20, NULL),
(81, 'Johnnie Walker Blue Label', 'Assemblage d\'exception des meilleurs whiskies écossais, doux et complexe.', '199.99', 60, 5, '2025-05-02 10:00:00', 21, 18),
(82, 'Macallan 18 ans Sherry Oak', 'Single malt d\'exception, élevé en fûts de sherry, riche et complexe.', '349.99', 45, 5, '2025-05-02 10:00:00', 21, NULL),
(83, 'Hibiki 21 ans', 'Whisky japonais d\'exception, harmonieux et délicat.', '599.99', 25, 5, '2025-05-02 10:00:00', 21, NULL),
(84, 'Lagavulin 16 ans', 'Single malt écossais emblématique, intense et tourbé.', '89.99', 70, 5, '2025-05-02 10:00:00', 21, NULL),
(85, 'Yamazaki 12 ans', 'Single malt japonais élégant, aux notes de fruits et d\'épices.', '149.99', 50, 5, '2025-05-02 10:00:00', 21, NULL),
(86, 'Zacapa XO', 'Rhum guatémaltèque d\'exception, riche et complexe.', '129.99', 55, 5, '2025-05-02 10:00:00', 22, NULL),
(87, 'Diplomatico Ambassador', 'Rhum vénézuélien d\'exception, rond et gourmand.', '249.99', 35, 5, '2025-05-02 10:00:00', 22, NULL),
(88, 'Appleton Estate 21 ans', 'Rhum jamaïcain complexe, aux notes de fruits confits et d\'épices.', '179.99', 40, 5, '2025-05-02 10:00:00', 22, NULL),
(89, 'Clément XO', 'Rhum agricole de Martinique, élégant et raffiné.', '149.99', 45, 5, '2025-05-02 10:00:00', 22, NULL),
(90, 'Havana Club Máximo Extra Añejo', 'Rhum cubain d\'exception, rare et précieux.', '1499.99', 10, 5, '2025-05-02 10:00:00', 22, NULL),
(91, 'Grey Goose VX', 'Vodka française premium, infusée de cognac, douce et élégante.', '89.99', 65, 5, '2025-05-02 10:00:00', 23, 19),
(92, 'Belvedere Unfiltered', 'Vodka polonaise d\'exception, riche et texturée.', '59.99', 75, 5, '2025-05-02 10:00:00', 23, NULL),
(93, 'Absolut Elyx', 'Vodka suédoise premium, douce et soyeuse.', '49.99', 80, 5, '2025-05-02 10:00:00', 23, 8),
(94, 'Stolichnaya Elit', 'Vodka russe de luxe, pure et cristalline.', '69.99', 70, 5, '2025-05-02 10:00:00', 23, NULL),
(95, 'Beluga Gold Line', 'Vodka russe d\'exception, douce et complexe.', '149.99', 45, 5, '2025-05-02 10:00:00', 23, NULL),
(96, 'Hennessy XO', 'Cognac emblématique, riche et complexe aux notes de fruits confits et d\'épices.', '199.99', 55, 5, '2025-05-02 10:00:00', 24, 6),
(97, 'Rémy Martin Louis XIII', 'Cognac d\'exception, assemblage de plus de 1200 eaux-de-vie, d\'une complexité incomparable.', '3499.99', 8, 5, '2025-05-02 10:00:00', 24, NULL),
(98, 'Martell Cordon Bleu', 'Cognac emblématique, rond et fruité.', '149.99', 60, 5, '2025-05-02 10:00:00', 24, NULL),
(99, 'Courvoisier XO', 'Cognac élégant et complexe, aux notes de fruits secs et d\'épices.', '179.99', 50, 5, '2025-05-02 10:00:00', 24, NULL),
(100, 'Hine Antique XO', 'Cognac raffiné et délicat, d\'une grande élégance.', '189.99', 45, 5, '2025-05-02 10:00:00', 24, NULL),
(101, 'Patrón Añejo', 'Tequila premium, élevée en fût de chêne, douce et complexe.', '69.99', 75, 5, '2025-05-02 10:00:00', 25, 20),
(102, 'Don Julio 1942', 'Tequila d\'exception, riche et onctueuse.', '179.99', 50, 5, '2025-05-02 10:00:00', 25, NULL),
(103, 'Clase Azul Reposado', 'Tequila premium dans une bouteille artisanale, douce et raffinée.', '149.99', 55, 5, '2025-05-02 10:00:00', 25, NULL),
(104, 'Casamigos Añejo', 'Tequila élégante créée par George Clooney, douce et complexe.', '79.99', 70, 5, '2025-05-02 10:00:00', 25, NULL),
(105, 'Gran Patrón Platinum', 'Tequila ultra-premium, cristalline et raffinée.', '199.99', 40, 5, '2025-05-02 10:00:00', 25, 20);

-- --------------------------------------------------------

--
-- Structure de la table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image_url`) VALUES
(1, 1, '/images/products/chateau-margaux-2018.jpg'),
(2, 2, '/images/products/chateau-lafite-2015.jpg'),
(3, 3, '/images/products/chateau-latour-2016.jpg'),
(4, 21, '/images/products/montrachet-grand-cru-2019.jpg'),
(5, 22, '/images/products/corton-charlemagne-2018.jpg'),
(6, 41, '/images/products/whispering-angel-2022.jpg'),
(7, 42, '/images/products/rock-angel-2021.jpg'),
(8, 61, '/images/products/dom-perignon-2012.jpg'),
(9, 62, '/images/products/krug-grande-cuvee.jpg'),
(10, 81, '/images/products/johnnie-walker-blue.jpg'),
(11, 82, '/images/products/macallan-18.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `comment` text,
  `rating` int(11) NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `id` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `role` enum('client','admin') NOT NULL DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `last_name`, `first_name`, `email`, `password`, `birth_date`, `role`, `created_at`) VALUES
(1, 'Escobar', 'Pablo', 'escobar.pablo@gmail.com', '$2y$10$5S6l6jarLQenNDK.efmK..ga2vi308OqE8VswkugDyfzW3aGhHKMe', '1999-12-12', '', '2025-04-29 08:27:11');

-- --------------------------------------------------------

--
-- Structure de la table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('billing','shipping') NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Index pour la table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pour la table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`id`);

--
-- Contraintes pour la table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
