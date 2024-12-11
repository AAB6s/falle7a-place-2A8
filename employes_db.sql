-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 08 déc. 2024 à 16:37
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `employes_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

DROP TABLE IF EXISTS `employes`;
CREATE TABLE IF NOT EXISTS `employes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `status` enum('denied','approved') DEFAULT 'denied',
  `isVerified` tinyint(1) DEFAULT '0',
  `emailConfirmationToken` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`id`, `nom`, `prenom`, `email`, `telephone`, `status`, `isVerified`, `emailConfirmationToken`) VALUES
(10, 'malika', 'ouali', 'malika.ouali@gmail.com', '28078563', 'denied', 0, NULL),
(12, 'amin', 'barhoumi', 'aminbarhoumi@gmail.com', '29175447', 'approved', 0, NULL),
(13, 'iheb', 'dhaouedi', 'ihebdhaouedi@gmail.com', '54262185', 'approved', 0, NULL),
(15, 'khaled', 'bakhti', 'khalloufimaram10@gmail.com', '97213594', 'denied', 0, NULL),
(16, 'khaled', 'bakhti', 'khalloufimaram10@gmail.com', '97213594', 'denied', 0, NULL),
(17, 'khaled', 'bakhti', 'khalloufimaram10@gmail.com', '97213594', 'denied', 0, NULL),
(18, 'khaled', 'jlk,l', 'kkkkkkkkk@jjjjjjjjjj', '97213594', 'denied', 0, NULL),
(19, 'khaled', 'jknrgvlksjdnv', 'kuhfrnvmosndmv@klbhflkhdf', 'lkjfdv mkjdsf v', 'denied', 0, NULL),
(20, 'khaled', 'jknrgvlksjdnv', 'kuhfrnvmosndmv@klbhflkhdf', 'lkjfdv mkjdsf v', 'denied', 0, NULL),
(21, 'khaled', 'jknrgvlksjdnv', 'kuhfrnvmosndmv@klbhflkhdf', 'lkjfdv mkjdsf v', 'denied', 0, NULL),
(22, 'khaled', 'jknrgvlksjdnv', 'kuhfrnvmosndmv@klbhflkhdf', 'lkjfdv mkjdsf v', 'denied', 0, NULL),
(23, 'khaled', 'jknrgvlksjdnv', 'kuhfrnvmosndmv@klbhflkhdf', 'lkjfdv mkjdsf v', 'denied', 0, NULL),
(24, 'khaled', 'jknrgvlksjdnv', 'kuhfrnvmosndmv@klbhflkhdf', 'lkjfdv mkjdsf v', 'denied', 0, NULL),
(25, 'kjnkjn', 'n,nn,n ', 'kjlndfmv@jhbjkhbnjhbkjh', '126527777777', 'denied', 0, NULL),
(26, 'kjnkjn', 'n,nn,n ', 'kjlndfmv@jhbjkhbnjhbkjh', '126527777777', 'denied', 0, NULL),
(27, 'kjnkjn', 'n,nn,n ', 'kjlndfmv@jhbjkhbnjhbkjh', '126527777777', 'denied', 0, NULL),
(28, 'khaled', 'bakhti', 'khalloufimaram10@gmail.com', '97213594', 'denied', 0, NULL),
(29, 'khaled', 'bakhti', 'khalloufimaram10@gmail.com', '97213594', 'denied', 0, NULL),
(30, 'khaled', 'bakhti', 'khalloufimaram10@gmail.com', '97213594', 'denied', 0, NULL),
(31, 'khaled', 'jknrgvlksjdnv', 'maram.khalloufi@esprit.tn', '97213594', 'denied', 0, NULL),
(32, 'khaled', 'jknrgvlksjdnv', 'maram.khalloufi@esprit.tn', '97213594', 'denied', 0, NULL),
(33, 'khaled', 'bakhti', 'maram.khalloufi@esprit.tn', '97213594', 'denied', 0, NULL),
(34, 'khaled', 'bakhti', 'maram.khalloufi@esprit.tn', '97213594', 'denied', 0, NULL),
(35, 'khaled', 'bakhti', 'maram.khalloufi@esprit.tn', '97213594', 'denied', 0, NULL),
(36, 'jhji', 'ju', 'jjdng@gmail.com', '5265489', 'denied', 0, NULL),
(37, 'jhji', 'ju', 'jjdng@gmail.com', '86464897', 'denied', 0, NULL),
(38, 'jhji', 'ju', 'jjdng@gmail.com', '86464897', 'denied', 0, NULL),
(39, 'habib', 'habib', 'jjdng@gmail.com', '86464897', 'denied', 0, NULL),
(40, 'habib', 'habib', 'jjdng@gmail.com', '86464897', 'denied', 0, NULL),
(41, 'denya', 'ju jhji', 'jjdng@gmail.com', '86464897', 'denied', 0, NULL),
(42, 'eya', 'klouz', 'eyaklouz@gmail.com', '54585484', 'denied', 0, NULL),
(43, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(44, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(45, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(46, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(47, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(48, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(49, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(50, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(51, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(52, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(53, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(54, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(55, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(56, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(57, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(58, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(59, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(60, 'maram', 'qsfdsfd', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(61, 'opkqdsf', 'qpkosdf', 'dhaouadimedhbib@gmail.com', '95972453', 'approved', 0, NULL),
(62, 'opkqdsf', 'qpkosdf', 'dhaouadimedhbib@gmail.com', '95972453', 'approved', 0, NULL),
(63, 'opkqdsf', 'qpkosdf', 'dhaouadimedhbib@gmail.com', '95972453', 'approved', 0, NULL),
(64, 'opkqdsf', 'qpkosdf', 'dhaouadimedhbib@gmail.com', '95972453', 'approved', 0, NULL),
(65, 'opkqdsf', 'qpkosdf', 'dhaouadimedhbib@gmail.com', '95972453', 'approved', 0, NULL),
(66, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(67, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(68, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(69, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(70, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(71, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(72, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(73, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(74, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(75, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(76, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(77, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(78, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(79, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(80, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(81, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(82, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(83, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(84, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(85, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(86, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(87, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(88, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(89, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(90, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(91, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(92, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(93, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(94, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(95, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(96, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(97, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(98, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(99, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(100, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(101, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(102, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(103, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(104, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(105, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(106, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(107, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(108, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(109, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(110, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(111, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(112, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(113, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(114, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(115, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(116, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(117, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(118, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(119, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(120, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(121, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, NULL),
(122, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, 'dd8ded2d1f6141cca9e8ee80fa49e5e5'),
(123, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, '87fc8e1d6492bf5d01cc36a764bec900'),
(124, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, '09f05b0d6ce21e9b968768cd43422385'),
(125, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, '370d6144cee650ea5c66b03524937f3a'),
(126, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, '98efbd26ec591a85b3fb8a4907d4102f'),
(127, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 0, 'bc99b82e617884e69c4d3653cfc76e55'),
(128, 'Dhaouadi Mouhamed Habib', 'Dhaouadi Mouhamed Habib', 'dhaouadimedhbib@gmail.com', '96944669', 'approved', 1, 'f21d5d14be159bb394ec13ff65c1c773');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id_reservation` int(11) NOT NULL AUTO_INCREMENT,
  `debut_reservation` datetime NOT NULL,
  `fin_reservation` datetime NOT NULL,
  `description` text,
  `id_employe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_reservation`),
  KEY `id_employe` (`id_employe`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `debut_reservation`, `fin_reservation`, `description`, `id_employe`) VALUES
(26, '2024-12-08 17:11:00', '2024-12-11 17:12:00', 'Ã sdfds', 12),
(27, '2024-12-08 17:13:00', '2024-12-09 17:13:00', 'Ã§ipokjio', 60),
(28, '2024-12-08 17:13:00', '2024-12-10 17:13:00', 'oijhu', 46),
(29, '2024-12-08 17:34:00', '2024-12-08 17:34:00', '', 83);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`id_employe`) REFERENCES `employes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
