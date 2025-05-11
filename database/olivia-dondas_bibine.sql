-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 11 mai 2025 à 22:16
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
(20, 'Patrón');

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
  `featured` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `created_at`, `featured`) VALUES
(1, 'Château Margaux', NULL, 120.00, 10, 1, '2025-05-11 18:05:03', 0),
(2, 'Whispering Angel', NULL, 25.00, 20, 2, '2025-05-11 18:05:03', 0),
(3, 'Dom Pérignon', NULL, 180.00, 5, 1, '2025-05-11 18:05:03', 0),
(4, 'Cloudy Bay', NULL, 35.00, 15, 3, '2025-05-11 18:05:03', 0),
(106, 'Château Margaux 2018', 'Grand cru classé de Margaux aux tanins soyeux', 589.99, 50, 1, '2025-05-11 17:46:25', 1),
(107, 'Whispering Angel Rosé 2022', 'Rosé de Provence frais et fruité', 24.99, 150, 3, '2025-05-11 17:46:25', 1),
(108, 'Dom Pérignon Vintage 2012', 'Champagne de prestige aux arômes complexes', 219.99, 30, 4, '2025-05-11 17:46:25', 1),
(109, 'Cloudy Bay Sauvignon Blanc', 'Vin blanc néo-zélandais vif et aromatique', 39.99, 80, 2, '2025-05-11 17:46:25', 0),
(140, 'Château Margaux 2015', 'Velours en bouteille, ce Margaux charme par sa finesse et sa complexité. Un incontournable pour les grandes occasions (ou un mardi soir qui mérite d\'être spécial).', 650.00, 35, 1, '2025-05-11 23:36:52', 1),
(141, 'Domaine de la Romanée-Conti 2012', 'Le Saint Graal des vins rouges. Chaque gorgée est une légende. Tellement exclusif qu\'il se murmure qu\'il a son propre agent secret.', 15000.00, 3, 1, '2025-05-11 23:36:52', 1),
(142, 'Château Lafite Rothschild 2017', 'Élégance et puissance, un Pauillac racé qui en impose. Parfait pour impressionner votre belle-mère (ou votre banquier).', 550.00, 28, 1, '2025-05-11 23:36:52', 0),
(143, 'Château Latour 2014', 'La forteresse des saveurs, un vin solide et profond. Idéal pour les longues gardes... si vous arrivez à résister à l\'envie de l\'ouvrir avant !', 480.00, 42, 1, '2025-05-11 23:36:52', 0),
(144, 'Gevrey-Chambertin 2018, Domaine Armand Rousseau', 'Pinot noir de Bourgogne dans toute sa splendeur. Fruité, complexe, une danse délicate en bouche. Presque aussi agréable qu\'une sieste au soleil.', 180.00, 60, 1, '2025-05-11 23:36:52', 0),
(145, 'Hermitage La Chapelle 2016, Paul Jaboulet Aîné', 'Un Rhône septentrional opulent et épicé. Pour les amateurs de sensations fortes... en douceur, bien sûr.', 120.00, 55, 1, '2025-05-11 23:36:52', 0),
(146, 'Saint-Émilion Grand Cru Classé 2019, Château Angélus', 'Soyeux et charmeur, un vin de la rive droite bordelaise qui séduit dès la première rencontre. Un peu comme un premier rendez-vous réussi.', 280.00, 30, 1, '2025-05-11 23:36:52', 0),
(147, 'Pomerol 2020, Château Pétrus (Fictif)', 'L\'élixir rouge ultime (dans notre monde fictif, du moins !). Une concentration de fruits et de velours. Tellement bon qu\'il pourrait résoudre les conflits mondiaux.', 5000.00, 5, 1, '2025-05-11 23:36:52', 0),
(148, 'Côte-Rôtie 2017, Domaine Guigal', 'Viognier et Syrah en parfaite harmonie, un vin parfumé et intense. Un voyage olfactif et gustatif garanti.', 95.00, 70, 1, '2025-05-11 23:36:52', 0),
(149, 'Barolo Riserva 2015, Giacomo Conterno', 'Le roi des vins italiens, puissant et tannique, avec un potentiel de garde immense. Patience est mère de toutes les saveurs.', 250.00, 20, 1, '2025-05-11 23:36:52', 0),
(150, 'Rioja Gran Reserva 2011, La Rioja Alta S.A.', 'Un classique espagnol, élégant et complexe, avec des notes de fruits mûrs et d\'épices. Parfait avec des tapas... et une bonne conversation.', 65.00, 80, 1, '2025-05-11 23:36:52', 0),
(151, 'Pinot Noir de Bourgogne 2020, Domaine Leroy (Fictif)', 'L\'expression ultime du Pinot Noir (dans notre fiction !). Pureté, finesse, une émotion liquide. Rare comme une éclipse totale.', 800.00, 10, 1, '2025-05-11 23:36:52', 0),
(152, 'Amarone della Valpolicella Classico 2016, Bertani', 'Un vin italien riche et corsé, élaboré à partir de raisins passerillés. Un délice pour les sens, idéal pour les soirées cocooning.', 110.00, 45, 1, '2025-05-11 23:36:52', 0),
(153, 'Cabernet Sauvignon Napa Valley 2018, Opus One', 'Un mariage californien de l\'élégance bordelaise et de la richesse de la Napa. Un blockbuster en bouteille.', 190.00, 38, 1, '2025-05-11 23:36:52', 0),
(154, 'Syrah Crozes-Hermitage 2019, Alain Graillot', 'Un Rhône plus accessible mais avec beaucoup de caractère. Fruité, épicé, parfait pour accompagner vos grillades d\'été.', 38.00, 90, 1, '2025-05-11 23:36:52', 0),
(155, 'Meursault 1er Cru Charmes 2019, Domaine des Comtes Lafon', 'L\'élégance bourguignonne en blanc. Beurre, noisette, une texture soyeuse. Presque trop bon pour être vrai.', 150.00, 25, 2, '2025-05-11 23:36:52', 1),
(156, 'Sancerre 2021, Domaine Didier Dagueneau (Fictif)', 'Sauvignon blanc de Loire au sommet. Minéralité, agrumes, une vivacité rafraîchissante. Le coup de fouet idéal après une longue journée.', 60.00, 75, 2, '2025-05-11 23:36:52', 0),
(157, 'Chablis Grand Cru Les Clos 2018, Domaine William Fèvre', 'L\'expression pure du Chardonnay en terre chablisienne. Minéral, ciselé, une longueur en bouche impressionnante. Un vin qui a de la conversation.', 120.00, 30, 2, '2025-05-11 23:36:52', 0),
(158, 'Pouilly-Fumé 2020, Domaine Serge Dagueneau & Filles', 'Un autre grand Sauvignon de la Loire, avec ses notes fumées caractéristiques. Parfait avec des fruits de mer... et des rêves d\'océan.', 45.00, 85, 2, '2025-05-11 23:36:52', 0),
(159, 'Riesling Trocken Goldloch GG 2019, Weingut Keller', 'Un Riesling allemand sec et complexe, avec une acidité vibrante et des arômes de fruits blancs et de pierre à fusil. Un vin qui réveille les papilles.', 75.00, 50, 2, '2025-05-11 23:36:52', 0),
(160, 'Condrieu La Doriane 2020, Domaine Guigal', 'L\'explosion aromatique du Viognier. Abricot, pêche, fleurs blanches, une gourmandise liquide. Presque un parfum en bouteille.', 85.00, 40, 2, '2025-05-11 23:36:52', 0),
(161, 'Hermitage Blanc 2017, M. Chapoutier', 'Un blanc puissant et complexe du Rhône, à base de Marsanne, Roussanne et Viognier. Un vin de gastronomie qui ne passe pas inaperçu.', 90.00, 35, 2, '2025-05-11 23:36:52', 0),
(162, 'Sauvignon Blanc Marlborough 2022, Cloudy Bay', 'Le classique néo-zélandais, vif et plein d\'arômes de groseille et de fruit de la passion. Le soleil en bouteille, même quand il pleut.', 38.00, 100, 2, '2025-05-11 23:36:52', 0),
(163, 'Pinot Blanc Alsace 2021, Domaine Zind-Humbrecht', 'Un blanc alsacien sec et fruité, avec une belle minéralité. Parfait pour accompagner vos tartes flambées (et vos discussions animées).', 32.00, 90, 2, '2025-05-11 23:36:52', 0),
(164, 'Fiano di Avellino 2020, Feudi di San Gregorio', 'Un blanc italien élégant et parfumé, avec des notes d\'amande et de noisette. Un voyage ensoleillé vers la Campanie.', 40.00, 65, 2, '2025-05-11 23:36:52', 0),
(165, 'Vermentino di Sardegna 2021, Capichera', 'Un blanc sarde frais et minéral, avec des arômes d\'herbes et d\'agrumes. Le goût des vacances en Méditerranée.', 35.00, 70, 2, '2025-05-11 23:36:52', 0),
(166, 'Chenin Blanc Savennières 2018, Domaine Nicolas Joly', 'Un blanc de Loire puissant et complexe, avec des notes de miel et de fruits secs. Un vin biodynamique qui a une âme.', 55.00, 45, 2, '2025-05-11 23:36:52', 0),
(167, 'Gewürztraminer Alsace Grand Cru 2019, Domaine Trimbach', 'Un blanc alsacien aromatique et épicé, avec des notes de litchi et de rose. Un vin exotique qui fait voyager les sens.', 50.00, 55, 2, '2025-05-11 23:36:52', 0),
(168, 'Viognier Pays d\'Oc 2022, Domaine de la Mordorée (Fictif)', 'Un Viognier du sud de la France plein de fruit et de fraîcheur (dans notre monde imaginaire !). Parfait pour un apéro ensoleillé.', 28.00, 110, 2, '2025-05-11 23:36:52', 0),
(169, 'Grechetto Colli Martani 2020, Arnaldo Caprai', 'Un blanc italien sec et minéral d\'Ombrie. Une belle découverte pour sortir des sentiers battus.', 30.00, 80, 2, '2025-05-11 23:36:52', 0),
(170, 'Côtes de Provence Rosé 2022, Château Minuty', 'L\'emblématique rosé de Provence, frais, fruité, parfait pour les apéros ensoleillés et les barbecues entre amis. Le rosé qui fait toujours bonne impression.', 22.00, 150, 3, '2025-05-11 23:36:52', 1),
(171, 'Côtes de Provence Rosé 2022, Château d\'Esclans Whispering Angel', 'Le chouchou de la Côte d\'Azur, un rosé élégant et délicat, avec des notes de fruits rouges et de fleurs. Presque aussi beau que le coucher de soleil sur la mer.', 28.00, 120, 3, '2025-05-11 23:36:52', 1),
(172, 'Bandol Rosé 2021, Domaine Tempier', 'Un rosé de Provence plus puissant et vineux, avec une belle structure et des arômes de fruits mûrs et d\'épices. Le rosé pour ceux qui pensent que le rosé, c\'est sérieux.', 35.00, 80, 3, '2025-05-11 23:36:52', 0),
(173, 'Tavel Rosé 2020, Domaine de la Mordorée', 'Le \"roi des rosés\", un vin riche et corsé du Rhône, avec des notes de fruits rouges et d\'épices. Un rosé qui a du corps et de la conversation.', 30.00, 95, 3, '2025-05-11 23:36:52', 0),
(174, 'Lirac Rosé 2021, Domaine de la Charbonnière', 'Un autre beau rosé de la Vallée du Rhône, fruité et épicé, une alternative intéressante aux Côtes du Rhône classiques.', 25.00, 110, 3, '2025-05-11 23:36:52', 0),
(175, 'Rosé de Loire 2022, Domaine des Baumard', 'Un rosé sec et fruité de la Loire, léger et rafraîchissant. Parfait pour accompagner vos salades d\'été et vos pique-niques au bord de l\'eau.', 18.00, 130, 3, '2025-05-11 23:36:52', 0),
(176, 'Coteaux d\'Aix-en-Provence Rosé 2022, Château La Coste', 'Un rosé élégant et minéral, issu d\'un domaine viticole et artistique. Un rosé qui a du style et de la personnalité.', 26.00, 100, 3, '2025-05-11 23:36:52', 0),
(177, 'IGP Méditerranée Rosé 2022, Miraval', 'Le rosé de Brad et Angelina (enfin, une partie de leur histoire !), un vin frais et fruité avec une belle minéralité. Un rosé de star... à prix plus abordable.', 24.00, 115, 3, '2025-05-11 23:36:52', 0),
(178, 'Rosato Toscana 2022, Antinori (Fictif)', 'Un rosé toscan sec et fruité (dans notre imagination !), avec des notes de cerise et d\'agrumes. Le soleil de l\'Italie dans votre verre.', 20.00, 140, 3, '2025-05-11 23:36:52', 0),
(179, 'Rosado Navarra 2022, Bodegas Ochoa', 'Un rosé espagnol fruité et sec, élaboré principalement à partir de Grenache. Parfait pour accompagner vos tapas et vos soirées animées.', 16.00, 155, 3, '2025-05-11 23:36:52', 0),
(180, 'Rosé Côtes du Rhône 2022, E. Guigal', 'Un rosé du Rhône accessible et gourmand, avec des arômes de fruits rouges frais. Le rosé de tous les jours qui fait toujours plaisir.', 15.00, 160, 3, '2025-05-11 23:36:52', 0),
(181, 'Rosé Syrah Pays d\'Oc 2022, Gérard Bertrand', 'Un rosé du Languedoc-Roussillon fruité et épicé, avec une belle fraîcheur. Un vin convivial pour vos moments de détente.', 14.00, 170, 3, '2025-05-11 23:36:52', 0),
(182, 'Rosé Cabernet d\'Anjou 2022, Domaine Ogereau', 'Un rosé demi-sec de la Loire, fruité et légèrement doux. Parfait pour accompagner vos desserts aux fruits rouges.', 19.00, 125, 3, '2025-05-11 23:36:52', 0),
(183, 'Rosé Pinot Noir Vin de France 2022, Albert Bichot', 'Un rosé léger et délicat à base de Pinot Noir, avec des arômes de petits fruits rouges. Un rosé élégant pour vos apéritifs raffinés.', 21.00, 135, 3, '2025-05-11 23:36:52', 0),
(184, 'Rosé Grenache Cinsault Pays d\'Oc 2022, Paul Mas', 'Un rosé du sud de la France facile à boire et plein de fruit. Le compagnon idéal de vos pique-niques improvisés.', 12.00, 180, 3, '2025-05-11 23:36:52', 0),
(185, 'Champagne Brut Réserve, Veuve Clicquot', 'L\'étiquette jaune emblématique, un champagne équilibré et vineux, parfait pour célébrer toutes les occasions (même le fait d\'avoir survécu à la semaine).', 60.00, 80, 4, '2025-05-11 23:36:52', 1),
(186, 'Champagne Brut Premier, Bollinger', 'Un champagne puissant et complexe, avec une belle vinosité et des notes de fruits secs. Le champagne des agents secrets... et des gens qui ont bon goût.', 75.00, 65, 4, '2025-05-11 23:36:52', 1),
(187, 'Champagne Grande Cuvée 170ème Édition, Krug', 'L\'expression ultime du champagne multi-millésimé, une complexité et une richesse inégalées. Une symphonie de saveurs en bulles.', 250.00, 20, 4, '2025-05-11 23:36:52', 1),
(188, 'Champagne Brut Impérial, Moët & Chandon', 'Le champagne le plus vendu au monde, un classique équilibré et élégant. Parfait pour vos toasts et vos moments de partage.', 55.00, 90, 4, '2025-05-11 23:36:52', 0),
(189, 'Champagne Rosé Réserve, Laurent-Perrier', 'Un champagne rosé frais et fruité, avec des arômes de petits fruits rouges. Élégant et gourmand, idéal pour vos apéritifs romantiques (ou entre amis).', 70.00, 70, 4, '2025-05-11 23:36:52', 0),
(190, 'Champagne Blanc de Blancs Brut Nature, Salon (Fictif)', 'L\'apogée du Chardonnay en Champagne, un champagne pur et minéral, sans dosage. Pour les puristes des bulles.', 300.00, 15, 4, '2025-05-11 23:36:52', 0),
(191, 'Champagne Millésimé 2013, Dom Pérignon', 'Un champagne d\'exception, expression d\'une seule année, avec une complexité et une finesse remarquables. Chaque millésime raconte une histoire.', 220.00, 35, 4, '2025-05-11 23:36:52', 0),
(192, 'Champagne Blanc de Noirs Brut, Philipponnat', 'Un champagne élaboré à partir de Pinot Noir et de Meunier, offrant une richesse et une vinosité uniques. Pour ceux qui aiment les bulles avec du corps.', 65.00, 75, 4, '2025-05-11 23:36:52', 0),
(193, 'Champagne Extra Brut, Agrapart & Fils', 'Un champagne de vigneron, précis et minéral, avec un faible dosage. L\'expression authentique du terroir champenois.', 58.00, 85, 4, '2025-05-11 23:36:52', 0),
(194, 'Champagne Demi-Sec, Ruinart', 'Un champagne doux et fruité, parfait pour accompagner vos desserts et vos moments de gourmandise. Les bulles sucrées de la joie de vivre.', 62.00, 60, 4, '2025-05-11 23:36:52', 0),
(195, 'Champagne Rosé de Saignée, Francis Egly-Ouriet', 'Un champagne rosé puissant et vineux, élaboré par saignée, avec des arômes intenses de fruits rouges. Un rosé de caractère.', 110.00, 40, 4, '2025-05-11 23:36:52', 0),
(196, 'Champagne Extra Brut Blanc de Blancs, Pierre Péters', 'Un champagne 100% Chardonnay, avec une minéralité et une pureté exceptionnelles. Un vin ciselé pour les amateurs de sensations vives.', 80.00, 55, 4, '2025-05-11 23:36:52', 0),
(197, 'Champagne Premier Cru, Larmandier-Bernier', 'Un champagne élégant et équilibré, issu de vignes Premier Cru, avec une belle fraîcheur et une longue finale.', 72.00, 68, 4, '2025-05-11 23:36:52', 0),
(198, 'Champagne Grand Cru Millésimé, Salon', 'L\'apogée du Chardonnay en Champagne, un champagne pur et minéral, sans dosage. Pour les puristes des bulles.', 300.00, 15, 4, '2025-05-11 23:36:52', 0),
(199, 'Champagne Rosé, Billecart-Salmon', 'Un rosé délicat et raffiné, avec des arômes subtils de fruits rouges et d\'agrumes. L\'élégance incarnée en rose.', 78.00, 62, 4, '2025-05-11 23:36:52', 0),
(200, 'Whisky Single Malt Lagavulin 16 ans', 'Un whisky écossais tourbé et puissant, avec des arômes de fumée, d\'iode et d\'épices. Pour les amateurs de sensations fortes... et de saveurs complexes.', 80.00, 50, 5, '2025-05-11 23:36:52', 0),
(201, 'Rhum Agricole Vieux VSOP, Rhum Clément', 'Un rhum agricole de Martinique, vieilli en fûts de chêne, avec des notes de fruits exotiques, d\'épices et de vanille. Un voyage ensoleillé dans les Caraïbes.', 65.00, 60, 5, '2025-05-11 23:36:52', 0),
(202, 'Vodka Elyx, Absolut', 'Une vodka suédoise de luxe, distillée dans des alambics en cuivre, pour une pureté et une douceur exceptionnelles. La vodka qui fait briller vos cocktails.', 55.00, 70, 5, '2025-05-11 23:36:52', 0),
(203, 'Cognac XO, Hennessy', 'Un cognac d\'exception, assemblage d\'eaux-de-vie vieillies pendant de nombreuses années, avec des arômes complexes de fruits confits, d\'épices et de cuir. Le cognac des grandes occasions.', 180.00, 25, 5, '2025-05-11 23:36:52', 0),
(204, 'Tequila Añejo, Clase Azul Reposado', 'Une tequila mexicaine vieillie en fûts de chêne, avec des notes de vanille, de caramel et d\'épices douces. Une tequila à déguster lentement, pour apprécier toute sa complexité.', 120.00, 30, 5, '2025-05-11 23:36:52', 0),
(205, 'Gin Mare', 'Un gin méditerranéen, distillé avec des botaniques comme l\'olive, le thym, le romarin et le basilic. Le goût du soleil et des vacances dans votre verre.', 45.00, 80, 5, '2025-05-11 23:36:52', 0),
(206, 'Armagnac XO, Château de Laubade', 'Un armagnac traditionnel de Gascogne, vieilli en fûts de chêne, avec des arômes de fruits secs, d\'épices et de boisé. Un spiritueux authentique et chaleureux.', 90.00, 45, 5, '2025-05-11 23:36:52', 0),
(207, 'Bourbon Single Barrel, Blanton\'s', 'Un bourbon américain de caractère, vieilli en fût unique, avec des notes de caramel, de vanille et d\'épices. Chaque bouteille est unique.', 70.00, 55, 5, '2025-05-11 23:36:52', 0),
(208, 'Calvados XO, Boulard', 'Un eau-de-vie de cidre normande, vieillie en fûts de chêne, avec des arômes de pomme cuite, d\'épices et de boisé. Le goût de la Normandie dans un verre.', 60.00, 65, 5, '2025-05-11 23:36:52', 0),
(209, 'Grappa Riserva, Nonino', 'Une grappa italienne élégante et parfumée, vieillie en fûts de chêne, avec des notes de fruits secs, d\'amande et de vanille. Un digestif raffiné.', 50.00, 75, 5, '2025-05-11 23:36:52', 0),
(210, 'Mezcal Añejo, Del Maguey Vida', 'Un mezcal mexicain artisanal, avec des arômes fumés et fruités. Une expérience gustative intense et authentique.', 85.00, 50, 5, '2025-05-11 23:36:52', 0),
(211, 'Sake Junmai Daiginjo, Dassai 23', 'Un saké japonais d\'exception, élaboré à partir de riz poli à 23%, pour une pureté et une finesse incomparables. Une boisson raffinée et délicate.', 150.00, 20, 5, '2025-05-11 23:36:52', 0),
(212, 'Pisco Barsol Quebranta', 'Un eau-de-vie de raisin péruvienne, non vieillie, avec des arômes fruités et floraux. L\'ingrédient indispensable du Pisco Sour.', 40.00, 90, 5, '2025-05-11 23:36:52', 0),
(213, 'Arak Brun, Ksarak', 'Un spiritueux libanais anisé, vieilli en amphores, avec des arômes complexes d\'anis, de fruits secs et d\'épices. Une boisson traditionnelle et envoûtante.', 75.00, 55, 5, '2025-05-11 23:36:52', 0),
(214, 'Cachaça Envelhecida, Leblon', 'Une cachaça brésilienne vieillie en fûts de chêne, avec des notes de caramel, de vanille et d\'épices. La base parfaite pour une Caïpirinha premium.', 48.00, 80, 5, '2025-05-11 23:36:52', 0);

-- --------------------------------------------------------

--
-- Structure de la table `product_image`
--

CREATE TABLE `product_image` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image_url`) VALUES
(16, 1, '/images/chateau-margaux.jpg'),
(17, 2, '/images/whispering-angel.jpg'),
(18, 3, '/images/dom-perignon.jpg'),
(19, 4, '/images/cloudy-bay.jpg');

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
  ADD KEY `category_id` (`category_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT pour la table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
