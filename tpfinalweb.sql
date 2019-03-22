-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 22 mars 2019 à 23:08
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tpfinalweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

DROP TABLE IF EXISTS `partie`;
CREATE TABLE IF NOT EXISTS `partie` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `enCours` tinyint(1) NOT NULL,
  `NumPhoto` int(11) NOT NULL,
  `time` time NOT NULL,
  `Score` int(11) NOT NULL,
  `idPlayer` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_player` (`idPlayer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `partie`
--

INSERT INTO `partie` (`id`, `token`, `enCours`, `NumPhoto`, `time`, `Score`, `idPlayer`) VALUES
(1, '1dfggdfs5qsf549qsdf68493qsf35', 1, 4, '00:25:00', 15, 1),
(2, '5dfd64qfq6468eqzf6', 0, 10, '00:56:00', 50, 1),
(3, 'sdfgklj5qsf654fqfsdqg6', 1, 7, '00:48:00', 35, 1),
(5, '38b3992e95c99f4f77e0e24a5d9a451f1b317bf6', 1, 6, '00:00:04', 0, 1),
(6, '38b3992e95c99f4f77e0e24a5d9a451f1b317bf6', 1, 7, '00:00:07', 0, 1),
(7, '38b3992e95c99f4f77e0e24a5d9a451f1b317bf6', 1, 3, '00:00:04', 0, 1),
(4, '38b3992e95c99f4f77e0e24a5d9a451f1b317bf6', 1, 4, '00:00:09', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Mdp` varchar(255) NOT NULL,
  `EnCours` tinyint(1) DEFAULT NULL,
  `scoreEnCours` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `player`
--

INSERT INTO `player` (`id`, `Name`, `Mdp`, `EnCours`, `scoreEnCours`) VALUES
(1, 'root', 'root', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
  `id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  KEY `fk_id_Player` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `score`
--

INSERT INTO `score` (`id`, `score`) VALUES
(1, 555),
(1, 333);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `fk_id_Player` FOREIGN KEY (`id`) REFERENCES `player` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
