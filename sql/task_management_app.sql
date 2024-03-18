-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 18 mars 2024 à 17:13
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `first_name`, `last_name`, `last_connexion`) VALUES
(1, '555', 'doe_seb@gmail.com', '$2y$10$YZfbBPK94N81VnAlm1TIhuJeU37R5OGOgh7UjLSBE11MJtx.JzD4O', '2024-03-17 20:49:46', 'Sebastion', 'Doe', '2024-03-17 21:49:46'),
(2, 'nicoo', 'nicoo_dupont@gmail.com', '$2y$10$ChGKr3dKHsMuvs/bM4v71.87ZdWqaPbWV39S87wPprV8rCmVWz78y', '2024-03-17 20:52:55', 'Nicolas', 'Dupont', '2024-03-17 21:52:55'),
(3, '564654', 'ray_joee@gmail.com', '$2y$10$4rY.FEElITOGuOXUNCZEWe773HEOfyrggqYvxVO6rQfhUmd952xQe', '2024-03-17 21:00:42', 'Joey', 'Ray', '2024-03-17 22:00:42'),
(4, 'john', 'john_doee@gmail.com', '$2y$10$dVLK6LVgGGXcHXKgcTGEtOzH54Ay5XDNKeq1bA3vwWbxAB0Zp.z4G', '2024-03-17 21:04:46', 'Johnny', 'Doee', '2024-03-17 22:04:46'),
(5, '564654', 'ray_johnn@gmail.com', '$2y$10$9nzR6eX7OChQgpn2QmykRuYqd5nvkMG9an0Eu6Uv/cf6K7IlsDeV.', '2024-03-17 21:06:28', 'Joeyy', 'Rayy', '2024-03-17 22:06:28'),
(6, '56465455', 'ray_johnnn@gmail.com', '$2y$10$lM1IpC.uASUMyRPO3SozLOplhKOiQsPhrTzJtAqCU5V3ZlF5hh7RS', '2024-03-18 02:59:46', 'Joeyy', 'Rayy', '2024-03-18 04:23:14'),
(7, 'Inees', 'ines.kaa@gmail.com', '$2y$10$FFd.qPwqUU1lSX4kUF/eW.oaW9sEyAv7acKI0i0ATe34NzM5.lGRC', '2024-03-18 03:04:02', 'Ines', 'Ka', '2024-03-18 05:41:19'),
(8, 'user123', 'nicole_louia@gmail.com', '$2y$10$WPsdXi90vWjLpNAyfoqOCu7.h0QJwKNc6d6SZmapKroz2P.2b9aPS', '2024-03-18 03:10:42', 'Nicole', 'Louia', '2024-03-18 04:10:42');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
