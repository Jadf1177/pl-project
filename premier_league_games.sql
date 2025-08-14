-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2025 at 01:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `premier_league_games`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(10) UNSIGNED NOT NULL,
  `match_id` int(11) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `match_id`, `user_name`, `user_email`, `comment`, `created_at`) VALUES
(1, 6, 'Kinan', 'kinanshams0@gmail.com', 'boring game Salah was playing like sh...!', '2025-08-09 11:21:26'),
(2, 13, 'Jad', 'jad@gmail.com', 'what a game from Halland!!!  scored a beautiful hattrick', '2025-08-10 23:07:20'),
(3, 14, 'Mhmd', 'mhmdf@hotmail.com', 'such a boring game', '2025-08-10 23:08:18'),
(4, 9, 'Kinan', 'kinanshams0@gmail.com', 'cant wait for this derby it will be a great game for sure!!!', '2025-08-10 23:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `id` int(10) UNSIGNED NOT NULL,
  `season` varchar(9) NOT NULL,
  `gameweek` smallint(5) UNSIGNED DEFAULT NULL,
  `match_date` date NOT NULL,
  `kickoff_time` time DEFAULT NULL,
  `venue` varchar(120) DEFAULT NULL,
  `home_team_id` int(10) UNSIGNED NOT NULL,
  `away_team_id` int(10) UNSIGNED NOT NULL,
  `home_score` tinyint(3) UNSIGNED DEFAULT NULL,
  `away_score` tinyint(3) UNSIGNED DEFAULT NULL,
  `status` enum('SCHEDULED','LIVE','FINISHED','POSTPONED','CANCELLED') NOT NULL DEFAULT 'SCHEDULED',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`id`, `season`, `gameweek`, `match_date`, `kickoff_time`, `venue`, `home_team_id`, `away_team_id`, `home_score`, `away_score`, `status`, `created_at`, `updated_at`) VALUES
(6, '2025-26', 1, '2025-08-09', '18:00:00', '', 34, 25, 4, 0, 'LIVE', '2025-08-08 22:27:21', '2025-08-10 23:05:26'),
(7, '2025-26', 1, '2025-08-16', '12:30:00', NULL, 24, 37, NULL, NULL, 'SCHEDULED', '2025-08-08 22:27:21', '2025-08-09 11:19:10'),
(8, '2025-26', 1, '2025-08-16', '15:00:00', NULL, 27, 31, NULL, NULL, 'CANCELLED', '2025-08-08 22:27:21', '2025-08-09 11:19:22'),
(9, '2025-26', 1, '2025-08-17', '15:00:00', NULL, 23, 40, NULL, NULL, 'SCHEDULED', '2025-08-08 22:27:21', '2025-08-08 22:27:21'),
(10, '2025-26', 2, '2025-08-23', '18:00:00', NULL, 24, 38, NULL, NULL, 'SCHEDULED', '2025-08-08 22:27:21', '2025-08-08 22:27:21'),
(11, '2025-26', 2, '2025-08-23', '18:00:00', NULL, 28, 39, NULL, NULL, 'SCHEDULED', '2025-08-08 22:27:21', '2025-08-08 22:27:21'),
(12, '2025-26', 2, '2025-08-23', '20:00:00', NULL, 31, 36, NULL, NULL, 'SCHEDULED', '2025-08-08 22:27:21', '2025-08-08 22:27:21'),
(13, '2025-26', 1, '2025-08-09', '12:00:00', '', 35, 32, 4, 0, 'FINISHED', '2025-08-08 22:27:21', '2025-08-10 23:05:02'),
(14, '2025-26', 1, '2025-08-09', '15:00:00', '', 30, 42, 3, 2, 'FINISHED', '2025-08-08 22:27:21', '2025-08-10 23:05:02');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `stadium` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `short_name`, `logo_url`, `stadium`) VALUES
(23, 'Arsenal', 'ARS', 'https://resources.premierleague.com/premierleague/badges/t3.svg', 'Emirates Stadium'),
(24, 'Aston Villa', 'AVL', 'https://resources.premierleague.com/premierleague/badges/t7.svg', 'Villa Park'),
(25, 'Bournemouth', 'BOU', 'https://resources.premierleague.com/premierleague/badges/t91.svg', 'Vitality Stadium'),
(26, 'Brentford', 'BRE', 'https://resources.premierleague.com/premierleague/badges/t94.svg', 'Gtech Community Stadium'),
(27, 'Brighton', 'BHA', 'https://resources.premierleague.com/premierleague/badges/t36.svg', 'Amex Stadium'),
(28, 'Chelsea', 'CHE', 'https://resources.premierleague.com/premierleague/badges/t8.svg', 'Stamford Bridge'),
(29, 'Crystal Palace', 'CRY', 'https://resources.premierleague.com/premierleague/badges/t31.svg', 'Selhurst Park'),
(30, 'Everton', 'EVE', 'https://resources.premierleague.com/premierleague/badges/t11.svg', 'Goodison Park'),
(31, 'Fulham', 'FUL', 'https://resources.premierleague.com/premierleague/badges/t54.svg', 'Craven Cottage'),
(32, 'Ipswich Town', 'IPS', 'https://resources.premierleague.com/premierleague/badges/t40.svg', 'Portman Road'),
(33, 'Leicester City', 'LEI', 'https://resources.premierleague.com/premierleague/badges/t13.svg', 'King Power Stadium'),
(34, 'Liverpool', 'LIV', 'https://resources.premierleague.com/premierleague/badges/t14.svg', 'Anfield'),
(35, 'Manchester City', 'MCI', 'https://resources.premierleague.com/premierleague/badges/t43.svg', 'Etihad Stadium'),
(36, 'Manchester Utd', 'MUN', 'https://resources.premierleague.com/premierleague/badges/t1.svg', 'Old Trafford'),
(37, 'Newcastle Utd', 'NEW', 'https://resources.premierleague.com/premierleague/badges/t4.svg', 'St James\' Park'),
(38, 'Nottingham Forest', 'NFO', 'https://resources.premierleague.com/premierleague/badges/t17.svg', 'City Ground'),
(39, 'Southampton', 'SOU', 'https://resources.premierleague.com/premierleague/badges/t20.svg', 'St Mary\'s Stadium'),
(40, 'Tottenham', 'TOT', 'https://resources.premierleague.com/premierleague/badges/t6.svg', 'Tottenham Hotspur Stadium'),
(41, 'West Ham', 'WHU', 'https://resources.premierleague.com/premierleague/badges/t21.svg', 'London Stadium'),
(42, 'Wolverhampton', 'WOL', 'https://resources.premierleague.com/premierleague/badges/t39.svg', 'Molineux Stadium');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_feedback_match` (`match_id`),
  ADD KEY `idx_feedback_created` (`created_at`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_fixture_once` (`season`,`gameweek`,`home_team_id`,`away_team_id`),
  ADD KEY `idx_match_date` (`match_date`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_home` (`home_team_id`),
  ADD KEY `idx_away` (`away_team_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_team_name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `fk_feedback_match` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `fk_matches_away_team` FOREIGN KEY (`away_team_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_matches_home_team` FOREIGN KEY (`home_team_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
