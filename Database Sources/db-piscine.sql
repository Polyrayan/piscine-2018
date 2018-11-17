-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  sam. 17 nov. 2018 à 14:39
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
('22222222222222', 'vendeur@gmail.com');

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

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `mailClient` varchar(100) NOT NULL,
  `nomClient` varchar(20) NOT NULL,
  `prenomClient` varchar(20) NOT NULL,
  `mdpClient` char(60) NOT NULL,
  `adresseClient` varchar(80) NOT NULL,
  `villeClient` varchar(30) NOT NULL,
  `codePostalClient` char(5) NOT NULL,
  `telClient` text NOT NULL,
  `numReduction` int(11) DEFAULT NULL,
  `sexeClient` char(5) NOT NULL,
  `dateNaissanceClient` date NOT NULL,
  `idClient` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`mailClient`, `nomClient`, `prenomClient`, `mdpClient`, `adresseClient`, `villeClient`, `codePostalClient`, `telClient`, `numReduction`, `sexeClient`, `dateNaissanceClient`, `idClient`) VALUES
('a@g.com', 'b', 'bahroun', '$2y$10$3oVR9MR6GseYUtwQTFjHQO6bN52nkRqAWdvIjzTrvvkHGDNGDBJMq', '1 rue du Port Feu Hugon (esc C1 )', 'Tours', '37000', '0685404708', NULL, 'male', '1999-03-03', 1),
('r@g.com', 'rayan', 'bahroun', '@', '1 rue du Port Feu Hugon (esc C1 )', 'Tours', '37000', '0685404708', NULL, 'male', '1996-06-28', 2);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `numCommande` int(11) NOT NULL,
  `prixCommande` varchar(5) NOT NULL,
  `prixReduitCommande` varchar(5) NOT NULL,
  `paiementEnLigne` tinyint(1) NOT NULL,
  `dateCommande` date NOT NULL,
  `numSiretCommerce` char(14) NOT NULL,
  `numPanier` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
('11111111111111', 'KFC', 'restauration rapide de poulet', '12 rue Passerelle', 'Montpellier', '34000', '0658957426', NULL, '1234'),
('12345677654321', 'Adidas', 'marque de sport', '77 rue langevin', 'Nimes', '30000', '0559782356', '', '123123'),
('22222222222222', 'Ikea', 'magasin spécialisé dans la conception et la vente de détail de mobilier et objets de décoration prêts à poser ou à monter en kit.', '76 avenue klukeflux', 'Paris', '75000', '0775957595', NULL, '0000');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `numReservation` int(11) NOT NULL,
  `numProduit` int(11) NOT NULL,
  `qteReservation` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`numReservation`, `numProduit`, `qteReservation`) VALUES
(6, 1, '12');

-- --------------------------------------------------------

--
-- Structure de la table `detenir`
--

CREATE TABLE `detenir` (
  `numPanier` int(11) NOT NULL,
  `numProduit` int(11) NOT NULL,
  `qteReservation` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `nomJour` varchar(8) NOT NULL,
  `heureOuvertureMatin` char(2) DEFAULT NULL,
  `heureFermetureMatin` char(2) DEFAULT NULL,
  `heureOuvertureAprem` char(2) DEFAULT NULL,
  `heureFermetureAprem` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ouvrir`
--

CREATE TABLE `ouvrir` (
  `nomJour` varchar(8) NOT NULL,
  `numSiretCommerce` char(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `paniers`
--

CREATE TABLE `paniers` (
  `numPanier` int(11) NOT NULL,
  `datePanier` date NOT NULL,
  `prixPanier` varchar(5) NOT NULL,
  `prixReduitPanier` varchar(5) NOT NULL,
  `qtePointsAcquis` varchar(5) NOT NULL,
  `mailClient` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `numProduit` int(11) NOT NULL,
  `nomProduit` varchar(50) NOT NULL,
  `libelleProduit` varchar(50) NOT NULL,
  `qteStockProduit` varchar(10) NOT NULL,
  `qteStockDispoProduit` varchar(10) NOT NULL,
  `livraisonProduit` tinyint(1) NOT NULL,
  `prixProduit` varchar(10) NOT NULL,
  `numSiretCommerce` char(14) NOT NULL,
  `numTypeProduit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`numProduit`, `nomProduit`, `libelleProduit`, `qteStockProduit`, `qteStockDispoProduit`, `livraisonProduit`, `prixProduit`, `numSiretCommerce`, `numTypeProduit`) VALUES
