-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 08 jan. 2019 à 02:29
-- Version du serveur :  5.7.19
-- Version de PHP :  7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db-piscine`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `mailAdmin` varchar(25) NOT NULL,
  `mdpAdmin` text NOT NULL,
  `mailVendeur` varchar(25) DEFAULT NULL,
  `coefficientPointsEuros` double DEFAULT NULL,
  `daysBeforeDestroyingPoints` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`mailAdmin`, `mdpAdmin`, `mailVendeur`, `coefficientPointsEuros`, `daysBeforeDestroyingPoints`) VALUES
('cci@gmail.com', '$2y$10$3oVR9MR6GseYUtwQTFjHQO6bN52nkRqAWdvIjzTrvvkHGDNGDBJMq', 'vendeur@gmail.com', 0.5, 14);

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

CREATE TABLE `appartenir` (
  `numSiretCommerce` char(14) NOT NULL,
  `mailVendeur` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `appartenir`
--

INSERT INTO `appartenir` (`numSiretCommerce`, `mailVendeur`) VALUES
('11111111111111', 'j@k.mail'),
('11111111111111', 'pepito24@yahoo.fr'),
('11111111111111', 'vendeur@gmail.com'),
('12345677654321', 'j@k.mail'),
('12345677654321', 'vendeur@gmail.com'),
('22222222222222', 'vendeur@gmail.com'),
('44444444444444', 'cci@gmail.com'),
('55555555555555', 'vendeur@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `numAvis` int(11) NOT NULL,
  `commentaireAvis` varchar(255) NOT NULL,
  `noteAvis` char(1) NOT NULL,
  `dateAvis` date NOT NULL,
  `numProduit` int(11) NOT NULL,
  `mailClient` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`numAvis`, `commentaireAvis`, `noteAvis`, `dateAvis`, `numProduit`, `mailClient`) VALUES
(1, 'Excellent', '8', '2018-11-22', 5, 'r@g.com'),
(2, 'vraiment nul', '1', '2019-01-07', 1, 'r@gmail.com'),
(3, 'Passable', '6', '2019-01-24', 5, 'h@g.gmail');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `mailClient` varchar(100) NOT NULL,
  `nomClient` varchar(20) NOT NULL,
  `prenomClient` varchar(20) NOT NULL,
  `mdpClient` text NOT NULL,
  `adresseClient` varchar(80) NOT NULL,
  `villeClient` varchar(30) NOT NULL,
  `codePostalClient` char(5) NOT NULL,
  `telClient` text NOT NULL,
  `sexeClient` char(5) NOT NULL,
  `dateNaissanceClient` date NOT NULL,
  `idClient` int(5) NOT NULL,
  `produit1` int(11) DEFAULT NULL,
  `produit2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`mailClient`, `nomClient`, `prenomClient`, `mdpClient`, `adresseClient`, `villeClient`, `codePostalClient`, `telClient`, `sexeClient`, `dateNaissanceClient`, `idClient`, `produit1`, `produit2`) VALUES
('a@gmail.com', 'b', 'bahroun', '$2y$10$3oVR9MR6GseYUtwQTFjHQO6bN52nkRqAWdvIjzTrvvkHGDNGDBJMq', 'zqohqfohoqf', 'qvnqlkknv', '37000', '0685404708', 'male', '1999-03-03', 1, NULL, NULL),
('bob@gmail.com', 'bobi', 'bobo', '$2y$10$igurwSKBXU7/2C5Z.zt7GuDfBEqX4MqMil5f22c8N46iGvfFH/9va', '18 quai de la Daurade', 'Sètes', '34200', '06', 'male', '1666-05-25', 6, NULL, NULL),
('r@gmail.com', 'rayan', 'bahroun', '$2y$10$3oVR9MR6GseYUtwQTFjHQO6bN52nkRqAWdvIjzTrvvkHGDNGDBJMq', '75 Avenue Augustin Fliche', 'Montpellier', '34090', '0685404709', 'male', '1996-06-28', 2, 18, 20),
('zzz@g.com', 'b', 'bahroun', '$2y$10$YAY5R3Vi.JrQr4MH2M4Zl.3HtlJmkihvIiRsEYK4JNX4pPESD3j.a', '1 rue du Port Feu Hugon (esc C1 )', 'Tours', '37000', '06854047080', 'male', '0001-06-06', 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `numCommande` int(11) NOT NULL,
  `prixCommande` varchar(5) NOT NULL,
  `prixReduitCommande` varchar(5) DEFAULT NULL,
  `paiementEnLigne` tinyint(1) DEFAULT NULL,
  `dateCommande` timestamp NULL DEFAULT NULL,
  `numSiretCommerce` char(14) NOT NULL,
  `numPanier` int(11) NOT NULL,
  `etatCommande` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`numCommande`, `prixCommande`, `prixReduitCommande`, `paiementEnLigne`, `dateCommande`, `numSiretCommerce`, `numPanier`, `etatCommande`) VALUES
(33, '3.5', NULL, NULL, '2019-01-07 23:49:26', '11111111111111', 17, 'traitement'),
(34, '179.9', NULL, NULL, '2019-01-07 23:49:26', '12345677654321', 17, 'traitement'),
(35, '89.99', NULL, NULL, '2019-01-07 23:49:26', '22222222222222', 17, 'traitement'),
(36, '139.9', NULL, 0, '2019-01-07 23:52:13', '12345677654321', 18, 'traitement'),
(37, '89.99', NULL, 0, '2019-01-07 23:52:13', '22222222222222', 18, 'traitement'),
(38, '3', NULL, 0, '2019-01-07 23:52:13', '11111111111111', 18, 'traitement'),
(39, '419.8', NULL, 0, '2019-01-07 23:57:05', '12345677654321', 19, 'traitement'),
(40, '8', NULL, 0, '2019-01-07 23:57:05', '11111111111111', 19, 'traitement'),
(41, '3.85', NULL, NULL, '2019-01-08 00:00:51', '11111111111111', 20, 'traitement'),
(42, '2', NULL, NULL, '2019-01-08 00:02:33', '11111111111111', 21, 'traitement'),
(43, '89.99', NULL, NULL, '2019-01-08 00:02:33', '22222222222222', 21, 'traitement'),
(44, '1.5', NULL, 0, '2019-01-08 00:04:12', '11111111111111', 22, 'traitement'),
(45, '1539', NULL, 0, '2019-01-08 00:05:20', '12345677654321', 23, 'traitement'),
(46, '2250', NULL, 0, '2019-01-08 00:07:45', '22222222222222', 24, 'traitement');

-- --------------------------------------------------------

--
-- Structure de la table `commerces`
--

