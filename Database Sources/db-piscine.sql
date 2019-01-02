-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mer. 02 jan. 2019 à 01:10
-- Version du serveur :  10.2.3-MariaDB-log
-- Version de PHP :  7.1.1

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
  `mailVendeur` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`mailAdmin`, `mdpAdmin`, `mailVendeur`) VALUES
('cci@gmail.com', '$2y$10$3oVR9MR6GseYUtwQTFjHQO6bN52nkRqAWdvIjzTrvvkHGDNGDBJMq', 'vendeur@gmail.com');

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
('11111111111111', 'pepito24@yahoo.fr'),
('11111111111111', 'vendeur@gmail.com'),
('12345677654321', 'vendeur@gmail.com'),
('22222222222222', 'vendeur@gmail.com'),
('44444444444444', 'cci@gmail.com');

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
(1, 'Excellent', '8', '2018-11-22', 5, 'r@g.com');

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
  `numReduction` int(11) DEFAULT NULL,
  `sexeClient` char(5) NOT NULL,
  `dateNaissanceClient` date NOT NULL,
  `idClient` int(5) NOT NULL,
  `remember_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`mailClient`, `nomClient`, `prenomClient`, `mdpClient`, `adresseClient`, `villeClient`, `codePostalClient`, `telClient`, `numReduction`, `sexeClient`, `dateNaissanceClient`, `idClient`, `remember_token`) VALUES
('a@gmail.com', 'b', 'bahroun', '$2y$10$3oVR9MR6GseYUtwQTFjHQO6bN52nkRqAWdvIjzTrvvkHGDNGDBJMq', '1 rue du Port Feu Hugon (esc C1 )', 'Tours', '37000', '0685404708', NULL, 'male', '1999-03-03', 1, 'JhJGbkkds6kHylaNzoy637WpdC2dipotGRXujTDLBhs0Y78qkcEx1FZeRRbB'),
('bob@gmail.com', 'bobi', 'bobo', '$2y$10$igurwSKBXU7/2C5Z.zt7GuDfBEqX4MqMil5f22c8N46iGvfFH/9va', '15 rue', 'Toulouse', '15000', '06', NULL, 'male', '1666-05-25', 6, NULL),
('r@gmail.com', 'rayan', 'bahroun', '$2y$10$3oVR9MR6GseYUtwQTFjHQO6bN52nkRqAWdvIjzTrvvkHGDNGDBJMq', '75 Avenue Augustin Fliche', 'Montpellier', '34090', '0685404709', NULL, 'male', '1996-06-28', 2, 'MdibomA3Nvmy7OQbfhQCphSVhPHSaWnYby8ZgUoq34Nd4qFhD2iF2p1JA2Am'),
('zzz@g.com', 'b', 'bahroun', '$2y$10$YAY5R3Vi.JrQr4MH2M4Zl.3HtlJmkihvIiRsEYK4JNX4pPESD3j.a', '1 rue du Port Feu Hugon (esc C1 )', 'Tours', '37000', '06854047080', NULL, 'male', '0001-06-06', 11, 'nLIof9zEWQwodLyu9qm7CjHYedYRWIxLlT89ktdhTmw4cw0EeVw2NkoCqbOo');

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
  `etatCommande` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`numCommande`, `prixCommande`, `prixReduitCommande`, `paiementEnLigne`, `dateCommande`, `numSiretCommerce`, `numPanier`, `etatCommande`) VALUES
(8, '899.9', NULL, NULL, '2018-11-20 23:46:43', '22222222222222', 5, NULL),
(9, '30', NULL, NULL, '2018-11-20 23:46:43', '11111111111111', 5, 'terminee'),
(13, '8.85', NULL, NULL, '2018-11-25 13:18:54', '11111111111111', 6, 'traitement'),
(14, '89.99', NULL, NULL, '2018-11-25 13:18:54', '22222222222222', 6, 'traitement'),
(15, '11.75', NULL, NULL, '2018-11-28 21:17:40', '11111111111111', 7, 'traitement'),
(18, '15.4', NULL, NULL, NULL, '11111111111111', 8, NULL),
(19, '89.99', NULL, NULL, NULL, '22222222222222', 8, NULL);

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
  `telCommerce` char(10) NOT NULL,
  `codeReduction` varchar(10) DEFAULT NULL,
  `codeRecrutement` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commerces`
--

