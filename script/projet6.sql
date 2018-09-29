-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 29 sep. 2018 à 18:36
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

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
  `spam` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`id`, `title`, `content`, `typeof`, `tel`, `email`, `city`, `author`, `creation_date`, `spam`, `image`, `member_id`) VALUES
(181, 'test', 'xx', 'recherche', '0643007965', 'anne.gaste@hotmail.fr', 'corbeil-essonnes', 'bibi', '2018-09-28 20:50:50', NULL, './public/upload/79331images.jpg.jpg', 0),
(180, 'episode test', 'ccc', 'recherche', '0643007965', 'anne.gaste@hotmail.fr', 'corbeil-essonnes', 'claire', '2018-09-28 20:30:20', NULL, './public/upload/30836images.jpg.jpg', 0),
(179, 'episode test', 'ccc', 'recherche', '0643007965', 'anne.gaste@hotmail.fr', 'corbeil-essonnes', 'claire', '2018-09-28 20:24:35', NULL, './public/upload/86992images.jpg.jpg', 0),
(178, 'episode test', 'ccc', 'recherche', '0643007965', 'anne.gaste@hotmail.fr', 'corbeil-essonnes', 'claire', '2018-09-28 20:23:50', NULL, './public/upload/', 0),
(177, 'episode test', 'ccc', 'recherche', '0643007965', 'anne.gaste@hotmail.fr', 'corbeil-essonnes', 'claire', '2018-09-28 20:23:36', NULL, './public/upload/', 0),
(176, 'bricolage', 'nn', 'recherche', '0643007965', 'anne.gaste@hotmail.fr', 'potigny', 'bibi', '2018-09-28 20:08:26', NULL, './public/upload/82395licorne.jpg.jpg', 0),
(175, 'peinture', 'recherche peintre', 'recherche', '0643007965', 'anne.gaste@hotmail.fr', 'potigny', 'anne', '2018-09-28 20:05:25', NULL, './public/upload/67978images.jpg.jpg', 0),
(182, 'test', 'x', 'recherche', '0643007965', 'anne.gaste@hotmail.fr', 'potigny', 'bibi', '2018-09-28 21:08:40', NULL, './public/upload/80584images.jpg.jpg', 18);

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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `pseudo`, `pass`, `email`, `date_inscription`) VALUES
(18, 'leeloo', '$2y$10$IJ49h.aorVDonFT9IFOe3Oiz0lTPZEWTWG7EnoXZWHmLMqoZ0KqiO', 'master2@hotmail.fr', '2018-09-20');

-- --------------------------------------------------------

--
-- Structure de la table `messaging`
--

DROP TABLE IF EXISTS `messaging`;
CREATE TABLE IF NOT EXISTS `messaging` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `object` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `messaging`
--

INSERT INTO `messaging` (`id`, `first_name`, `surname`, `email`, `tel`, `message`, `creation_date`, `object`, `status`) VALUES
(70, 'anne', 'ddd', 'anne.gaste@hotmail.fr', '0643007965', 'cc', '2018-09-21 14:17:03', 'tesssssssst', 'New'),
(64, 'prenom', 'nom', 'mail', 'tel', 'message\r\n', '2018-09-20 16:47:47', 'motif', '?'),
(71, 'anne', 'gasté', 'anne.gaste@hotmail.fr', '0643007965', 'uuuuu', '2018-09-26 22:10:37', 'tesssssssst', 'New');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