CREATE TABLE `commerces` (
  `numSiretCommerce` char(14) NOT NULL,
  `nomCommerce` varchar(50) NOT NULL,
  `libelleCommerce` varchar(255) DEFAULT NULL,
  `adresseCommerce` varchar(80) NOT NULL,
  `villeCommerce` varchar(30) NOT NULL,
  `codePostalCommerce` char(5) NOT NULL,
  `regionCommerce` varchar(25) NOT NULL,
  `telCommerce` char(10) NOT NULL,
  `codeReduction` varchar(10) DEFAULT NULL,
  `codeRecrutement` varchar(6) NOT NULL,
  `mailProprietaire` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commerces`
--

INSERT INTO `commerces` (`numSiretCommerce`, `nomCommerce`, `libelleCommerce`, `adresseCommerce`, `villeCommerce`, `codePostalCommerce`, `regionCommerce`, `telCommerce`, `codeReduction`, `codeRecrutement`, `mailProprietaire`) VALUES
('11111111111111', 'KFC', 'restauration rapide de poulet', '495 Avenue du Mas d\'Argelliers', 'Montpellier', '34000', 'Hérault', '0658957426', NULL, '123456', 'vendeur@gmail.com'),
('12345677654321', 'Adidas', 'marque de sport', '400 Avenue Claude Baillet', 'Nimes', '30000', 'Gard', '0559782356', '', '123123', 'vendeur@gmail.com'),
('22222222222222', 'Ikea', 'magasin spécialisé dans la conception et la vente de détail de mobilier et objets de décoration prêts à poser ou à monter en kit.', '1 Place de Troie', 'Montpellier', '34900', 'Hérault', '0775957595', NULL, '000000', 'vendeur@gmail.com'),
('55555555555555', 'Montpellier shop', 'Montepllier shop', '856 Rue d\'Alco', 'Montpellier', '34000', 'Hérault', '0685404708', NULL, '123456', 'vendeur@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `numReservation` int(11) NOT NULL,
  `numProduit` int(11) NOT NULL,
  `qteReservation` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`numReservation`, `numProduit`, `qteReservation`) VALUES
(25, 1, 2),
(27, 1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `coupons`
--

CREATE TABLE `coupons` (
  `codeCoupon` varchar(10) NOT NULL,
  `numSiretCommerce` varchar(14) DEFAULT NULL,
  `nomTypeProduit` text,
  `numProduit` int(11) DEFAULT NULL,
  `valeur` double DEFAULT NULL,
  `valeurPourcentage` double DEFAULT NULL,
  `dateLimite` timestamp NULL DEFAULT NULL,
  `quantiteMax` int(11) DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `coupons`
--

INSERT INTO `coupons` (`codeCoupon`, `numSiretCommerce`, `nomTypeProduit`, `numProduit`, `valeur`, `valeurPourcentage`, `dateLimite`, `quantiteMax`, `description`) VALUES
('1892', '55555555555555', 'Vêtements', NULL, NULL, 5, '2019-01-31 11:00:00', NULL, 'SOLDE'),
('86485', '12345677654321', NULL, 20, 5, 25, '2019-01-31 11:00:00', NULL, '54'),
('zer', '12345677654321', 'Chaussure', NULL, 0, 0, '2019-01-17 11:00:00', NULL, 'erg');

-- --------------------------------------------------------

--
-- Structure de la table `detenir`
--

CREATE TABLE `detenir` (
  `numCommande` int(11) NOT NULL,
  `numProduit` int(11) NOT NULL,
  `livrer` tinyint(1) DEFAULT NULL,
  `qteCommande` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `detenir`
--

INSERT INTO `detenir` (`numCommande`, `numProduit`, `livrer`, `qteCommande`) VALUES
(33, 1, 1, '1'),
(33, 6, 1, '1'),
(34, 20, 0, '1'),
(35, 5, 0, '1'),
(36, 21, 1, '1'),
(37, 5, 1, '1'),
(38, 2, 1, '1'),
(39, 21, 0, '3'),
(40, 1, 1, '4'),
(41, 3, 0, '1'),
(41, 6, 1, '1'),
(42, 1, 1, '1'),
(43, 5, 0, '1'),
(44, 6, 1, '1'),
(45, 21, 1, '11'),
(46, 7, 0, '25');

-- --------------------------------------------------------

--
-- Structure de la table `inclure`
--

CREATE TABLE `inclure` (
  `numTag` int(11) NOT NULL,
  `numProduit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `jours`
--

CREATE TABLE `jours` (
  `numJour` int(1) NOT NULL,
  `nomJour` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `jours`
--

INSERT INTO `jours` (`numJour`, `nomJour`) VALUES
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi'),
(6, 'Samedi'),
(7, 'Dimanche');

-- --------------------------------------------------------

--
-- Structure de la table `ouvrir`
--

CREATE TABLE `ouvrir` (
  `numOuvrir` int(11) NOT NULL,
  `nomJour` varchar(8) NOT NULL,
  `numSiretCommerce` char(14) NOT NULL,
  `debut` text NOT NULL,
  `fin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ouvrir`
--

INSERT INTO `ouvrir` (`numOuvrir`, `nomJour`, `numSiretCommerce`, `debut`, `fin`) VALUES
(1, 'Lundi', '11111111111111', '10:00', '12:00'),
(4, 'Mercredi', '11111111111111', '08:00', '20:00'),
(5, 'Jeudi', '11111111111111', '08:00', '20:00'),
(6, 'Samedi', '11111111111111', '10:00', '20:00'),
(9, 'Mardi', '11111111111111', '08:00', '20:00'),
(11, 'Lundi', '11111111111111', '13:00', '20:00'),
(12, 'Lundi', '12345677654321', '08:00', '18:00'),
(13, 'Mardi', '12345677654321', '08:00', '18:00'),
(14, 'Mercredi', '12345677654321', '08:00', '18:00'),
(15, 'Vendredi', '12345677654321', '08:00', '18:00'),
(16, 'Samedi', '12345677654321', '07:00', '21:00'),
(17, 'Lundi', '22222222222222', '10:00', '12:00'),
(18, 'Lundi', '22222222222222', '14:00', '18:00'),
(19, 'Vendredi', '22222222222222', '08:00', '20:00'),
(20, 'Jeudi', '22222222222222', '10:00', '18:00'),
(22, 'Mardi', '55555555555555', '08:00', '19:00'),
(23, 'Mercredi', '55555555555555', '08:00', '19:00'),
(24, 'Jeudi', '55555555555555', '08:00', '19:00'),
(25, 'Lundi', '55555555555555', '08:00', '19:00'),
(26, 'Vendredi', '55555555555555', '08:00', '19:00'),
(27, 'Samedi', '55555555555555', '09:00', '18:00');

-- --------------------------------------------------------

--
-- Structure de la table `paniers`
--

CREATE TABLE `paniers` (
  `numPanier` int(11) NOT NULL,
  `datePanier` timestamp NULL DEFAULT NULL,
  `prixPanier` double NOT NULL,
  `prixReduitPanier` varchar(5) DEFAULT NULL,
  `qtePointsAcquis` varchar(5) DEFAULT NULL,
  `mailClient` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `paniers`
--

INSERT INTO `paniers` (`numPanier`, `datePanier`, `prixPanier`, `prixReduitPanier`, `qtePointsAcquis`, `mailClient`) VALUES
(17, '2019-01-07 23:49:26', 273.44, NULL, '40.8', 'bob@gmail.com'),
(18, '2019-01-07 23:52:13', 232.94, NULL, '34.9', 'bob@gmail.com'),
(19, '2019-01-07 23:57:05', 427.84999999999997, NULL, '43.2', 'bob@gmail.com'),
(20, '2019-01-08 00:00:51', 3.85, NULL, '0.5', 'bob@gmail.com'),
(21, '2019-01-08 00:02:33', 91.99, NULL, '13.7', 'bob@gmail.com'),
(22, '2019-01-08 00:04:12', 1.5, NULL, '0.2', 'bob@gmail.com'),
(23, '2019-01-08 00:05:20', 1539.4499999999998, NULL, '230.9', 'bob@gmail.com'),
(24, '2019-01-08 00:07:45', 2249.75, NULL, '225.0', 'bob@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `numProduit` int(11) NOT NULL,
  `nomProduit` varchar(50) NOT NULL,
  `libelleProduit` text NOT NULL,
  `noteMoyenne` double DEFAULT NULL,
  `qteStockProduit` int(10) NOT NULL,
  `qteStockDispoProduit` int(10) NOT NULL,
  `livraisonProduit` tinyint(1) NOT NULL,
  `prixProduit` varchar(10) NOT NULL,
  `numSiretCommerce` char(14) NOT NULL,
  `nomTypeProduit` varchar(25) NOT NULL,
  `couleurProduit` text,
  `tailleProduit` text,
  `marqueProduit` text,
  `numGroupeVariante` int(11) NOT NULL,
  `imageProduit` text,
  `dateProduit` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`numProduit`, `nomProduit`, `libelleProduit`, `noteMoyenne`, `qteStockProduit`, `qteStockDispoProduit`, `livraisonProduit`, `prixProduit`, `numSiretCommerce`, `nomTypeProduit`, `couleurProduit`, `tailleProduit`, `marqueProduit`, `numGroupeVariante`, `imageProduit`, `dateProduit`) VALUES
(1, 'wings', 'aile de poulet frit', NULL, 141, 131, 1, '2', '11111111111111', 'Nourriture', NULL, NULL, NULL, 1, 'data:image/jpeg;base64,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', '2019-01-07 11:55:02'),
(2, 'tenders', 'filet de poulet frit', NULL, 304, 304, 0, '3', '11111111111111', 'Nourriture', NULL, NULL, NULL, 2, 'http://allopizza77.fr/emporter/88-large_default/tenders.jpg', '2019-01-07 11:55:02'),
(3, 'pilon', 'partie inférieur de la cuisse de poulet', NULL, 129, 129, 0, '2.35', '11111111111111', 'Nourriture', NULL, NULL, NULL, 3, 'data:image/jpeg;base64,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Vbpe2QoNRW7K3GPZPprVVYpvo/nvNcLTZ5iSHNIIcDsRttzlXuR8SUcTTLa5ZSqjYv8AKHiNxO53sFucx+zbDVTJdU3mJH5WVZxF9lFCrTpMw4ZR0v1Pc4OcXN0kR3M391nf8KUo4n/U1ZfIV7swITqtL7qxmvV4jvKBe4Mn0tyUU46l/LbuIm97fR9lXYzhSpga7KPiVKjNGtjjIbqJIc1okgQGt91YGiGuZDQS65jl1JVK6vxvYaGmlGcd79n1XxAL4EBwAm1o5GP8qOcTUefCIADnNAPUEgEzyuv3G1C93lAEQB3vur3g7h17n6qpJaDII+XlC6o083JcHF91ca28kPC8C16LjopNeHEkEOb5bCxDiO62eT8M0meHVew+K3aXkhp7AWWhAX6tyOngpbj5Z8vICIinAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAedai1whzQ4dCAR7FRv/AMulyptb6AD9FNRcuKfaOlKS6ZWjI6Ez4YKn06YaIaAB0C+0XqSR45N9hERengREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAf//Z', '2019-01-07 11:55:02'),
(5, 'table ikluflux', 'table 200cm x 80 cm x 100 cm', NULL, 31, 31, 0, '89.99', '22222222222222', 'Meuble', 'marron', '200x80x100', NULL, 4, 'data:image/jpeg;base64,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', '2019-01-07 11:55:02'),
(6, 'frites', 'barquette de frites', NULL, 103, 94, 1, '1.5', '11111111111111', 'Nourriture', NULL, 'petite', NULL, 5, 'data:image/jpeg;base64,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', '2019-01-07 11:55:02'),
(7, 'table ikluflux', 'table 200cm x 80 cm x 100 cm', NULL, -7, -7, 0, '89.99', '22222222222222', 'Meuble', 'bleu', '200x80x100', NULL, 4, 'data:image/jpeg;base64,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', '2019-01-07 11:55:02'),
(14, 'table ikluflux', 'table 200cm x 80 cm x 100 cm', NULL, 44, 44, 0, '89.99', '22222222222222', 'Meuble', 'rouge', '200x80x100', NULL, 4, 'data:image/jpeg;base64,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', '2019-01-07 11:55:02'),
(16, 'frites', 'barquette de frites', NULL, 106, 97, 1, '2', '11111111111111', 'Nourriture', NULL, 'moyenne', NULL, 5, 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxITEhUTExIVFRUWGBcXFRUVGBgVFhgZGBgWFhgYFRcYHSggGB0lGxgXIjEiJSkrLi4uGB8zODMtNygtLisBCgoKDg0OGhAQGy0mICIvLS0yMDItLS0tKy8tLS8rLS0vLS0uLS0vLS0uLysvLS0tLS0tLS8vLS0tLS0tLS0tLf/AABEIAPQAzgMBIgACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAABAUCAwYBB//EAD0QAAECAwUGBQIFAgQHAAAAAAEAAgMRIQQFMUFREmFxgZHwBiKhscEy0RNCUuHxFCMHcpLiJENiorLC0v/EABoBAQACAwEAAAAAAAAAAAAAAAAEBQECAwb/xAAuEQACAQMDAwIEBgMAAAAAAAAAAQIDBBESITEFIkETcVGBwfAUMpGh0eEjM0L/2gAMAwEAAhEDEQA/APuKIiAIiIAiIgCxiPAEyslXXpEBBGgMxyH3C43FX0qbkbQjqeDWb7bKeyZa0KsYEUPaHCoIBHNcG2Oaz14LpLotbYdm23UAJ58OiqOn9RqVJtVXtjPtgn3NooRTjznBcxIgbiQOKyBXzC9fEDosYzaQ3ATNAMl1Xg20veHzcS0S2Qd+/kpVDqSq1vTUdnw/5Nati6dLW38jplSxr4aHkTkeoVpGjSMl8+vSIS9x34rj1W8lSSjTe/kxZW6qt6jtrPeYds1FZbvvu0Vivn91RjtNB/U33C79uC7dMup14PX4waXdBUZJLyRL1iShO3iXVQbhvBzyWOM5Ya8ysfEMbBs1W3M/YitJoKgniD8qFWu5K/WHssI606Kdu355OuRRbNeEN5k11dDQ8pqUr2FSNRZg8ogyi4vDQREW5qEREAREQBERAEREAREQBUd+v2Q9w0HwrxUHiR+yH72j3koHUv8AQ/vwyRarNRI5ZtomahT7a7/g2CeMR3IVp1kq1kuQUyKWmztFZh7idJlrMNc/VeXoPaft9UXlVLVH3+jOetEORpXv+V9B8FQZWcO/USelKc5jkuDeJE99/uV9Fgj8CxtGBbDE+JxwzmSrPpeNcqkuIr7+pH6g/wDGoLyyJbrZ9bhnRum4jWi5m3AbRl0UqPGJLdJz6lRrYyryMs+NPuqurVdSbk/vJ1oU1TwiFYr1YIgaaN2tnbyEjLaLsA2a72N4iszRMRGmeEvnRfM7fDnCIBxnULVGueJBiNgvdUgOa4fSW5nlWasLW4nRpydNfA6XFrSrSWp45+Z2F4XqyJEABqRhjLn6rJr9gtNM5egqO81WvsLAyUztSoRPTEqayE1sMAH6WBo1LvsobTcnJ8vf6nNxgoqMeODBses+Nc61XWXHazEh1My0yJ5AjjRcarzwvav7j2ZOExxGnVS+l1HCul4exwvKalTbXg2+Io5/EYA8t2ROYJFTTLh6rfc17Oe8Q3SdQkPG7UKjvWPtxXOynTOgoFY+FYfncdBTmtqFzUlevS9nL9l/SNKlKMbfdbpHTIiL05UBERAEREAREQBERAVniOKWwHEEA0kTxEvWS5i23oYrPMKyAJGcicRku0tcHbY5uo6b1xLIAE2E1BIPHP2VR1JyjJb7NY+/1LC00uL23TyVpdKnRTnD+wzhPmZlQLfALDqPZTHPBgM12R0kKqgUMOX35LST2j7kCyQtuKxo/M5oluJAXS+I72Y6UFhnsnzUzFBI6Y+i5b8QsdtNMnDAjIyNRvUK4S6KazJcSZnGQqa9VIp1XChKC5ljPsYnSU5qbe0To4Nme6R8onUbRy1A0W21WYidWmZnQ/BXsS0u23E6+gUC8LbNjhqO+UlAjJa9KMpTk0yhtcUthuniA44cT0XTWq2GNEDAyf4bBtOkAA9wFJ8Bhw0VBY7ij2tpIc1jPp2nzM9Q1ox4mS7G7bkEFhaYoe9xJJ2SKkAGszop0IS0Z8C5q00+e5fUhRYLg0E4ZkVUaDHFZZ+iuoljP0zbI8VzVtimG4sI8wxNBPQ9FpNNHOlLWSnvkCtN23g5r9puIBlpORFVX2m8vKRLEKFd9qkZHWSU24vKOzp6ovJ0LLU0y4LpPCLwTEr+n5XCG07TiwCbp+UDEzw73LsfB927Di55nENZ5NkNnZbyfjmpXTaL/EKSWy/gi3rSpNHXIiL1BRhERAEREAREQBFBt9tdDIk0EHCsu8uoWqyXwHHZc0sNM5jqo07ujCeiTw/nj9eDoqM3HUlsYeJb5bZYJiHHBo1K+cXLfb7RtOiSLi9wLhTAzwyoQn+KF7bdo/DDpthgCU/zGpPwqDwVGDhFBMtp0wdC1tPhV9+3VTS4RZWlNQjl8s75uy9uw7DXNVlofsjYFNiYPD8vovbFHm0HPPUSW+3QtoBzPqwOU25g6/sqV7rDJsVpeGU8eLQlZ+DneeWkMgaVLP3US1xZtPBTPBTpxXn9MM8Kvb9ltFdrOs9oMtrSamW8T4qpvR4E9zTTXBW9qktdkit/CLS0OBcTIgOE5iRE8xIdFDi1GWWbReEmiyucGHAhNlUNG1/mPmdPmSpka1SKrHWuUzu9VBiWhziGirjgO8FIlUcVhcsiqlrk5Mn3he2yKGR/lUtsc6PEGxLa2ZPJwaJ0MsTnTsW0G6QZF5m4yl+ltchnLUqmuR20IkUDZEWKXNAODAS1gpSR8ztPMunco5kdKahvp8GFpsML8OI2pcASxxkHucKidZNGAAw1VFdrXueGhp2pyI4Yz0lqr+8nS8siTOQlWp1PIqVdNgbCBOLnmbnc57Ldw9cV3t6cqn5uDerVUI7eSddtjEOs9o1M6SE9mYbSdZDouq8Og+aYplzx9guegurwXUXC2UPj9yrq2ilJJeCmuG9O5ZoiKwIIREQBERAEREBotkDbaRnkuUiggkHFp0quyVNfdk/OOffr/Kq+pWvqR1rxz7f0S7Wrpel+Tk/EVzQ7ZDIMmxQPJFlUEYB/6m7ssQvnlw3fGgGJDjN2HEnBzX5E4sJANF9MdG2Sqi/bIX7MVgO02jmgTL2mgkM3AmfCapaVeUE6b4f7FpCG+SlsFrk7ZJMiZldBYYmOnTmsbnuGDCbtWhrYsU/lnNkMfpkDJztTllhMo7g0mVBkN2i5VNKex21auCJftnBYXAAOFTKYnu+VH8BMn/UOGTGN4zLj8Kxa8OntfdZ+G7D+C201BDntLSKU2QZciStoSzCWTE21HBlaTLotcF4DGDdM85n5XlrfjzWoxfo3MbPmAodOOWvc7f8AJIi+YAZkgDIc+8lYWaEyHMMqc3HE1ryVZZXkxoY/zOPIH5l1VmHAEz1NPspyjvkizbxgjX9azDssVw+osLWalz/I31IVFZrSIUINH5Who4ASTxfajKEyeL/xCM9ljSB/3PaeSgXf5yCfoZ6nIbwPsuipuphHSGIU8vyW9hYfrfVxwGgOXE6qxhEqBCdXnnmp8DGqsIJRWERJtyeWT4C7C6mShN4D2APqCuOs4yXb2RsmN4T61+VOtVu2QrnhG5ERTSGEREAREQBERAFi9oIkcCskRrIOGvqz/hOc0zli1VBtforb/Ea0mCWxCJsIDXSxYQaO4VkeRyK46xxxEa5wdMzoPU86jovLXlt6dRrwX1rLXBN8ku1XmdqU8Vri2kkUKqbzDpVaQcWk5rVYbbtDGRHNR40MLYmNrksrPeBnLqNOC6WyxB+DMH6nEnkJfC4C3Ry1wdrQ/ddfc79qywz/ANJcTxc4yHIhYqU2o5RieHgjXjagAd9FsheYFwwwHISHHD1Vfe9oaRLPLqtlnBa1ongMuvqtaMNsm1TaKRc3GNqLEfkxobzcZ+zVNtJGdKd4qsuSJKG92O3EJ/0gD3mot83oD5IdXfmdk0fJ3KVTjq2RDqfnKO+4v49oDGf8sSe+WE5GXfwrGyANAGQwCjQIQaJDObnOzJNSTvUoHuimxiorBrKWrbwTYb68vZT7Lrl3gq2F9sMqfwrGAanp91uc2WljB2hxHuu5YKDguMucExWAYzmOQJ912qn2q2bIFy90giIpZFCIiAIiIAiIgCIiA5Xx3BBYwkAzmCCJgiRBB3EuC+URLM+yzLCXQZzGrJy8r90xR2BnWuP2Lxkz+yDLOXL6j/4BfOI75SI7yPpkqy7inJp+Szs5tR2NFhtjIzSx2eRPsqO87udZ3lzTNh6iequ2Pa0ECG1u1UlgDScd0j0W11vYWFj9ojeB96qt9GUHtuieqqKIQDGIawF23TZG4VJOS7W67qDYEKC99WMDXS3CVJrmbniQbO9727RmJNaKATMyTM8BRaLdeMZ8UubELW/p2ZnATnVazozm9KWwdRfE6G97rgt2S0u2g4YnaBGfDXkoVoJDTnx8o9TKaqYlviOOPoOC1ujbRmSTpPDkFvTtpJdzMSrfMtDb5QmQm4geYigLneYyOJUMEDXvv0Wk+uqyapKjGPBxbbeWTIR/fvgt7N3clEhPFO8FNg6IwTYM6fxgrGzHPgoMIVHFTrO3vhPBZRqy/uCHOKOo5EH4K65c14aZ5yd1PZdKrK2XYVtw+8IiKQcAiIgCIiAIiIAiIgKrxPDnZ3aiRHH6fYlfLbY2pX1y9mzgvEp+Uy45L5PbWnfVQLtdyZPtH2tFXHJp2NVDj64qTH6dlRYpHNRMk3BiSPt7LQXz5ra47lpIr8dFsma4AMsCvWP1pgtYp37L3bQySg/+Vsb33w91Fa5SoT699FhmSVChin84qZB1r7TUSE2Uj0UyzHOW7+dFqCws9SrSzqsgFWMA4arKOcjrfDLaOMs5dAD/AOyvFVeHGShz1PrX4krVWtFYgirqvM2ERF1OYREQBERAEREAREQGq1ukxx0aTrgF8mvFtSKUJHKq+ukL5Re0OT3jAzPXNQ7xbJky0e7Oejj9uCimp/hT4ooaYY865KHFmMKKAWBGdTPgtL5rc44DJa3Np3wWxg0y7yWQyWMtCshj9u8KrJk2wRopEKlRxUeF3+ylQ++S1BNswnOm9TIbK71XwPbof3VpAPei1BLhAFWdl9sPRVkN0jSqsrMJLaJzkdzcjJQW76/Hwp60WJkobBhIBb1cQWIpFTN5kwiItjUIiIAiIgCIiAIiIAvm/iWCRGib3E9ZkL6QuF8WslFcZ4/wo10uzJJtX34OLjs1Om/WSgv7mFZx299MlXRWKtLMiRGY5cPRaJGve/viphd8fwtT5LJgjth8Jd4L0DGSyPz+yxANe96yDYBL1Uhnfqo7SdcsP3W+CaiqwZJUMTPoZdSplmiSOB70USHLTCpU2z5GUtywC1sjB3krGz/VLLA994KusisYJ64+62ic5H0CBPZbPGQnxks1CueOXwWOdjKROsqTU1XOMbFPnIREQBERAEREAREQBERAFx3jSFJ4OomT0HwuxXMeM4dGO3EdP5XG4XYztQeJo4GO3HvvBV0dhr6Zq0tDalV9oEhRVZaIhxWmXp33mtJot8Qd/stESQOs+6obGonXWct6xom8dF40csFkG0OC2Qx7e61shmZzW1gyp6rAJdncMye+yp8CWIyVbBbLviPup8GoosMFpZXd+iurrspiPDMJ548VS2Teus8MQ/7s9AfsutFZkjhWeIs6ezwQxoaMAJLYiK2KoIiIAiIgCIiAIiIAiJNAFQ+L4c4QOYJHUT+FezVV4laDANJkGi51V2M6UniaPnEdtff4VbFGneqtLUOyqq0FVLLVESJnqtL201w+y2xVpe4IbmkgDKqMGcu5I/Id802hwWTB76cFuZLvvctBJmsmPnId5LBkmNdkp0IyUCEwqbBGeNewtWC1sZrRdp4RZV50AHUn7LirFJd54RH9tztXS6D9ypNsszRFuX2MvkRFZlaEREAREQBEXhQCaTWJKwc5AZlyxL1ofEUeJHQEx0VQL2iAwnjco0a1qvj2/I50WsllMzF4aOVtvFVMc4q5vBnXcqeKelQqdlxEg2gU5d/KjES9VKiV4qK80Q2MDTDksGv95T9V6461WBbSXXXmsg2tfh3vWxgWgO0W1jq1z1WDJLhevdFNgnI95qC10uK2sO/s9+i1BcWM4d8l9F8MmUBu8k+q+bWR2C+gXRFlCYN0+tflTLNdzZDu32o6APWW0oEOMpDXqwK8kTXq1ByzBQGSLxeoDxYlZLwhAa3LU8reQtTmoCJFKgR3KziQ1DjQEBSWp5VJbIxXTWiyqqtVgnkgKy3xQ8FwMx7a0VFaW9+v3VxabsOImDuoqq0WCJqVAnaPPaybC6S/MivivCjRNyk2iyRP0j1UN0CIPycPN/tXP8PUXg7q5pvyYlwrPFaiZzXsWzvJ+krxlliaH3T0J/Az69P4nrCJ97lIY8futbLDE0+PhS4N2RT+Uf6j/wDOqx6E/gPXp/E9hVKktnlOXupVnuUnGauLJcw0nxWytZs1d3BcEO7bO5xlKgzK7GxmQA0kFGstilkrSBZlMo0VTRCq1nUZIguU2GVohQlKYxdjibGraFg1q2AID0L1F6gC8kvUQHkliWrNEBpLFrdCUmSSQEB9nWiJY1alqxLEBRRLuGiixLpGi6Yw1iYSA5J9yDRaXXCNF2RghY/gBAcWfD40XouAaLs/6cJ/ThAciy4hot8O5houoEAL0QUBQQ7rGilQ7ArcQl6IaAgMsi3MgKWGr3ZQGlsNZhq2SSSA8AXsl6iAIiIAiIgCIiAIiIAiIgCIiALySIgEkXqIAiIgCIiAIiIAiIgCIiAIiID/2Q==', '2019-01-07 11:55:02');
INSERT INTO `produits` (`numProduit`, `nomProduit`, `libelleProduit`, `noteMoyenne`, `qteStockProduit`, `qteStockDispoProduit`, `livraisonProduit`, `prixProduit`, `numSiretCommerce`, `nomTypeProduit`, `couleurProduit`, `tailleProduit`, `marqueProduit`, `numGroupeVariante`, `imageProduit`, `dateProduit`) VALUES
(17, 'frites', 'barquette de frites', NULL, 91, 77, 1, '2.5', '11111111111111', 'Nourriture', NULL, 'grande', NULL, 5, 'data:image/jpeg;base64,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', '2019-01-07 11:55:02'),
(20, 'CHAUSSURE ULTRABOOST LACELESS', 'Une chaussure sans lacets qui t\'offre un retour d\'energie infini dans tes runs urbains.', NULL, 41, 41, 0, '179.95', '12345677654321', 'Chaussure', 'noir', '40', 'Adidas', 13, 'https://assets.adidas.com/images/w_2000,h_2000,f_auto,q_90,fl_lossy/9b8559d7b6e2458c8804a9a401130406_9366/Chaussure_Ultraboost_Laceless_noir_B37685_01_standard.jpg', '2019-01-07 11:55:02'),
(21, 'CHAUSSURE NMD_R1', 'Une sneaker confortable agrémentée de détails rétro', NULL, 29, 29, 0, '139.95', '12345677654321', 'Chaussure', 'rouge', '41', 'Adidas', 11, 'https://assets.adidas.com/images/w_840,h_840,f_auto,q_90,fl_lossy/9c0c2f762cc342858886a9a5010223c6_9366/Chaussure_NMD_R1_gris_BD7742_01_standard.jpg', '2019-01-07 11:55:02'),
(22, 'CHAUSSURE NMD_R1', 'Une sneaker confortable agrémentée de détails rétro', NULL, 60, 60, 0, '139.95', '12345677654321', 'Chaussure', 'gris', '42', 'Adidas', 11, 'https://assets.adidas.com/images/w_840,h_840,f_auto,q_90,fl_lossy/9c0c2f762cc342858886a9a5010223c6_9366/Chaussure_NMD_R1_gris_BD7742_01_standard.jpg', '2019-01-07 11:55:02'),
(23, 'Chaussure WAW', 'Geox la chaussure qui respire', NULL, 100, 100, 0, '100', '12345677654321', 'Chaussure', 'gris', '41', 'Geox', 14, 'data:image/jpeg;base64,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', '2019-01-08 01:34:55'),
(24, 'NEBULA MAN', 'Baskets pour homme ultra-respirantes, innovantes et emblématiques, offrant un confort inédit. Nebula est un véritable concentré de technologie. La semelle en EVA est légère, souple et amortie.', NULL, 150, 150, 1, '150', '12345677654321', 'Chaussure', 'bleu', '42', 'Adidas', 15, 'https://www.geox.com/dw/image/v2/BCCR_PRD/on/demandware.static/-/Sites-masterCatalogGeox/default/dw63829db3/images/large/U74D7C0BS22C4002-100.jpg?sw=588', '2019-01-08 01:38:20'),
(25, 'Casquette de baseball à écusson', 'Cette casquette de baseball en pur coton donne un coup de frais à vos tenues décontractées. Elle est rehaussée d\'un écusson accrocheur.\r\n\r\nPoints forts\r\n\r\n• Pur coton\r\n• Écusson Tommy Hilfiger à l\'avant\r\n• Bouton en haut de la couronne\r\n• Sangle réglable\r\n• Bande emblématique sur la boucle à l\'arrière', NULL, 150, 150, 0, '60', '55555555555555', 'Vêtements', 'bleu', NULL, 'Tommy Hilfiger', 16, 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcQml32zLTgnBHQlMwKIsNj_OkswGLaNB-flOjkUAVjlnwTllJY7s_cG_jOkMWaWnSIrxxLkJggXZFI&usqp=CAc', '2019-01-08 01:45:58'),
(26, 'Paris Polo regular fit Lacoste en piqué de coton s', 'Col rehaussé, boutonnière dissimulée et nouvelle matière petit piqué stretch pour l\'audacieux Polo Paris, qui réinvente la silhouette du polo avec style et élégance pour toutes les occasions.\r\n\r\n    Piqué de coton stretch uni\r\n    Col chemise avec patte de boutonnage dissimulée\r\n    Regular fit : Coupe ajustée\r\n    Finitions bord-côte col et manches', NULL, 450, 450, 0, '100', '55555555555555', 'Vêtements', 'bleu', 'M', 'Lacoste', 17, 'https://image1.lacoste.com/dw/image/v2/AAQM_PRD/on/demandware.static/Sites-FR-Site/Sites-master/fr/dwad469a55/PH5522_SXY_24.jpg?sw=900&sh=900&sm=fit', '2019-01-08 01:52:38'),
(29, 'Paris Polo regular fit Lacoste en piqué de coton s', 'Col rehaussé, boutonnière dissimulée et nouvelle matière petit piqué stretch pour l\'audacieux Polo Paris, qui réinvente la silhouette du polo avec style et élégance pour toutes les occasions.\r\n\r\n    Piqué de coton stretch uni\r\n    Col chemise avec patte de boutonnage dissimulée\r\n    Regular fit : Coupe ajustée\r\n    Finitions bord-côte col et manches', NULL, 450, 450, 0, '100', '55555555555555', 'Vêtements', 'gris', 'M', 'Lacoste', 17, 'https://image1.lacoste.com/dw/image/v2/AAQM_PRD/on/demandware.static/Sites-FR-Site/Sites-master/fr/dwad469a55/PH5522_SXY_24.jpg?sw=900&sh=900&sm=fit', '2019-01-08 01:53:05'),
(30, 'Paris Polo regular fit Lacoste en piqué de coton s', 'Col rehaussé, boutonnière dissimulée et nouvelle matière petit piqué stretch pour l\'audacieux Polo Paris, qui réinvente la silhouette du polo avec style et élégance pour toutes les occasions.\r\n\r\n    Piqué de coton stretch uni\r\n    Col chemise avec patte de boutonnage dissimulée\r\n    Regular fit : Coupe ajustée\r\n    Finitions bord-côte col et manches', NULL, 450, 450, 0, '100', '55555555555555', 'Vêtements', 'rouge', 'M', 'Lacoste', 17, 'https://image1.lacoste.com/dw/image/v2/AAQM_PRD/on/demandware.static/Sites-FR-Site/Sites-master/fr/dwad469a55/PH5522_SXY_24.jpg?sw=900&sh=900&sm=fit', '2019-01-08 01:53:11'),
(31, 'Paris Polo regular fit Lacoste en piqué de coton s', 'Col rehaussé, boutonnière dissimulée et nouvelle matière petit piqué stretch pour l\'audacieux Polo Paris, qui réinvente la silhouette du polo avec style et élégance pour toutes les occasions.\r\n\r\n    Piqué de coton stretch uni\r\n    Col chemise avec patte de boutonnage dissimulée\r\n    Regular fit : Coupe ajustée\r\n    Finitions bord-côte col et manches', NULL, 450, 450, 0, '100', '55555555555555', 'Vêtements', 'bleu', 'S', 'Lacoste', 17, 'https://image1.lacoste.com/dw/image/v2/AAQM_PRD/on/demandware.static/Sites-FR-Site/Sites-master/fr/dwad469a55/PH5522_SXY_24.jpg?sw=900&sh=900&sm=fit', '2019-01-08 01:53:20'),
(32, 'Paris Polo regular fit Lacoste en piqué de coton s', 'Col rehaussé, boutonnière dissimulée et nouvelle matière petit piqué stretch pour l\'audacieux Polo Paris, qui réinvente la silhouette du polo avec style et élégance pour toutes les occasions.\r\n\r\n    Piqué de coton stretch uni\r\n    Col chemise avec patte de boutonnage dissimulée\r\n    Regular fit : Coupe ajustée\r\n    Finitions bord-côte col et manches', NULL, 450, 450, 0, '100', '55555555555555', 'Vêtements', 'bleu', 'L', 'Lacoste', 17, 'https://image1.lacoste.com/dw/image/v2/AAQM_PRD/on/demandware.static/Sites-FR-Site/Sites-master/fr/dwad469a55/PH5522_SXY_24.jpg?sw=900&sh=900&sm=fit', '2019-01-08 01:53:25'),
(33, 'Paris Polo regular fit Lacoste en piqué de coton s', 'Col rehaussé, boutonnière dissimulée et nouvelle matière petit piqué stretch pour l\'audacieux Polo Paris, qui réinvente la silhouette du polo avec style et élégance pour toutes les occasions.\r\n\r\n    Piqué de coton stretch uni\r\n    Col chemise avec patte de boutonnage dissimulée\r\n    Regular fit : Coupe ajustée\r\n    Finitions bord-côte col et manches', NULL, 450, 450, 0, '100', '55555555555555', 'Vêtements', 'bleu', 'XL', 'Lacoste', 17, 'https://image1.lacoste.com/dw/image/v2/AAQM_PRD/on/demandware.static/Sites-FR-Site/Sites-master/fr/dwad469a55/PH5522_SXY_24.jpg?sw=900&sh=900&sm=fit', '2019-01-08 01:53:31'),
(34, 'T-shirt col V slim fit en jersey de coton uni', 'Ce t-shirt col V aux finitions subtiles est confectionné en jersey de coton souple. Un essentiel élégant du vestiaire féminin de saison.\r\n\r\n    Col V avec finitions subtiles\r\n    Jersey de coton souple uni\r\n    Coupe très ajustée\r\n    Crocodile ton sur ton brodé rapporté poitrine\r\n    Coton (100%)', NULL, 50, 50, 1, '50', '55555555555555', 'Chaussure', 'Noir', 'M', 'Lacoste', 18, 'https://image1.lacoste.com/dw/image/v2/AAQM_PRD/on/demandware.static/Sites-FR-Site/Sites-master/fr/dw6efcd9cf/TF8908_031_24.jpg?sw=900&sh=900&sm=fit', '2019-01-08 01:56:11'),
(35, 'MALM', 'Avec son style épuré, ses tiroirs qui coulissent en douceur et son choix de finitions, cette commode trouvera sa place dans toutes les pièces !', NULL, 14, 14, 0, '29.90', '22222222222222', 'Meuble', 'gris', '40x55 cm', 'IKEA FAMILY', 19, 'https://www.ikea.com/fr/fr/images/products/malm-commode-tiroirs-noir__0651168_PE706780_S4.JPG', '2019-01-08 02:04:46'),
(36, 'FJÄLLBO', 'De style rustique, cette étagère en métal et bois massif rend chaque meuble unique.', NULL, 54, 54, 0, '119', '22222222222222', 'Meuble', NULL, '100x136 cm', NULL, 20, 'https://www.ikea.com/fr/fr/images/products/fjallbo-etagere-noir__0473388_PE614539_S4.JPG', '2019-01-08 02:06:28'),
(37, 'FJÄLLA', 'Avec son design classique et ses détails tels que les bords, le porte-étiquette et la poignée en métal, ce range-revues vous permet d\'organiser vos documents avec style. Il se combine parfaitement avec les autres produits FJÄLLA.', NULL, 1998, 1998, 1, '5.99', '22222222222222', 'Chaussure', 'gris', NULL, NULL, 23, 'https://www.ikea.com/fr/fr/images/products/fjalla-range-revues-gris__0562671_PE663591_S4.JPG', '2019-01-08 02:08:34');

-- --------------------------------------------------------

--
-- Structure de la table `reductions`
--

CREATE TABLE `reductions` (
  `numReduction` int(11) NOT NULL,
  `pointsReduction` double NOT NULL,
  `dateDebutReduction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateFinReduction` timestamp NULL DEFAULT NULL,
  `mailClient` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reductions`
--

INSERT INTO `reductions` (`numReduction`, `pointsReduction`, `dateDebutReduction`, `dateFinReduction`, `mailClient`) VALUES
(1, 0, '2018-11-22 21:43:42', '2018-12-05 23:00:00', 'r@gmail.com'),
(2, 443, '2018-12-06 21:40:04', '2019-01-22 00:07:45', 'bob@gmail.com'),
(3, 0, '2019-01-10 10:28:11', '2019-01-09 23:00:00', 'jean@hotmail.fr'),
(5, 0, '2019-01-10 10:53:27', '2019-01-09 23:00:00', 'zz@gmail.com'),
(6, 0, '2019-01-10 10:57:45', '2019-01-09 23:00:00', 'zzz@g.com');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `numReservation` int(11) NOT NULL,
  `dateReservation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mailClient` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`numReservation`, `dateReservation`, `mailClient`) VALUES
(6, '2018-11-17 01:57:37', 'r@g.com'),
(7, '2018-11-17 23:22:48', 'r@g.com'),
(8, '2018-11-17 23:23:27', 'r@g.com'),
(9, '2018-11-18 14:07:31', 'r@g.com'),
(10, '2018-11-18 14:09:42', 'r@g.com'),
(23, '2018-11-20 10:41:51', 'r@g.com'),
(24, '2018-11-20 10:51:43', 'r@g.com'),
(25, '2018-11-20 15:00:16', 'r@g.com'),
(26, '2018-12-13 19:31:38', 'r@g.com'),
(27, '2018-12-13 20:05:50', 'r@g.com'),
(28, '2019-01-03 15:22:12', 'r@gmail.com'),
(29, '2019-01-05 01:23:45', 'r@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `numTag` int(11) NOT NULL,
  `nomTag` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `typeproduits`
--

CREATE TABLE `typeproduits` (
  `nomTypeProduit` varchar(255) NOT NULL,
  `tempsReservation` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typeproduits`
--

INSERT INTO `typeproduits` (`nomTypeProduit`, `tempsReservation`) VALUES
('Beauté', '453'),
('Chaussure', '96'),
('Electroménager', '400'),
('High-tech', '541'),
('Livre', '1000'),
('Meuble', '96'),
('Nourriture', '1'),
('Sport', '150'),
('Vêtements', '150');

-- --------------------------------------------------------

--
-- Structure de la table `variantes`
--

CREATE TABLE `variantes` (
  `numGroupeVariante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `variantes`
--

INSERT INTO `variantes` (`numGroupeVariante`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23);

-- --------------------------------------------------------

--
-- Structure de la table `vendeurs`
--

CREATE TABLE `vendeurs` (
  `mailVendeur` varchar(100) NOT NULL,
  `nomVendeur` varchar(20) NOT NULL,
  `prenomVendeur` varchar(20) NOT NULL,
  `mdpVendeur` char(60) NOT NULL,
  `telVendeur` char(10) NOT NULL,
  `idVendeur` int(11) NOT NULL,
  `commerceFavori` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vendeurs`
--

INSERT INTO `vendeurs` (`mailVendeur`, `nomVendeur`, `prenomVendeur`, `mdpVendeur`, `telVendeur`, `idVendeur`, `commerceFavori`) VALUES
('cci@gmail.com', 'cci', 'cci', '$2y$10$NETz7trIS..vuVMKYvUXVOSfvgFEWuO5McPs01Nhuqc1PwqAr0tA2', '0433103310', 27, NULL),
('g@b.com', 'Ca', 'Lucas', '$2y$10$hfsrv1Loo.HC5MuzaKDGNebwjU0ibZL29KnbdSDjR7J/apQJra0a2', '0605040102', 31, NULL),
('gaston@gmail.com', 'gaston', 'gas', '$2y$10$JeHbpxonqpKzUGDa7uN0g.dqeuUpfY946f.Zz7w4CZGZlQXKBtZXK', '0788954123', 30, NULL),
('j@k.mail', 'BO', 'Lucas', '$2y$10$bQnX/diPDijZpU.QsqumHeEML972yPs6.Y9.FqiLd4G0eaM0I/5.a', '0609080302', 32, '12345677654321'),
('mathieu@gmail.com', 'r', 'r', '$2y$10$g8X9Vsug0fic9zBBurg/A.T/4j/4NwW9S1tuar1crwJMWP0YffrKW', '0685404708', 1, NULL),
('pepito24@yahoo.fr', 'pepito', 'aïe', '$2y$10$mVE932fpgExRzJce7ajxme2SfZnoRGI3GnpKzndPspms4xflKiZ2a', '0150426988', 2, NULL),
('vdd@gmail.com', 'vdd', 'vdd', '$2y$10$7OoagxKe1bTnbAl/v9XgUOoxgR9.Z/HqB9k9zIjiIJ/xygMsdgr2.', '0202020202', 28, NULL),
('vendeur@gmail.com', 'Toulino', 'David', '$2y$10$uK/2emyMVyUAG7FiiaIHdekKZ6QIysZPw0fMvYZOsdgluIX4GLZLC', '0685404707', 3, '12345677654321');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`mailAdmin`);

--
-- Index pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD PRIMARY KEY (`numSiretCommerce`,`mailVendeur`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`numAvis`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`mailClient`),
  ADD KEY `ID` (`idClient`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`numCommande`);

--
-- Index pour la table `commerces`
--
ALTER TABLE `commerces`
  ADD PRIMARY KEY (`numSiretCommerce`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`numReservation`,`numProduit`),
  ADD KEY `contenir_produits0_FK` (`numProduit`);

--
-- Index pour la table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`codeCoupon`);

--
-- Index pour la table `detenir`
--
ALTER TABLE `detenir`
  ADD PRIMARY KEY (`numCommande`,`numProduit`);

--
-- Index pour la table `inclure`
--
ALTER TABLE `inclure`
  ADD PRIMARY KEY (`numTag`,`numProduit`);

--
-- Index pour la table `jours`
--
ALTER TABLE `jours`
  ADD PRIMARY KEY (`numJour`);

--
-- Index pour la table `ouvrir`
--
ALTER TABLE `ouvrir`
  ADD PRIMARY KEY (`numOuvrir`);

--
-- Index pour la table `paniers`
--
ALTER TABLE `paniers`
  ADD PRIMARY KEY (`numPanier`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`numProduit`);

--
-- Index pour la table `reductions`
--
ALTER TABLE `reductions`
  ADD PRIMARY KEY (`numReduction`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`numReservation`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`numTag`);

--
-- Index pour la table `typeproduits`
--
ALTER TABLE `typeproduits`
  ADD PRIMARY KEY (`nomTypeProduit`);

--
-- Index pour la table `variantes`
--
ALTER TABLE `variantes`
  ADD PRIMARY KEY (`numGroupeVariante`);

--
-- Index pour la table `vendeurs`
--
ALTER TABLE `vendeurs`
  ADD PRIMARY KEY (`mailVendeur`),
  ADD KEY `ID` (`idVendeur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `numAvis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `idClient` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `numCommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `jours`
--
ALTER TABLE `jours`
  MODIFY `numJour` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `ouvrir`
--
ALTER TABLE `ouvrir`
  MODIFY `numOuvrir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `paniers`
--
ALTER TABLE `paniers`
  MODIFY `numPanier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `numProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `reductions`
--
ALTER TABLE `reductions`
  MODIFY `numReduction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `numReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `numTag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `variantes`
--
ALTER TABLE `variantes`
  MODIFY `numGroupeVariante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `vendeurs`
--
ALTER TABLE `vendeurs`
  MODIFY `idVendeur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_produits0_FK` FOREIGN KEY (`numProduit`) REFERENCES `produits` (`numProduit`),
  ADD CONSTRAINT `contenir_reservations_FK` FOREIGN KEY (`numReservation`) REFERENCES `reservations` (`numReservation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