(1, 'wings', 'aile de poulet fris', '200', '200', 0, '2', '11111111111111', NULL),
(2, 'tenders', 'filet de poulet fris', '350', '350', 0, '3', '11111111111111', NULL),
(3, 'pilon', 'partie inférieur de la cuisse de poulet', '189', '189', 0, '2.35', '11111111111111', NULL),
(5, 'table ikluflux', 'table 200cm x 80 cm x 100 cm', '45', '45', 0, '89.99', '22222222222222', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reductions`
--

CREATE TABLE `reductions` (
  `numReduction` int(11) NOT NULL,
  `pointsReduction` varchar(5) NOT NULL,
  `dateDebutReduction` date NOT NULL,
  `dateFinReduction` date NOT NULL,
  `mailClient` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(6, '2018-11-17 01:57:37', 'r@g.com');

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
  `numTypeProduit` int(11) NOT NULL,
  `libelleTypeProduit` varchar(255) NOT NULL,
  `couleur` varchar(10) NOT NULL,
  `taille` varchar(10) NOT NULL,
  `marque` varchar(15) NOT NULL,
  `tempsReservation` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `idVendeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vendeurs`
--

INSERT INTO `vendeurs` (`mailVendeur`, `nomVendeur`, `prenomVendeur`, `mdpVendeur`, `telVendeur`, `idVendeur`) VALUES
('mathieu@gmail.com', 'r', 'r', '$2y$10$g8X9Vsug0fic9zBBurg/A.T/4j/4NwW9S1tuar1crwJMWP0YffrKW', '0685404708', 1),
('pepito24@yahoo.fr', 'pepito', 'aïe', '$2y$10$mVE932fpgExRzJce7ajxme2SfZnoRGI3GnpKzndPspms4xflKiZ2a', '0150426988', 2),
('vendeur@gmail.com', 'Sanders', 'colonel', '$2y$10$GulZ5YAWSs3Y.6uEez6lEOdupvAq6sFrEpWrMsE4bXgYyhSg2TLZu', '0685404708', 3);

--
-- Index pour les tables déchargées
--

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
  ADD PRIMARY KEY (`numPanier`,`numProduit`),
  ADD KEY `detenir_produits0_FK` (`numProduit`);

--
-- Index pour la table `inclure`
--
ALTER TABLE `inclure`
  ADD PRIMARY KEY (`numTag`,`numProduit`);

--
-- Index pour la table `jours`
--
ALTER TABLE `jours`
  ADD PRIMARY KEY (`nomJour`);

--
-- Index pour la table `ouvrir`
--
ALTER TABLE `ouvrir`
  ADD PRIMARY KEY (`nomJour`,`numSiretCommerce`);

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
  ADD PRIMARY KEY (`numTypeProduit`);

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
  MODIFY `numAvis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `idClient` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `numCommande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paniers`
--
ALTER TABLE `paniers`
  MODIFY `numPanier` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `numProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `reductions`
--
ALTER TABLE `reductions`
  MODIFY `numReduction` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `numReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `numTag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `typeproduits`
--
ALTER TABLE `typeproduits`
  MODIFY `numTypeProduit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vendeurs`
--
ALTER TABLE `vendeurs`
  MODIFY `idVendeur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_produits0_FK` FOREIGN KEY (`numProduit`) REFERENCES `produits` (`numProduit`),
  ADD CONSTRAINT `contenir_reservations_FK` FOREIGN KEY (`numreservation`) REFERENCES `reservations` (`numReservation`);

--
-- Contraintes pour la table `detenir`
--
ALTER TABLE `detenir`
  ADD CONSTRAINT `detenir_paniers_FK` FOREIGN KEY (`numPanier`) REFERENCES `paniers` (`numPanier`),
  ADD CONSTRAINT `detenir_produits0_FK` FOREIGN KEY (`numProduit`) REFERENCES `produits` (`numProduit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