INSERT INTO `commerces` (`numSiretCommerce`, `nomCommerce`, `libelleCommerce`, `adresseCommerce`, `villeCommerce`, `codePostalCommerce`, `telCommerce`, `codeReduction`, `codeRecrutement`) VALUES
('11111111111111', 'KFC', 'restauration rapide de poulet', '495 Avenue du Mas d\'Argelliers', 'Montpellier', '34000', '0658957426', NULL, '123456'),
('12345677654321', 'Adidas', 'marque de sport', '400 Avenue Claude Baillet', 'Nimes', '30000', '0559782356', '', '123123'),
('22222222222222', 'Ikea', 'magasin spécialisé dans la conception et la vente de détail de mobilier et objets de décoration prêts à poser ou à monter en kit.', '1 Place de Troie', 'Montpellier', '34900', '0775957595', NULL, '000000'),
('44444444444444', 'n', 'n', '1 rue du Port Feu Hugon (esc C1 )', 'Tours', '37000', '0685404708', NULL, '');

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
(3, 3, NULL, '6'),
(8, 5, NULL, '10'),
(9, 6, NULL, '20'),
(10, 1, NULL, '5'),
(10, 2, NULL, '1'),
(13, 1, 0, '1'),
(13, 2, 1, '1'),
(13, 3, 0, '1'),
(13, 6, 1, '1'),
(14, 5, 1, '1'),
(15, 3, 0, '5'),
(16, 1, NULL, '5'),
(16, 2, NULL, '1'),
(17, 1, NULL, '1'),
(18, 2, NULL, '2'),
(19, 5, NULL, '1');

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
(11, 'Lundi', '11111111111111', '13:00', '20:00');

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
(5, '2018-11-20 23:46:43', 929.9, NULL, NULL, 'r@g.com'),
(6, '2018-11-25 13:18:54', 98.83999999999999, NULL, '14.6', 'r@g.com'),
(7, '2018-11-28 21:17:40', 11.75, NULL, '1.2', 'r@g.com'),
(8, NULL, 95.99, NULL, NULL, 'r@g.com');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `numProduit` int(11) NOT NULL,
  `nomProduit` varchar(50) NOT NULL,
  `libelleProduit` varchar(50) NOT NULL,
  `qteStockProduit` int(10) NOT NULL,
  `qteStockDispoProduit` int(10) NOT NULL,
  `livraisonProduit` tinyint(1) NOT NULL,
  `prixProduit` varchar(10) NOT NULL,
  `numSiretCommerce` char(14) NOT NULL,
  `nomTypeProduit` varchar(25) NOT NULL,
  `couleurProduit` text DEFAULT NULL,
  `tailleProduit` text DEFAULT NULL,
  `marqueProduit` text DEFAULT NULL,
  `numGroupeVariante` int(11) NOT NULL,
  `imageProduit` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`numProduit`, `nomProduit`, `libelleProduit`, `qteStockProduit`, `qteStockDispoProduit`, `livraisonProduit`, `prixProduit`, `numSiretCommerce`, `nomTypeProduit`, `couleurProduit`, `tailleProduit`, `marqueProduit`, `numGroupeVariante`, `imageProduit`) VALUES
