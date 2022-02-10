-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 10 fév. 2022 à 13:56
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestioncompte`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `intitule` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `idUser`, `intitule`, `description`) VALUES
(1, 17, 'Courses', 'blabla'),
(2, 17, 'Loyer', 'blabla'),
(10, 17, 'CAF', 'test\n'),
(11, 17, 'Salaire', ''),
(12, 17, 'testDEFOU2', 'zqdzqdz'),
(13, 17, 'tes', ''),
(14, 17, 'efsfes', ''),
(16, 17, 'fesfesf', ''),
(17, 17, 'fesfesfesf', ''),
(18, 17, 'fsefesf', ''),
(20, 17, 'regqerg', 'rqegreg'),
(21, 17, 'test', 'efzef'),
(23, 17, 'test', ''),
(25, 16, 'test', 'drgrdg'),
(26, 17, 'efzf', ''),
(27, 17, 'ezfezf', ''),
(28, 17, 'ezfzefze', ''),
(30, 17, 'ezfezf', ''),
(31, 17, 'ezfezf', ''),
(32, 17, 'zefezf', ''),
(33, 17, 'Loyer', 'une description'),
(34, 17, 'Loyer', 'test'),
(35, 17, 'stfdhtf', 'htfhtfh'),
(36, 17, 'htfhtf', 'htfhtfhth'),
(37, 17, 'tfhtfh', 'thfhtfh'),
(38, 17, 'Test', 'aaaaaaa'),
(39, 17, 'aaaaaa', 'aaa'),
(40, 17, 'aaaa', '');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `prix` float NOT NULL,
  `type` int(11) NOT NULL COMMENT '1:depenses,2:revenu',
  `idCategorie` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  `dateAjout` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `prix`, `type`, `idCategorie`, `commentaire`, `dateAjout`, `idUser`) VALUES
(1, 2504, 1, 2, 'ça fait mal', 1643121783, 17),
(7, 180, 1, 1, 'Ma ptite veste The North Face <3', 1643187307, 17),
(8, 360, 2, 10, 'merci la caf <3', 1643065200, 17),
(10, 930, 2, 11, '', 1643188153, 17),
(18, 10, 1, 13, '', 1643275096, 17),
(19, 542, 1, 1, '', 1643275100, 17),
(20, 82, 1, 10, '', 1643275104, 17),
(21, 120, 1, 14, '', 1643275109, 17),
(22, 50, 1, 11, '', 1643275115, 17),
(23, 543, 1, 10, '', 1643275119, 17),
(24, 369, 1, 2, '', 1643275123, 17),
(25, 520, 1, 11, 'test', 1643275129, 17),
(26, 180.54, 2, 11, 'waw', 1643275694, 17),
(27, 152, 1, 11, 'cwscswc', 1643324400, 17),
(28, 452, 1, 12, 'rdgdrgdr', 1642978800, 17),
(30, 250, 1, 11, '', 1642978800, 17),
(31, 400, 2, 11, '', 1642978800, 17);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` varchar(1000) NOT NULL,
  `numTel` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `type`, `mail`, `mdp`, `numTel`) VALUES
(16, 'ottavi', 'alexis', 'USER', 'alexisottavi@gmail.com', '$2y$10$8lK9CAUcARYMJkXeBBxDE.hqaCTSN5nKUj6dtsZYv5UvYNzQo8ZhK', ''),
(17, 'ottavi', 'alexis', 'USER', 'hisuko17@gmail.com', '$2y$10$hxWMDd6A2B7k/DsZ9oXgbeQJw8yJDuIFhiZTGgt0AKlk6PZU0Fhju', ''),
(20, 'OTTAVI', 'Alexis', 'USER', 'aa@gg.com', '$2y$10$COcRchxFxAaGtWomSbfrSuEI/sIeFvlqY1LtlvDpeTKi8I6C.VXR.', ''),
(23, 'aa', 'aa', 'USER', 'aa@gmail.com', '$2y$10$Ez/EIzNCLOM0O2HP1BRXMOX3T0Wz.eKwGkTU9hJ.3nVgM1OAuIuDq', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `intitule` (`intitule`),
  ADD KEY `description` (`description`(768)),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prix` (`prix`),
  ADD KEY `type` (`type`),
  ADD KEY `commentaire` (`commentaire`(768)),
  ADD KEY `dateAjout` (`dateAjout`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nom` (`nom`),
  ADD KEY `prenom` (`prenom`),
  ADD KEY `type` (`type`),
  ADD KEY `mail` (`mail`),
  ADD KEY `mdp` (`mdp`(768)),
  ADD KEY `numTel` (`numTel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
