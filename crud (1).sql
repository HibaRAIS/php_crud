-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 05 jan. 2024 à 02:13
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crud`
--

-- --------------------------------------------------------

--
-- Structure de la table `shared_tasks`
--

CREATE TABLE `shared_tasks` (
  `shared_task_id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `shared_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `shared_tasks`
--

INSERT INTO `shared_tasks` (`shared_task_id`, `task_id`, `shared_user_id`) VALUES
(1, 14, 8),
(2, 14, 6),
(3, 8, 1),
(4, 8, 6),
(5, 8, 6);

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `task_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completion_date` timestamp NULL DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`task_id`, `user_id`, `task_description`, `created_at`, `completion_date`, `owner_id`) VALUES
(8, 3, 'faire les devoirs', '2023-12-08 21:48:01', '2023-12-30 08:00:28', NULL),
(11, 9, 'nsawb dfari (faux ongles)', '2023-12-08 22:49:18', NULL, NULL),
(13, 10, 'bghit nn3s', '2023-12-08 23:01:30', NULL, NULL),
(14, 1, 'faire les tps', '2023-12-09 07:47:38', '2023-12-29 02:26:43', NULL),
(15, 1, 'faire les devoirs', '2023-12-09 07:47:53', '2023-12-29 01:58:04', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'hiba', 'hiba', 'hiba@gmail.com'),
(3, 'imad', 'imad', 'imad03@gmail.com'),
(4, 'said', 'said', 'said03@gmail.com'),
(5, 'him', 'him', 'himhim@gmail.com'),
(6, 'rais', 'rais', 'rais@gmail.com'),
(7, 'rachid', 'racid', 'rachid03@gmail.com'),
(8, 'nahid', 'nahid', 'nahid@gmail.com'),
(9, 'amira', 'amirazwina', 'amiraamira@gmail.com'),
(10, 'yassir', 'yassir', 'yassir@gmail.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `shared_tasks`
--
ALTER TABLE `shared_tasks`
  ADD PRIMARY KEY (`shared_task_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `shared_user_id` (`shared_user_id`);

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `shared_tasks`
--
ALTER TABLE `shared_tasks`
  MODIFY `shared_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `shared_tasks`
--
ALTER TABLE `shared_tasks`
  ADD CONSTRAINT `shared_tasks_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`),
  ADD CONSTRAINT `shared_tasks_ibfk_2` FOREIGN KEY (`shared_user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