(1, 'wings', 'aile de poulet fris', 156, 146, 0, '2', '11111111111111', 'Nourriture', NULL, NULL, NULL, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSs0qLwurYDYph7EotV-jOiLZh_KHGlhXDogAqigHloeOZNxS-v'),
(2, 'tenders', 'filet de poulet fris', 306, 306, 0, '3', '11111111111111', 'Nourriture', NULL, NULL, NULL, 2, 'http://allopizza77.fr/emporter/88-large_default/tenders.jpg'),
(3, 'pilon', 'partie inférieur de la cuisse de poulet', 130, 130, 0, '2.35', '11111111111111', 'Nourriture', NULL, NULL, NULL, 3, ''),
(5, 'table ikluflux', 'table 200cm x 80 cm x 100 cm', 50, 50, 0, '89.99', '22222222222222', 'Meuble', 'marron', '200x80x100', NULL, 4, ''),
(6, 'frites', 'barquette de frites', 106, 97, 1, '1.5', '11111111111111', 'Nourriture', NULL, 'petite', NULL, 5, ''),
(7, 'table ikluflux', 'table 200cm x 80 cm x 100 cm', 50, 50, 0, '89.99', '22222222222222', 'Meuble', 'bleu', '200x80x100', NULL, 4, ''),
(14, 'table ikluflux', 'table 200cm x 80 cm x 100 cm', 60, 60, 0, '89.99', '22222222222222', 'Meuble', 'rouge', '200x80x100', NULL, 4, ''),
(16, 'frites', 'barquette de frites', 106, 97, 1, '2', '11111111111111', 'Nourriture', NULL, 'moyenne', NULL, 5, ''),
(17, 'frites', 'barquette de frites', 106, 97, 1, '2.5', '11111111111111', 'Nourriture', NULL, 'grande', NULL, 5, '');

-- --------------------------------------------------------

--
-- Structure de la table `reductions`
--

CREATE TABLE `reductions` (
  `numReduction` int(11) NOT NULL,
  `pointsReduction` double NOT NULL,
  `dateDebutReduction` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateFinReduction` timestamp NULL DEFAULT NULL,
  `mailClient` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reductions`
--

INSERT INTO `reductions` (`numReduction`, `pointsReduction`, `dateDebutReduction`, `dateFinReduction`, `mailClient`) VALUES
(1, 0, '2018-11-22 21:43:42', '2018-12-05 23:00:00', 'r@g.com'),
(2, 0, '2018-12-06 21:40:04', '2018-12-05 23:00:00', 'bob@gmail.com'),
(3, 0, '2019-01-10 10:28:11', '2019-01-09 23:00:00', 'jean@hotmail.fr'),
(4, 0, '2019-01-10 10:48:17', '2019-01-09 23:00:00', 'jean@hotmail.fr'),
(5, 0, '2019-01-10 10:53:27', '2019-01-09 23:00:00', 'zz@gmail.com'),
(6, 0, '2019-01-10 10:57:45', '2019-01-09 23:00:00', 'zzz@g.com'),
(7, 0, '2019-01-10 11:02:14', '2019-01-09 23:00:00', 'zzz@g.com');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `numReservation` int(11) NOT NULL,
  `dateReservation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
(27, '2018-12-13 20:05:50', 'r@g.com');

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
('Meuble', '10080'),
('Nourriture', '60');

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
(8);

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
  `remember_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vendeurs`
--

INSERT INTO `vendeurs` (`mailVendeur`, `nomVendeur`, `prenomVendeur`, `mdpVendeur`, `telVendeur`, `idVendeur`, `remember_token`) VALUES
('cci@gmail.com', 'cci', 'cci', '$2y$10$NETz7trIS..vuVMKYvUXVOSfvgFEWuO5McPs01Nhuqc1PwqAr0tA2', '0433103310', 27, ''),
('mathieu@gmail.com', 'r', 'r', '$2y$10$g8X9Vsug0fic9zBBurg/A.T/4j/4NwW9S1tuar1crwJMWP0YffrKW', '0685404708', 1, ''),
('pepito24@yahoo.fr', 'pepito', 'aïe', '$2y$10$mVE932fpgExRzJce7ajxme2SfZnoRGI3GnpKzndPspms4xflKiZ2a', '0150426988', 2, ''),
('vdd@gmail.com', 'vdd', 'vdd', '$2y$10$7OoagxKe1bTnbAl/v9XgUOoxgR9.Z/HqB9k9zIjiIJ/xygMsdgr2.', '0202020202', 28, NULL),
('vendeur@gmail.com', 'Toulino', 'David', '$2y$10$uK/2emyMVyUAG7FiiaIHdekKZ6QIysZPw0fMvYZOsdgluIX4GLZLC', '0685404708', 3, 'KKCaxdlhYB6MTfpbEgzS9ETTtkHdAMJnpfxWqPesC4PsQLvPRc7BQC1QYCYY');

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
  MODIFY `numAvis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `idClient` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `numCommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `jours`
--
ALTER TABLE `jours`
  MODIFY `numJour` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `ouvrir`
--
ALTER TABLE `ouvrir`
  MODIFY `numOuvrir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `paniers`
--
ALTER TABLE `paniers`
  MODIFY `numPanier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `numProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `reductions`
--
ALTER TABLE `reductions`
  MODIFY `numReduction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `numReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `numTag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `variantes`
--
ALTER TABLE `variantes`
  MODIFY `numGroupeVariante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `vendeurs`
--
ALTER TABLE `vendeurs`
  MODIFY `idVendeur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_produits0_FK` FOREIGN KEY (`numProduit`) REFERENCES `produits` (`numProduit`),
  ADD CONSTRAINT `contenir_reservations_FK` FOREIGN KEY (`numreservation`) REFERENCES `reservations` (`numReservation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
