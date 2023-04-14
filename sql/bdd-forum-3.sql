-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum_cd
CREATE DATABASE IF NOT EXISTS `forum_cd` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum_cd`;

-- Listage de la structure de table forum_cd. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

-- Listage des données de la table forum_cd.category : ~4 rows (environ)
INSERT INTO `category` (`id_category`, `name`) VALUES
	(1, 'Éducation et dressage'),
	(2, 'Santé du chien'),
	(3, 'Alimentation'),
	(21, 'Test');

-- Listage de la structure de table forum_cd. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `publishDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` text,
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `id_user` (`user_id`) USING BTREE,
  KEY `id_topic` (`topic_id`) USING BTREE,
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb3;

-- Listage des données de la table forum_cd.post : ~11 rows (environ)
INSERT INTO `post` (`id_post`, `publishDate`, `text`, `user_id`, `topic_id`) VALUES
	(1, '2023-03-30 07:17:53', 'Salut tout le monde, je viens d\'adopter un chiot et j\'aimerais savoir comment l\'entraîner à être obéissant. Avez-vous des conseils à partager ?', 1, 1),
	(2, '2023-03-30 07:19:14', 'Bienvenue ! J\'ai également un chien et j\'ai utilisé la méthode de la récompense pour l\'entraîner. En récompensant votre chien lorsqu\'il fait quelque chose de bien, vous renforcez son comportement positif', 2, 1),
	(3, '2023-04-05 10:59:17', 'Shibaba : Salut tout le monde, j\'aimerais savoir quel est la meilleure marque de croquette pour Shiba. Quelqu\'un peut-il me recommander une marque en particulier ?', 2, 3),
	(4, '2023-04-05 11:00:04', 'J\'ai personnellement utilisé la marque Purina pendant des années et j\'en suis très satisfait. Mes chiens shiba ont toujours été en bonne santé et ils aiment vraiment la nourriture.', 1, 3),
	(36, '2023-04-11 09:37:56', 'test 3 message 1', 42, 23),
	(51, '2023-04-12 14:27:30', 'test 3 message 2', 42, 23),
	(52, '2023-04-12 14:28:07', 'test 3 message 3', 42, 23),
	(54, '2023-04-12 17:03:35', 'Voici mes messages de test', 42, 30),
	(55, '2023-04-12 17:03:48', 'Autre message de test', 42, 31),
	(56, '2023-04-12 17:04:07', 'Pleins de message de test', 42, 32),
	(57, '2023-04-12 17:13:53', 'Autre blabla', 42, 32);

-- Listage de la structure de table forum_cd. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(70) NOT NULL,
  `publishDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lock` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `id_user` (`user_id`) USING BTREE,
  KEY `id_category` (`category_id`) USING BTREE,
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;

-- Listage des données de la table forum_cd.topic : ~7 rows (environ)
INSERT INTO `topic` (`id_topic`, `title`, `publishDate`, `lock`, `user_id`, `category_id`) VALUES
	(1, 'Éducation d’un chiot', '2023-03-30 09:16:23', 0, 1, 1),
	(2, 'Comment proteger mon chien en été', '2023-04-11 11:54:20', 0, 1, 2),
	(3, 'Choisir sa marque de croquette', '2023-04-05 10:58:09', 0, 2, 3),
	(23, 'test 3', '2023-04-11 09:37:56', 0, 42, 21),
	(30, 'test 1', '2023-04-12 17:03:35', 1, 42, 21),
	(31, 'test 2', '2023-04-12 17:03:47', 0, 42, 21),
	(32, 'Test 4', '2023-04-12 17:04:07', 1, 42, 21);

-- Listage de la structure de table forum_cd. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `role` varchar(15) NOT NULL,
  `userName` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstLoginDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3;

-- Listage des données de la table forum_cd.user : ~3 rows (environ)
INSERT INTO `user` (`id_user`, `role`, `userName`, `email`, `password`, `firstLoginDate`) VALUES
	(1, 'user', 'Yorkifan', 'yorkifan@yopmail.fr', 'Y0rksh1re15*', '2023-03-30 07:12:59'),
	(2, 'user', 'Suzuba', 'suzuba@yopmail.fr', 'Shi8a999/', '2023-03-30 07:14:41'),
	(42, 'user', 'tester42', 'tester@testmail.com', '123456*', '2023-04-12 11:37:57');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
