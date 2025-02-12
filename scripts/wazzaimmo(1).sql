-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 fév. 2025 à 16:54
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
-- Création : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `a_eventuellement`;
CREATE TABLE `a_eventuellement` (
  `an_id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `a_eventuellement`:
--   `an_id`
--       `waz_annonces` -> `an_id`
--   `op_id`
--       `waz_option` -> `op_id`
--

-- --------------------------------------------------------

--
-- Structure de la table `est`
--
-- Création : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `est`;
CREATE TABLE `est` (
  `user_id` int(11) NOT NULL,
  `ty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `est`:
--   `user_id`
--       `waz_user` -> `user_id`
--   `ty_id`
--       `waz_type_utilisateur` -> `ty_id`
--

-- --------------------------------------------------------

--
-- Structure de la table `peut_contenir`
--
-- Création : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `peut_contenir`;
CREATE TABLE `peut_contenir` (
  `an_id` int(11) NOT NULL,
  `photos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `peut_contenir`:
--   `an_id`
--       `waz_annonces` -> `an_id`
--   `photos_id`
--       `waz_photos` -> `photos_id`
--

-- --------------------------------------------------------

--
-- Structure de la table `waz_annonces`
--
-- Création : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `waz_annonces`;
CREATE TABLE `waz_annonces` (
  `an_id` int(11) NOT NULL,
  `an_ref` int(11) NOT NULL,
  `an_pieces` tinyint(4) NOT NULL,
  `an_titre` varchar(200) NOT NULL,
  `an_description` varchar(8000) NOT NULL,
  `an_localisation` varchar(100) NOT NULL,
  `an_surf_hab` float NOT NULL,
  `an_surf_tot` float DEFAULT NULL,
  `an_prix` decimal(15,2) NOT NULL,
  `an_diagnostic` varchar(1) NOT NULL,
  `an_d_ajout` datetime NOT NULL,
  `an_d_modif` datetime NOT NULL,
  `ty_bien_id` int(11) NOT NULL,
  `etat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `waz_annonces`:
--   `ty_bien_id`
--       `waz_type_bien` -> `ty_bien_id`
--   `etat_id`
--       `waz_ann_etat` -> `etat_id`
--   `user_id`
--       `waz_user` -> `user_id`
--

--
-- Déclencheurs `waz_annonces`
--
DROP TRIGGER IF EXISTS `ann_generate_ref`;
DELIMITER $$
CREATE TRIGGER `ann_generate_ref` BEFORE INSERT ON `waz_annonces` FOR EACH ROW BEGIN
    DECLARE prefix CHAR(3) DEFAULT 'REF';
    DECLARE num INT;

    SELECT COUNT(*) INTO num FROM waz_annonces;
    SET num = num + 1;

    SET NEW.an_ref = CONCAT(prefix, LPAD(num, 7, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `waz_ann_etat`
--
-- Création : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `waz_ann_etat`;
CREATE TABLE `waz_ann_etat` (
  `etat_id` int(11) NOT NULL,
  `etat_libelle` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `waz_ann_etat`:
--

-- --------------------------------------------------------

--
-- Structure de la table `waz_option`
--
-- Création : mer. 12 fév. 2025 à 14:34
-- Dernière modification : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `waz_option`;
CREATE TABLE `waz_option` (
  `op_id` int(11) NOT NULL,
  `op_libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `waz_option`:
--

--
-- Déchargement des données de la table `waz_option`
--

INSERT INTO `waz_option` (`op_id`, `op_libelle`) VALUES(1, 'jardin');
INSERT INTO `waz_option` (`op_id`, `op_libelle`) VALUES(2, 'garage');
INSERT INTO `waz_option` (`op_id`, `op_libelle`) VALUES(3, 'comble aménageables');
INSERT INTO `waz_option` (`op_id`, `op_libelle`) VALUES(4, 'piscine');
INSERT INTO `waz_option` (`op_id`, `op_libelle`) VALUES(5, 'parking');
INSERT INTO `waz_option` (`op_id`, `op_libelle`) VALUES(6, 'terasse');

-- --------------------------------------------------------

--
-- Structure de la table `waz_photos`
--
-- Création : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `waz_photos`;
CREATE TABLE `waz_photos` (
  `photos_id` int(11) NOT NULL,
  `photos_libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `waz_photos`:
--

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_bien`
--
-- Création : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `waz_type_bien`;
CREATE TABLE `waz_type_bien` (
  `ty_bien_id` int(11) NOT NULL,
  `ty_bien_libelle` varchar(50) NOT NULL,
  `ty_offre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `waz_type_bien`:
--   `ty_offre_id`
--       `waz_type_offre` -> `ty_offre_id`
--

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_offre`
--
-- Création : mer. 12 fév. 2025 à 14:34
-- Dernière modification : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `waz_type_offre`;
CREATE TABLE `waz_type_offre` (
  `ty_offre_id` int(11) NOT NULL,
  `offre_libelle` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `waz_type_offre`:
--

--
-- Déchargement des données de la table `waz_type_offre`
--

INSERT INTO `waz_type_offre` (`ty_offre_id`, `offre_libelle`) VALUES(1, 'A');
INSERT INTO `waz_type_offre` (`ty_offre_id`, `offre_libelle`) VALUES(2, 'L');
INSERT INTO `waz_type_offre` (`ty_offre_id`, `offre_libelle`) VALUES(3, 'V');

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_utilisateur`
--
-- Création : mer. 12 fév. 2025 à 14:34
-- Dernière modification : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `waz_type_utilisateur`;
CREATE TABLE `waz_type_utilisateur` (
  `ty_id` int(11) NOT NULL,
  `ty_libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `waz_type_utilisateur`:
--

--
-- Déchargement des données de la table `waz_type_utilisateur`
--

INSERT INTO `waz_type_utilisateur` (`ty_id`, `ty_libelle`) VALUES(1, 'admin');
INSERT INTO `waz_type_utilisateur` (`ty_id`, `ty_libelle`) VALUES(2, 'commercial');
INSERT INTO `waz_type_utilisateur` (`ty_id`, `ty_libelle`) VALUES(3, 'default');

-- --------------------------------------------------------

--
-- Structure de la table `waz_user`
--
-- Création : mer. 12 fév. 2025 à 14:34
--

DROP TABLE IF EXISTS `waz_user`;
CREATE TABLE `waz_user` (
  `user_id` int(11) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_login` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONS POUR LA TABLE `waz_user`:
--

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `a_eventuellement`
--
ALTER TABLE `a_eventuellement`
  ADD PRIMARY KEY (`an_id`,`op_id`),
  ADD KEY `op_id` (`op_id`);

--
-- Index pour la table `est`
--
ALTER TABLE `est`
  ADD PRIMARY KEY (`user_id`,`ty_id`),
  ADD KEY `ty_id` (`ty_id`);

--
-- Index pour la table `peut_contenir`
--
ALTER TABLE `peut_contenir`
  ADD PRIMARY KEY (`an_id`,`photos_id`),
  ADD KEY `photos_id` (`photos_id`);

--
-- Index pour la table `waz_annonces`
--
ALTER TABLE `waz_annonces`
  ADD PRIMARY KEY (`an_id`),
  ADD KEY `ty_bien_id` (`ty_bien_id`),
  ADD KEY `etat_id` (`etat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `waz_ann_etat`
--
ALTER TABLE `waz_ann_etat`
  ADD PRIMARY KEY (`etat_id`);

--
-- Index pour la table `waz_option`
--
ALTER TABLE `waz_option`
  ADD PRIMARY KEY (`op_id`);

--
-- Index pour la table `waz_photos`
--
ALTER TABLE `waz_photos`
  ADD PRIMARY KEY (`photos_id`);

--
-- Index pour la table `waz_type_bien`
--
ALTER TABLE `waz_type_bien`
  ADD PRIMARY KEY (`ty_bien_id`),
  ADD KEY `ty_offre_id` (`ty_offre_id`);

--
-- Index pour la table `waz_type_offre`
--
ALTER TABLE `waz_type_offre`
  ADD PRIMARY KEY (`ty_offre_id`);

--
-- Index pour la table `waz_type_utilisateur`
--
ALTER TABLE `waz_type_utilisateur`
  ADD PRIMARY KEY (`ty_id`);

--
-- Index pour la table `waz_user`
--
ALTER TABLE `waz_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `a_eventuellement`
--
ALTER TABLE `a_eventuellement`
  ADD CONSTRAINT `a_eventuellement_ibfk_1` FOREIGN KEY (`an_id`) REFERENCES `waz_annonces` (`an_id`),
  ADD CONSTRAINT `a_eventuellement_ibfk_2` FOREIGN KEY (`op_id`) REFERENCES `waz_option` (`op_id`);

--
-- Contraintes pour la table `est`
--
ALTER TABLE `est`
  ADD CONSTRAINT `est_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `waz_user` (`user_id`),
  ADD CONSTRAINT `est_ibfk_2` FOREIGN KEY (`ty_id`) REFERENCES `waz_type_utilisateur` (`ty_id`);

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
  ADD CONSTRAINT `waz_annonces_ibfk_1` FOREIGN KEY (`ty_bien_id`) REFERENCES `waz_type_bien` (`ty_bien_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_2` FOREIGN KEY (`etat_id`) REFERENCES `waz_ann_etat` (`etat_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `waz_user` (`user_id`);

--
-- Contraintes pour la table `waz_type_bien`
--
ALTER TABLE `waz_type_bien`
  ADD CONSTRAINT `waz_type_bien_ibfk_1` FOREIGN KEY (`ty_offre_id`) REFERENCES `waz_type_offre` (`ty_offre_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
