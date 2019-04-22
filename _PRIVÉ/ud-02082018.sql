-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 02 août 2018 à 09:03
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ud`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresses`
--

DROP TABLE IF EXISTS `adresses`;
CREATE TABLE IF NOT EXISTS `adresses` (
  `adresse_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `remarques` text,
  PRIMARY KEY (`adresse_id`),
  KEY `FK_Adress_User` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adresses`
--

INSERT INTO `adresses` (`adresse_id`, `user_id`, `nom`, `cp`, `ville`, `actif`, `remarques`) VALUES
(1, 1, 'Paris Stade de France', '93210', 'LA PLAINE SAINT-DENIS', 1, NULL),
(3, 3, 'Paris Stade de France', '93210', 'LA PLAINE SAINT-DENIS', 1, NULL),
(4, 4, 'Paris Stade de France', '93210', 'LA PLAINE SAINT-DENIS', 1, NULL),
(6, 2, '17 résidence Jean Monnet', '93190', 'LIVRY GARGAN', 1, 'test'),
(7, 2, 'Paris Stade de France', '93210', 'LA PLAINE SAINT-DENIS', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categorie_id` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `icone` varchar(50) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `remarques` text,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`categorie_id`, `nom`, `icone`, `actif`, `remarques`) VALUES
(1, 'Drink', 'cocktail', 1, 'Énergique, gazeuse et pleine de vitamine'),
(2, 'Fire', 'gripfire', 1, 'Test'),
(3, 'Tendances', 'rendact', 1, 'Test');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `commande_id` int(15) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `date` date NOT NULL,
  `remarques` text,
  PRIMARY KEY (`commande_id`),
  KEY `client_campagne` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`commande_id`, `user_id`, `date`, `remarques`) VALUES
(1, 3, '2018-06-06', 'test'),
(2, 4, '2018-06-06', 'test'),
(3, 3, '2018-06-06', 'test'),
(4, 4, '2018-06-06', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

DROP TABLE IF EXISTS `groupes`;
CREATE TABLE IF NOT EXISTS `groupes` (
  `groupe_id` int(2) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `type` set('admin','client') NOT NULL DEFAULT 'client',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `remarques` text,
  PRIMARY KEY (`groupe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`groupe_id`, `nom`, `type`, `actif`, `remarques`) VALUES
(1, 'Administrateur', 'admin', 1, NULL),
(2, 'Logistique', 'client', 1, NULL),
(3, 'Professionnel', 'client', 1, ''),
(4, 'Particulier', 'client', 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `produit_id` int(10) NOT NULL AUTO_INCREMENT,
  `souscategorie_id` int(10) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `pu` decimal(7,2) NOT NULL,
  `tva` decimal(7,2) NOT NULL,
  `devise` enum('&#36;','&euro;','&pound;') NOT NULL,
  `majeur` tinyint(1) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `remarques` text,
  `statue` enum('default','new','promo') NOT NULL,
  PRIMARY KEY (`produit_id`),
  KEY `FK_Product_Subcategory` (`souscategorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`produit_id`, `souscategorie_id`, `nom`, `pu`, `tva`, `devise`, `majeur`, `description`, `image`, `actif`, `remarques`, `statue`) VALUES
(1, 1, 'Che', '10.00', '10.00', '&euro;', 16, 'Super boisson venue au goût original', 'che.png', 1, 'test', 'default'),
(2, 1, 'Che Original', '15.00', '15.00', '&euro;', 18, 'La boisson originale', 'che.png', 1, 'test 2', 'default'),
(3, 1, 'Che', '5.00', '10.00', '&euro;', 16, 'Super boisson venue au goût original', 'che.png', 1, 'test', 'default'),
(4, 1, 'Che Original', '18.00', '15.00', '&euro;', 18, 'La boisson originale', 'che.png', 1, 'test 2', 'default'),
(5, 1, 'Che New', '10.00', '10.00', '&euro;', 16, 'Super boisson venue au goût original', 'che.png', 1, 'test', 'new'),
(6, 1, 'Che Guevara', '15.00', '15.00', '&euro;', 18, 'La boisson originale', 'che.png', 1, 'test 2', 'default'),
(7, 1, 'Che Absolute', '5.00', '10.00', '&euro;', 16, 'Super boisson venue au goût original', 'che.png', 1, 'test', 'default'),
(8, 1, 'Che Original One Edition', '18.00', '15.00', '&euro;', 18, 'La boisson originale', 'che.png', 1, 'test 2', 'new'),
(9, 1, 'Che Light', '10.00', '10.00', '&euro;', 16, 'Super boisson venue au goût original', 'che.png', 1, 'test', 'promo'),
(10, 1, 'Che Zero', '15.00', '15.00', '&euro;', 18, 'La boisson originale', 'che.png', 1, 'test 2', 'promo');

-- --------------------------------------------------------

--
-- Structure de la table `souscategories`
--

DROP TABLE IF EXISTS `souscategories`;
CREATE TABLE IF NOT EXISTS `souscategories` (
  `souscategorie_id` int(10) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(10) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `remarques` text,
  PRIMARY KEY (`souscategorie_id`),
  KEY `FK_Subcategory_Category` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `souscategories`
--

INSERT INTO `souscategories` (`souscategorie_id`, `categorie_id`, `nom`, `image`, `actif`, `remarques`) VALUES
(1, 1, 'Energisant', '', 1, NULL),
(3, 1, 'Soft', '', 1, NULL),
(4, 1, 'Alcool', '', 1, NULL),
(5, 1, 'Cocktail', '', 1, NULL),
(6, 3, 'Plage', '', 1, NULL),
(7, 2, 'Recette Original', '', 1, NULL),
(8, 1, 'Energisant', '', 1, NULL),
(9, 1, 'Soft', '', 1, NULL),
(10, 1, 'Alcool', '', 1, NULL),
(11, 1, 'Cocktail', '', 1, NULL),
(12, 1, 'Energisant', '', 1, NULL),
(13, 1, 'Energisant', '', 1, NULL),
(14, 1, 'Soft', '', 1, NULL),
(15, 1, 'Alcool', '', 1, NULL),
(16, 1, 'Cocktail', '', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `groupe_id` int(2) NOT NULL,
  `societe` varchar(50) NOT NULL,
  `siret` varchar(30) NOT NULL,
  `tvaintra` varchar(13) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `nom` varchar(50) NOT NULL COMMENT 'contact dans la société',
  `prenom` varchar(50) NOT NULL COMMENT 'contact dans la société',
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `date_naissance` date NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `remarques` text,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `mail` (`email`),
  KEY `groupe_client` (`groupe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `groupe_id`, `societe`, `siret`, `tvaintra`, `tel`, `nom`, `prenom`, `email`, `password`, `date_naissance`, `actif`, `remarques`) VALUES
(1, 1, 'TEWA', '79405911300033', 'FR38794059113', '0970900005', 'DIALLO', 'Ahmed', 'as.diallo@tewa.io', '2da71dc1a218f3bc514f65f36708dfbf', '1984-11-01', 1, NULL),
(2, 1, 'TEWA', '79405911300033', 'FR38794059113', '0651136967', 'FAYADAS', 'Alexandre', 'alexandre.fayadas@gmail.com', 'dc95fd96d4440c28b5d099ab4f46f7fe', '1997-12-13', 1, ''),
(3, 3, 'TEWA', '79405911300033', 'FR38794059113', '0970900005', 'M', 'Matthieu', 'm.commercial@tewa.io', '2da71dc1a218f3bc514f65f36708dfbf', '1996-11-01', 1, NULL),
(4, 4, 'TEWA', '79405911300033', 'FR38794059113', '0970900005', 'M', 'Mickael', 'm.graphiste@tewa.io', '2da71dc1a218f3bc514f65f36708dfbf', '1990-06-10', 1, NULL),
(6, 1, 'TEWA', '', '', '0651136967', 'YACINE', 'Yacine', 'yacine@test.fr', 'cd6d23acdb89da59592a08b765df5136', '1991-03-01', 1, 'dd');

-- --------------------------------------------------------

--
-- Structure de la table `_lignecommande`
--

DROP TABLE IF EXISTS `_lignecommande`;
CREATE TABLE IF NOT EXISTS `_lignecommande` (
  `lignecommande_id` int(12) NOT NULL AUTO_INCREMENT,
  `commande_id` int(15) NOT NULL,
  `produit_id` int(5) NOT NULL,
  `qte` mediumint(9) NOT NULL,
  PRIMARY KEY (`lignecommande_id`),
  KEY `FK_CommandLine_Command` (`commande_id`),
  KEY `FK_CommandLine_Product` (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `_lignecommande`
--

INSERT INTO `_lignecommande` (`lignecommande_id`, `commande_id`, `produit_id`, `qte`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 12),
(3, 2, 1, 1),
(4, 3, 2, 1),
(5, 4, 1, 13),
(6, 4, 2, 6),
(7, 4, 1, 5);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `FK_Command_User` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `FK_Product_Subcategory` FOREIGN KEY (`souscategorie_id`) REFERENCES `souscategories` (`souscategorie_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `souscategories`
--
ALTER TABLE `souscategories`
  ADD CONSTRAINT `FK_Subcategory_Category` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`categorie_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_User_Group` FOREIGN KEY (`groupe_id`) REFERENCES `groupes` (`groupe_id`);

--
-- Contraintes pour la table `_lignecommande`
--
ALTER TABLE `_lignecommande`
  ADD CONSTRAINT `FK_CommandLine_Command` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`commande_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CommandLine_Product` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`produit_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
