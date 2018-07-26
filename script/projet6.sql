-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 26 juil. 2018 à 20:06
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet6`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

DROP TABLE IF EXISTS `annonces`;
CREATE TABLE IF NOT EXISTS `annonces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `typeof` varchar(30) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`id`, `title`, `content`, `typeof`, `tel`, `email`, `city`, `author`, `creation_date`) VALUES
(5, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'recherche', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(4, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'recherche', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(3, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'recherche', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(2, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'recherche', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(1, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'recherche', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(6, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'recherche', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(7, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'propose', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(8, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'propose', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(9, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'propose', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(10, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'propose', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(11, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'propose', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20'),
(12, 'bricolage', 'blablablablabalbalbalbalabalblabalblabalbalab', 'propose', '0606060606', 'a@hotmail.fr', 'ploucville', 'heyhey', '2018-07-26 23:13:20');

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `pass` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_inscription` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `pseudo`, `pass`, `email`, `date_inscription`) VALUES
(10, 'leeloo', 'test', 'anne.gaste@hotmail.fr', '2018-07-25'),
(11, 'blabla', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'blabl@hotmail.fr', '2018-07-25'),
(12, 'toto', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'toto@hotmail.fr', '2018-07-25'),
(13, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test@hotmail.fr', '2018-07-25');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
