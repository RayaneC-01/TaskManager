-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 24 mars 2024 à 23:08
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `task_management_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(30) NOT NULL,
  `due_date` date DEFAULT NULL,
  `completed` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `last_connexion` datetime DEFAULT CURRENT_TIMESTAMP,
  `priority` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `due_date`, `completed`, `created_at`, `last_connexion`, `priority`) VALUES
(7, 11, 'Finir Dossier', '2025-05-12', 0, '2024-03-22 00:08:05', '2024-03-22 00:08:05', 3),
(18, 10, 'Test123445', '2024-03-25', 0, '2024-03-24 17:04:02', '2024-03-24 17:04:02', 3),
(11, 11, 'Finir Dossier', '2025-05-12', 0, '2024-03-22 01:29:54', '2024-03-22 01:29:54', 3),
(19, 10, 'rendre rapportt', '2024-03-25', 0, '2024-03-24 22:52:00', '2024-03-24 22:52:00', 1),
(16, 12, 'Finir Dossier', '2025-05-12', 0, '2024-03-23 01:48:09', '2024-03-23 01:48:09', 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `last_connexion` datetime DEFAULT CURRENT_TIMESTAMP,
  `reset_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `first_name`, `last_name`, `last_connexion`, `reset_token`) VALUES
(9, 'Joee', 'joe_du@gmail.com', '$2y$10$15jXA4U3WRfxoqRMlC4I.umvvfZ2C3RaH/FnCjZj.9Vg3Y/m6cKDO', '2024-03-20 23:04:32', 'Joe', 'Dupontt', '2024-03-23 00:01:21', NULL),
(10, 'Inees', 'ines.kaa@gmail.com', '$2y$10$CO/gq/2J4AJ3VpqI1Iueaehkdnt0SuwLQoWKRcQKcZVeQdX1mSHf2', '2024-03-20 23:06:15', 'Ines', 'Ka', '2024-03-25 00:03:41', NULL),
(11, 'seeeb', 'doe_seb@gmail.com', '$2y$10$BSUksTBusIeVW4Ls3q6EqeB3VnaGYkhVVS6jm4sjaKzwUsrdnHi6S', '2024-03-21 17:14:46', 'Sebastion', 'Doe', '2024-03-22 01:29:35', NULL),
(12, 'RayJoe', 'ray_johnn@gmail.com', '$2y$10$9puzUZiVSmPm/cte2n.GGuwNtvRo7TFe.hfvwBg02n3NOaP7LUMtm', '2024-03-23 00:47:41', 'Joeyy', 'Rayy', '2024-03-23 01:49:33', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
