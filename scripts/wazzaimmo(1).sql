-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 13 fév. 2025 à 16:54
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wazzaimmo`
--
CREATE DATABASE IF NOT EXISTS `wazzaimmo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wazzaimmo`;

-- --------------------------------------------------------

--
-- Structure de la table `a_eventuellement`
--

DROP TABLE IF EXISTS `a_eventuellement`;
CREATE TABLE IF NOT EXISTS `a_eventuellement` (
  `an_id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL,
  PRIMARY KEY (`an_id`,`op_id`),
  KEY `op_id` (`op_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `op_libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`op_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `peut_contenir`
--

DROP TABLE IF EXISTS `peut_contenir`;
CREATE TABLE IF NOT EXISTS `peut_contenir` (
  `an_id` int(11) NOT NULL,
  `photos_id` int(11) NOT NULL,
  PRIMARY KEY (`an_id`,`photos_id`),
  KEY `photos_id` (`photos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_annonces`
--

DROP TABLE IF EXISTS `waz_annonces`;
CREATE TABLE IF NOT EXISTS `waz_annonces` (
  `an_id` int(11) NOT NULL AUTO_INCREMENT,
  `an_type` varchar(30) NOT NULL,
  `an_pieces` varchar(3) NOT NULL,
  `an_titre` varchar(200) NOT NULL,
  `an_description` varchar(8000) NOT NULL,
  `an_localisation` varchar(100) NOT NULL,
  `an_surf_hab` varchar(6) NOT NULL,
  `an_surf_tot` int(11) DEFAULT NULL,
  `an_prix` decimal(15,2) NOT NULL,
  `an_diagnostic` varchar(1) NOT NULL,
  `an_d_ajout` date NOT NULL,
  `an_d_modif` date NOT NULL,
  `etat_id` int(11) NOT NULL,
  `ty_user_id` int(11) NOT NULL,
  `ty_offre_id` int(11) NOT NULL,
  `photos_id` int(11) DEFAULT NULL,
  `ty_bien_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`an_id`),
  KEY `etat_id` (`etat_id`),
  KEY `ty_user_id` (`ty_user_id`),
  KEY `ty_offre_id` (`ty_offre_id`),
  KEY `photos_id` (`photos_id`),
  KEY `ty_bien_id` (`ty_bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_ann_etat`
--

DROP TABLE IF EXISTS `waz_ann_etat`;
CREATE TABLE IF NOT EXISTS `waz_ann_etat` (
  `etat_id` int(11) NOT NULL AUTO_INCREMENT,
  `etat_libelle` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`etat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_ann_etat`
--

INSERT INTO `waz_ann_etat` (`etat_id`, `etat_libelle`) VALUES
(1, 0),
(2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `waz_photos`
--

DROP TABLE IF EXISTS `waz_photos`;
CREATE TABLE IF NOT EXISTS `waz_photos` (
  `photos_id` int(11) NOT NULL AUTO_INCREMENT,
  `photos_libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`photos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_bien`
--

DROP TABLE IF EXISTS `waz_type_bien`;
CREATE TABLE IF NOT EXISTS `waz_type_bien` (
  `ty_bien_id` int(11) NOT NULL,
  `ty_bien_libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`ty_bien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_bien`
--

INSERT INTO `waz_type_bien` (`ty_bien_id`, `ty_bien_libelle`) VALUES
(1, 'Maison'),
(2, 'Appartement'),
(3, 'Immeuble'),
(4, 'Garage'),
(5, 'Terrain'),
(6, 'Bureau'),
(7, 'Locaux professionels');

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_offre`
--

DROP TABLE IF EXISTS `waz_type_offre`;
CREATE TABLE IF NOT EXISTS `waz_type_offre` (
  `ty_offre_id` int(11) NOT NULL AUTO_INCREMENT,
  `offre_libelle` varchar(1) NOT NULL,
  PRIMARY KEY (`ty_offre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_offre`
--

INSERT INTO `waz_type_offre` (`ty_offre_id`, `offre_libelle`) VALUES
(1, 'A'),
(2, 'L'),
(3, 'V');

-- --------------------------------------------------------

--
-- Structure de la table `waz_user`
--

DROP TABLE IF EXISTS `waz_user`;
CREATE TABLE IF NOT EXISTS `waz_user` (
  `ty_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `ty_libelle` varchar(20) NOT NULL,
  PRIMARY KEY (`ty_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_user`
--

INSERT INTO `waz_user` (`ty_user_id`, `ty_libelle`) VALUES
(1, 'admin'),
(2, 'commercial');

-- --------------------------------------------------------

--
-- Structure de la table `waz_utilisateur`
--

DROP TABLE IF EXISTS `waz_utilisateur`;
CREATE TABLE IF NOT EXISTS `waz_utilisateur` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `ty_user_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `ty_user_id` (`ty_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `a_eventuellement`
--
ALTER TABLE `a_eventuellement`
  ADD CONSTRAINT `a_eventuellement_ibfk_1` FOREIGN KEY (`an_id`) REFERENCES `waz_annonces` (`an_id`),
  ADD CONSTRAINT `a_eventuellement_ibfk_2` FOREIGN KEY (`op_id`) REFERENCES `options` (`op_id`);

--
-- Contraintes pour la table `peut_contenir`
--
ALTER TABLE `peut_contenir`
  ADD CONSTRAINT `peut_contenir_ibfk_1` FOREIGN KEY (`an_id`) REFERENCES `waz_annonces` (`an_id`),
  ADD CONSTRAINT `peut_contenir_ibfk_2` FOREIGN KEY (`photos_id`) REFERENCES `waz_photos` (`photos_id`);

--
-- Contraintes pour la table `waz_annonces`
--
ALTER TABLE `waz_annonces`
  ADD CONSTRAINT `waz_annonces_ibfk_1` FOREIGN KEY (`etat_id`) REFERENCES `waz_ann_etat` (`etat_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_2` FOREIGN KEY (`ty_user_id`) REFERENCES `waz_user` (`ty_user_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_3` FOREIGN KEY (`ty_offre_id`) REFERENCES `waz_type_offre` (`ty_offre_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_4` FOREIGN KEY (`photos_id`) REFERENCES `waz_photos` (`photos_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_5` FOREIGN KEY (`ty_bien_id`) REFERENCES `waz_type_bien` (`ty_bien_id`);

--
-- Contraintes pour la table `waz_utilisateur`
--
ALTER TABLE `waz_utilisateur`
  ADD CONSTRAINT `waz_utilisateur_ibfk_1` FOREIGN KEY (`ty_user_id`) REFERENCES `waz_user` (`ty_user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
