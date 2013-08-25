-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 25 Août 2013 à 02:37
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `timegame`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `nickname` varchar(32) COLLATE utf8_bin NOT NULL,
  `mail` varchar(128) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`nickname`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `age`
--

CREATE TABLE IF NOT EXISTS `age` (
  `idage` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(124) COLLATE utf8_bin NOT NULL,
  `wealth` int(11) NOT NULL,
  PRIMARY KEY (`idage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `agerequirment`
--

CREATE TABLE IF NOT EXISTS `agerequirment` (
  `idage` int(11) NOT NULL,
  `idbuilding` int(11) NOT NULL,
  `lv` int(11) NOT NULL,
  PRIMARY KEY (`idage`,`idbuilding`),
  KEY `idbuilding` (`idbuilding`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `army`
--

CREATE TABLE IF NOT EXISTS `army` (
  `idarmy` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `atkpower` int(11) NOT NULL,
  `defpower` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  PRIMARY KEY (`idarmy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `breed`
--

CREATE TABLE IF NOT EXISTS `breed` (
  `idbreed` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idbreed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `building`
--

CREATE TABLE IF NOT EXISTS `building` (
  `idbuilding` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `maxlv` int(11) NOT NULL,
  PRIMARY KEY (`idbuilding`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `empire`
--

CREATE TABLE IF NOT EXISTS `empire` (
  `idempire` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idempire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `idgame` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(32) COLLATE utf8_bin NOT NULL,
  `idserver` int(11) NOT NULL,
  `idbreed` int(11) DEFAULT NULL,
  `idempire` int(11) DEFAULT NULL,
  `idguild` int(11) DEFAULT NULL,
  `idage` int(11) DEFAULT NULL,
  PRIMARY KEY (`idgame`),
  UNIQUE KEY `nickname` (`nickname`,`idserver`),
  KEY `idbreed` (`idbreed`),
  KEY `idempire` (`idempire`),
  KEY `idguild` (`idguild`),
  KEY `idage` (`idage`),
  KEY `idserver` (`idserver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `guild`
--

CREATE TABLE IF NOT EXISTS `guild` (
  `idguild` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(124) COLLATE utf8_bin NOT NULL,
  `membernumber` int(11) NOT NULL,
  `description` varchar(258) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idguild`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ownedarmy`
--

CREATE TABLE IF NOT EXISTS `ownedarmy` (
  `idarmy` int(11) NOT NULL,
  `idgame` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`idarmy`,`idgame`),
  KEY `idarmy` (`idarmy`,`idgame`),
  KEY `idgame` (`idgame`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `ownedbuilding`
--

CREATE TABLE IF NOT EXISTS `ownedbuilding` (
  `idbuilding` int(11) NOT NULL,
  `idgame` int(11) NOT NULL,
  `lv` int(11) NOT NULL,
  PRIMARY KEY (`idbuilding`,`idgame`),
  KEY `idgame` (`idgame`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `ownedressource`
--

CREATE TABLE IF NOT EXISTS `ownedressource` (
  `idgame` int(11) NOT NULL,
  `idressource` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `coeff` int(11) NOT NULL,
  PRIMARY KEY (`idgame`,`idressource`),
  KEY `idressource` (`idressource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `ressource`
--

CREATE TABLE IF NOT EXISTS `ressource` (
  `idressource` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idressource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `server`
--

CREATE TABLE IF NOT EXISTS `server` (
  `idserver` int(11) NOT NULL AUTO_INCREMENT,
  `temporalcoeff` int(11) NOT NULL,
  `begindate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  PRIMARY KEY (`idserver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `agerequirment`
--
ALTER TABLE `agerequirment`
  ADD CONSTRAINT `agerequirment_ibfk_1` FOREIGN KEY (`idage`) REFERENCES `age` (`idage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agerequirment_ibfk_2` FOREIGN KEY (`idbuilding`) REFERENCES `building` (`idbuilding`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_8` FOREIGN KEY (`idserver`) REFERENCES `server` (`idserver`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `game_ibfk_3` FOREIGN KEY (`idbreed`) REFERENCES `breed` (`idbreed`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_ibfk_4` FOREIGN KEY (`idempire`) REFERENCES `empire` (`idempire`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_ibfk_5` FOREIGN KEY (`idguild`) REFERENCES `guild` (`idguild`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_ibfk_6` FOREIGN KEY (`idage`) REFERENCES `age` (`idage`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_ibfk_7` FOREIGN KEY (`nickname`) REFERENCES `account` (`nickname`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ownedarmy`
--
ALTER TABLE `ownedarmy`
  ADD CONSTRAINT `ownedarmy_ibfk_1` FOREIGN KEY (`idarmy`) REFERENCES `army` (`idarmy`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ownedarmy_ibfk_2` FOREIGN KEY (`idgame`) REFERENCES `game` (`idgame`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ownedbuilding`
--
ALTER TABLE `ownedbuilding`
  ADD CONSTRAINT `ownedbuilding_ibfk_1` FOREIGN KEY (`idbuilding`) REFERENCES `building` (`idbuilding`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ownedbuilding_ibfk_2` FOREIGN KEY (`idgame`) REFERENCES `game` (`idgame`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ownedressource`
--
ALTER TABLE `ownedressource`
  ADD CONSTRAINT `ownedressource_ibfk_1` FOREIGN KEY (`idgame`) REFERENCES `game` (`idgame`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ownedressource_ibfk_2` FOREIGN KEY (`idressource`) REFERENCES `ressource` (`idressource`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
