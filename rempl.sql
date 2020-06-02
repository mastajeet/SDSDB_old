-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Lundi 11 Juin 2007 à 09:21
-- Version du serveur: 4.1.9
-- Version de PHP: 4.3.10
-- 
-- Base de données: `sds`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `confirmation`
-- 

CREATE TABLE `confirmation` (
  `IDConfirmation` int(11) NOT NULL auto_increment,
  `IDEmploye` int(11) NOT NULL default '0',
  `Semaine` bigint(20) NOT NULL default '0',
  `Notes` text NOT NULL,
  PRIMARY KEY  (`IDConfirmation`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Structure de la table `confshift`
-- 

CREATE TABLE `confshift` (
  `IDConfshift` int(11) NOT NULL auto_increment,
  `IDConfirmation` int(11) NOT NULL default '0',
  `IDInstallation` int(11) NOT NULL default '0',
  `Jour` tinyint(4) NOT NULL default '0',
  `Heures` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`IDConfshift`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Structure de la table `remplacement`
-- 

CREATE TABLE `remplacement` (
  `IDRemplacement` int(11) NOT NULL auto_increment,
  `IDShift` int(11) NOT NULL default '0',
  `IDEmployeS` int(11) NOT NULL default '0',
  `IDEmployeE` int(11) NOT NULL default '0',
  `Lastminute` tinyint(4) NOT NULL default '0',
  `Confirme` tinyint(4) NOT NULL default '0',
  `Raison` text NOT NULL,
  `Talkedto` int(11) NOT NULL default '0',
  `Asked` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`IDRemplacement`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
