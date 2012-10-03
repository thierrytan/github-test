-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 01 Juin 2011 à 10:53
-- Version du serveur: 5.1.44
-- Version de PHP: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE `activite` (
  `no_activite` int(11) NOT NULL AUTO_INCREMENT,
  `no_projet` int(11) NOT NULL,
  `login` varchar(45) NOT NULL,
  `titre_act` varchar(45) NOT NULL,
  `note` varchar(255) NOT NULL,
  `priorite` smallint(6) NOT NULL,
  `etat` varchar(45) NOT NULL,
  PRIMARY KEY (`no_activite`,`login`),
  KEY `login` (`login`),
  KEY `no_projet` (`no_projet`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `activite`
--


-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `login` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` VALUES('test', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'thierry.tan1@gmail.com');
INSERT INTO `personne` VALUES('test3', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'thierry.tan1@gmail.com');
INSERT INTO `personne` VALUES('test2', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'yahiko_ryu@hotmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `no_projet` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `titre_proj` varchar(45) NOT NULL,
  `note` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  `couleur` varchar(45) NOT NULL,
  `etat` varchar(45) NOT NULL,
  PRIMARY KEY (`no_projet`,`login`),
  KEY `login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `projet`
--

