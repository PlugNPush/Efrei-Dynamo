-- --------------------------------------------------------
-- Hôte:                         192.168.0.5
-- Version du serveur:           8.0.25-0ubuntu0.20.04.1 - (Ubuntu)
-- SE du serveur:                Linux
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour efreidynamo
CREATE DATABASE IF NOT EXISTS `efreidynamo` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `efreidynamo`;

-- Listage de la structure de la table efreidynamo. majeures
CREATE TABLE IF NOT EXISTS `majeures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

-- Listage des données de la table efreidynamo.majeures : ~14 rows (environ)
/*!40000 ALTER TABLE `majeures` DISABLE KEYS */;
INSERT IGNORE INTO `majeures` (`id`, `nom`) VALUES
	(1, 'Cycle préparatoire / sans majeure'),
	(2, 'Software Engineering'),
	(3, 'Digital trasnformation'),
	(4, 'Cybersécurité, SI et gouvernance'),
	(5, 'Cybersécurité, infrastructure et logiciels'),
	(6, 'Big Data and Machine Learning'),
	(7, 'Network & Cloud Infrastructure'),
	(8, 'IT for Finance'),
	(9, 'Bio Informatique'),
	(10, 'Système robotiques et drones'),
	(11, 'Tranports intelligents'),
	(12, 'Imagerie et Réalité Virtuelle'),
	(13, 'Energies et Smartgrids'),
	(14, 'Business intelligence and Analytics');
/*!40000 ALTER TABLE `majeures` ENABLE KEYS */;

-- Listage de la structure de la table efreidynamo. matieres
CREATE TABLE IF NOT EXISTS `matieres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `majeure` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee` int NOT NULL,
  `module` int NOT NULL,
  `semestre` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb3;

-- Listage des données de la table efreidynamo.matieres : ~139 rows (environ)
/*!40000 ALTER TABLE `matieres` DISABLE KEYS */;
INSERT IGNORE INTO `matieres` (`id`, `majeure`, `nom`, `annee`, `module`, `semestre`) VALUES
	(1, 1, 'Structurer un écrit, prendre la parole', 1, 1, 1),
	(2, 1, 'Participation à la vie de l\'école', 1, 1, 1),
	(3, 1, 'English 1 - Technology and Society', 1, 1, 1),
	(4, 1, 'Langue vivante 2 - Japonnais', 1, 1, 1),
	(5, 1, 'Langue vivante 2 - Chinois', 1, 1, 1),
	(6, 1, 'Langue vivante 2 - Espagnol', 1, 1, 1),
	(7, 1, 'Langue vivante 2 - Allemand', 1, 1, 1),
	(8, 1, 'Fondamentaux de l\'algorithmique', 1, 2, 1),
	(9, 1, 'Programmation en Python', 1, 2, 1),
	(10, 1, 'Algèbre générale', 1, 3, 1),
	(11, 1, 'Analyse', 1, 3, 1),
	(12, 1, 'Introduction aux mathématiques du supérieur', 1, 3, 1),
	(13, 1, 'De l\'atome à la puce', 1, 4, 1),
	(14, 1, 'L\'éléctricité générale', 1, 4, 1),
	(15, 1, 'L\'information numérique', 1, 4, 1),
	(16, 1, 'Biologie fondamentale', 1, 6, 1),
	(17, 1, 'Bases de biochimie', 1, 6, 1),
	(18, 1, 'Economie et entreprise', 1, 1, 2),
	(19, 1, 'Argumentation, écriture créative', 1, 1, 2),
	(20, 1, 'Participation à la vie de l\'école', 1, 1, 2),
	(21, 1, 'English 2 -Issues in the English Speaking World', 1, 1, 2),
	(22, 1, 'Langue Vivante 2 - Japonnais', 1, 1, 2),
	(23, 1, 'Langue Vivante 2 - Chinois', 1, 1, 2),
	(24, 1, 'Langue Vivante 2 - Espagnol', 1, 1, 2),
	(25, 1, 'Langue Vivante 2 - Allemand', 1, 1, 2),
	(26, 1, 'Fondamentaux de l\'algorithmique 2', 1, 2, 2),
	(27, 1, 'Programmation en C', 1, 2, 2),
	(28, 1, 'Algèbre linéaire', 1, 3, 2),
	(29, 1, 'Sommes finies et infines', 1, 3, 2),
	(30, 1, 'Du système à la fonction', 1, 4, 2),
	(31, 1, 'L\'information : la voix et l\'image', 1, 4, 2),
	(32, 1, 'Mécanique', 1, 4, 2),
	(33, 1, 'Projet Transverse L1', 1, 7, 2),
	(34, 1, 'Stage d\'éxécution L1', 1, 8, 2),
	(35, 1, 'Biologie cellulaire 1', 1, 6, 2),
	(36, 1, 'Biologie moléculaire 1', 1, 6, 2),
	(37, 1, 'Question générale', 0, 20, 0),
	(38, 1, 'Propreté', 0, 20, 0),
	(39, 1, 'Signaler une irrégularité dans l\'école', 0, 20, 0),
	(40, 1, 'Journées portes ouvertes', 0, 20, 0),
	(41, 1, 'Associations', 0, 20, 0),
	(42, 1, 'Service comptabilité', 0, 20, 0),
	(43, 1, 'Student Hub', 0, 20, 0),
	(44, 1, 'Service informatique', 0, 20, 0),
	(45, 1, 'Service scolarité et planning', 0, 20, 0),
	(46, 1, 'Les comptes de l\'entreprise', 2, 1, 3),
	(47, 1, 'Histoire des Sciences', 2, 1, 3),
	(48, 1, 'Participation à la vie de l\'écolee', 2, 1, 3),
	(49, 1, 'Dissertation et critique d\'un essai ', 2, 1, 3),
	(50, 1, 'English 3-Scientific and Technical English', 2, 1, 3),
	(51, 1, 'Langue Vivante 2 - Japonais', 2, 1, 3),
	(52, 1, 'Langue Vivante 2 - Chinois', 2, 1, 3),
	(53, 1, 'Langue Vivante 2 - Espagnol', 2, 1, 3),
	(54, 1, 'Langue Vivante 2 - Allemand', 2, 1, 3),
	(55, 1, 'Séminaire en C', 2, 2, 3),
	(56, 1, 'Fondamentaux de l\'algorithmique 3', 2, 2, 3),
	(57, 1, 'Introduction au génie logiciel', 2, 2, 3),
	(58, 1, 'Fonctions de plusieurs variables', 2, 3, 3),
	(59, 1, 'Probabilités', 2, 3, 3),
	(60, 1, 'Champs électromagnétiques', 2, 4, 3),
	(61, 1, 'Physique moderne', 2, 4, 3),
	(62, 1, 'Systèmes de transmission', 2, 4, 3),
	(63, 1, 'Biologie cellulaire 2', 2, 6, 3),
	(64, 1, 'Biologie moléculaire 2', 2, 6, 3),
	(65, 1, 'Génomique et integration des données', 2, 6, 3),
	(66, 1, 'Organisation et processus', 2, 1, 4),
	(67, 1, 'Participation à la vie de l\'école', 2, 1, 4),
	(68, 1, 'Dissertation et rhétorique', 2, 1, 4),
	(69, 1, 'English 4-Preparation for the Study Abroad Program', 2, 1, 4),
	(70, 1, 'Langue vivante 2 - Japonais', 2, 1, 4),
	(71, 1, 'Langue vivante 2 - Chinois', 2, 1, 4),
	(72, 1, 'Langue vivante 2 - Espagnol', 2, 1, 4),
	(73, 1, 'Langue vivante 2 - Allemand', 2, 1, 4),
	(74, 1, 'Mathématiques pour l\'informatique', 2, 2, 4),
	(75, 1, 'Programmation Orientée Objets avec le langage Java', 2, 2, 4),
	(76, 1, 'Programmation WEB', 2, 2, 4),
	(77, 1, 'Analyse de données', 2, 3, 4),
	(78, 1, 'Modélisation mathématiques', 2, 3, 4),
	(79, 1, 'Propagation électromagnétique', 2, 4, 4),
	(80, 1, 'Systèmes numériques', 2, 4, 4),
	(81, 1, 'Thermodynamique', 2, 4, 4),
	(82, 1, 'Projet transverse L2', 2, 7, 4),
	(83, 1, 'Séminaire d\'orientation', 2, 8, 4),
	(84, 1, 'Biologie structurale et métabolique', 2, 6, 4),
	(85, 1, 'Afrique du Sud', 3, 9, 5),
	(86, 1, 'Angleterre', 3, 9, 5),
	(87, 1, 'Canada', 3, 9, 5),
	(88, 1, 'Inde', 3, 9, 5),
	(89, 1, 'Malaisie', 3, 9, 5),
	(90, 1, 'Pologne', 3, 9, 5),
	(91, 1, 'Hongrie', 3, 9, 5),
	(92, 1, 'République Tcheque', 3, 9, 5),
	(93, 1, 'Dissertation et culture d\'entreprise', 3, 1, 5),
	(94, 1, 'English 5 - Business English', 3, 1, 5),
	(95, 1, 'Introduction aux bases de données', 3, 10, 5),
	(96, 1, 'Introduction à la cybersécurité', 3, 10, 5),
	(97, 1, 'Les fondamentaux de langage JAVA', 3, 11, 5),
	(98, 1, 'Programmation web avancé', 3, 11, 5),
	(99, 1, 'Théorie des graphes', 3, 12, 5),
	(100, 1, 'Mathématique pour la Cryptographie', 3, 12, 5),
	(101, 1, 'Optimisation', 3, 12, 5),
	(102, 1, 'Théorie du signal 1', 3, 4, 5),
	(103, 1, 'Logique programmable', 3, 4, 5),
	(104, 1, 'Projet transverse L3', 3, 7, 5),
	(105, 1, 'Initiation à la recherche', 3, 7, 5),
	(106, 1, 'Statistique et bio-statistique', 3, 6, 5),
	(107, 1, 'Immunologie', 3, 6, 5),
	(108, 1, 'Databases', 3, 13, 6),
	(109, 1, 'Object-oriented Analysis & Design with UML', 3, 13, 6),
	(110, 1, 'Computer Architecture', 3, 14, 6),
	(111, 1, 'Networks and Protocols', 3, 14, 6),
	(112, 1, 'Operating Systems', 3, 14, 6),
	(113, 1, 'Canaux de transmission', 3, 4, 6),
	(114, 1, 'Systèmes linéaires', 3, 4, 6),
	(115, 1, 'Analyse financière', 3, 1, 6),
	(116, 1, 'Droit des sociétés et des contrats', 3, 1, 6),
	(117, 1, 'Dissertation et écriture créative', 3, 1, 6),
	(118, 1, 'English 6 - Business Communication', 3, 1, 6),
	(119, 1, 'Participation A la Vie de l’Ecole', 3, 1, 6),
	(120, 1, 'Langue vivante 2 - Japonais', 3, 1, 6),
	(121, 1, 'Langue vivante 2 - Chinois', 3, 1, 6),
	(122, 1, 'Langue vivante 2 - Espagnol', 3, 1, 6),
	(123, 1, 'Langue vivante 2 - Allemand', 3, 1, 6),
	(124, 1, 'Séminaire d’orientation', 3, 8, 6),
	(125, 1, 'Introduction au système Linux', 3, 15, 6),
	(126, 1, 'Introduction à l\'apprentissage Machine', 3, 15, 6),
	(127, 2, 'Question générale', 7, 16, 0),
	(128, 3, 'Question générale', 7, 16, 0),
	(129, 4, 'Question générale', 7, 16, 0),
	(130, 5, 'Question générale', 7, 16, 0),
	(131, 6, 'Question générale', 7, 16, 0),
	(132, 7, 'Question générale', 7, 16, 0),
	(133, 8, 'Question générale', 7, 16, 0),
	(134, 9, 'Question générale', 7, 16, 0),
	(135, 10, 'Question générale', 7, 16, 0),
	(136, 11, 'Question générale', 7, 16, 0),
	(137, 12, 'Question générale', 7, 16, 0),
	(138, 13, 'Question générale', 7, 16, 0),
	(139, 14, 'Question générale', 7, 16, 0);
/*!40000 ALTER TABLE `matieres` ENABLE KEYS */;

-- Listage de la structure de la table efreidynamo. modules
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

-- Listage des données de la table efreidynamo.modules : ~17 rows (environ)
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT IGNORE INTO `modules` (`id`, `nom`) VALUES
	(1, 'FORMATION GENERALE'),
	(2, 'INFORMATIQUE GENERALE'),
	(3, 'MATHEMATIQUES'),
	(4, 'PHYSIQUE ET ELECTRONIQUE'),
	(5, 'TOEIC BLANC'),
	(6, 'BIOLOGIE'),
	(7, 'PROJET TRANSVERSE'),
	(8, 'FORMATION PROFESSIONNELLE'),
	(9, 'SEMESTRE D\'IMMERSION A L\'INTERNATIONAL'),
	(10, 'INFORMATIQUE'),
	(11, 'INFORMATIQUE PROGRAMMATION'),
	(12, 'MATHEMATIQUES APPLIQUEES'),
	(13, 'INFORMATIQUE - APPLICATIONS'),
	(14, 'INFORMATIQUE - FONDAMENTAUX'),
	(15, 'ELECTIFS - INFORMATIQUE'),
	(16, 'ENSEIGNEMENT MASTER'),
	(20, 'CAMPUS');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;

-- Listage de la structure de la table efreidynamo. questions
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `auteur` int NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upvotes` int NOT NULL DEFAULT '0',
  `repondue` tinyint NOT NULL DEFAULT '0',
  `matiere` int NOT NULL,
  `date` datetime NOT NULL,
  `ban` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;

-- Listage de la structure de la table efreidynamo. reponses
CREATE TABLE IF NOT EXISTS `reponses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` int NOT NULL,
  `auteur` int NOT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upvotes` int NOT NULL DEFAULT '0',
  `downvotes` int NOT NULL DEFAULT '0',
  `validation` tinyint NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `ban` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb3;

-- Listage de la structure de la table efreidynamo. sanctions
CREATE TABLE IF NOT EXISTS `sanctions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int NOT NULL,
  `expiration` datetime NOT NULL,
  `utilisateur` int NOT NULL,
  `delateur` int NOT NULL,
  `publication` int DEFAULT NULL,
  `action` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb3;

-- Listage de la structure de la table efreidynamo. utilisateurs
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int NOT NULL,
  `annee` int NOT NULL,
  `majeure` int NOT NULL,
  `validation` tinyint NOT NULL DEFAULT '0',
  `karma` int NOT NULL DEFAULT '0',
  `inscription` datetime NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

-- Listage de la structure de la table efreidynamo. validations
CREATE TABLE IF NOT EXISTS `validations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
