-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2025 at 08:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kurssienhallinta`
--

-- --------------------------------------------------------

--
-- Table structure for table `ilmoittautuminen`
--

CREATE TABLE `ilmoittautuminen` (
  `ilmoittautuminen_id` int(11) NOT NULL,
  `opiskelija_id` int(11) NOT NULL,
  `kurssi_id` int(11) NOT NULL,
  `ilmoittautumispaiva` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ilmoittautuminen`
--

INSERT INTO `ilmoittautuminen` (`ilmoittautuminen_id`, `opiskelija_id`, `kurssi_id`, `ilmoittautumispaiva`) VALUES
(1, 1, 1, '2025-10-21 09:16:46'),
(2, 1, 2, '2025-10-21 09:16:46'),
(3, 2, 1, '2025-10-21 09:16:46'),
(4, 2, 3, '2025-10-21 09:16:46'),
(5, 3, 2, '2025-10-21 09:16:46'),
(6, 3, 3, '2025-10-21 09:16:46'),
(7, 3, 5, '2025-10-21 09:16:46'),
(8, 4, 1, '2025-10-21 09:16:46'),
(9, 4, 4, '2025-10-21 09:16:46'),
(10, 5, 2, '2025-10-21 09:16:46'),
(11, 5, 3, '2025-10-21 09:16:46'),
(12, 6, 3, '2025-10-21 09:16:46'),
(13, 6, 5, '2025-10-21 09:16:46'),
(14, 7, 1, '2025-10-21 09:16:46'),
(15, 7, 2, '2025-10-21 09:16:46'),
(16, 8, 2, '2025-10-21 09:16:46'),
(17, 8, 4, '2025-10-21 09:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `kurssit`
--

CREATE TABLE `kurssit` (
  `kurssi_id` int(11) NOT NULL,
  `kurssin_tunnus` varchar(20) NOT NULL,
  `kurssi_nimi` varchar(100) NOT NULL,
  `kurssikuvaus` text DEFAULT NULL,
  `aloituspaiva` date NOT NULL,
  `lopetuspaiva` date NOT NULL,
  `opettaja_id` int(11) NOT NULL,
  `tila_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kurssit`
--

INSERT INTO `kurssit` (`kurssi_id`, `kurssin_tunnus`, `kurssi_nimi`, `kurssikuvaus`, `aloituspaiva`, `lopetuspaiva`, `opettaja_id`, `tila_id`) VALUES
(1, 'MAT101', 'Matematiikan perusteet', 'Peruslaskutoimitukset ja algebra', '2025-01-15', '2025-05-30', 1, 1),
(2, 'OHJ201', 'Ohjelmointi 1', 'Johdatus ohjelmointiin Python-kielellä', '2025-01-20', '2025-05-25', 2, 2),
(3, 'FYS301', 'Fysiikka 1', 'Mekaniikka ja lämpöoppi', '2025-02-01', '2025-06-15', 3, 3),
(4, 'KEM401', 'Kemia 1', 'Orgaaninen kemia', '2025-01-10', '2025-05-20', 4, 4),
(5, 'TIK501', 'Tietokannat', 'SQL ja tietokantasuunnittelu', '2025-02-05', '2025-06-10', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `opettajat`
--

CREATE TABLE `opettajat` (
  `opettaja_id` int(11) NOT NULL,
  `etunimi` varchar(50) NOT NULL,
  `sukunimi` varchar(50) NOT NULL,
  `aine` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opettajat`
--

INSERT INTO `opettajat` (`opettaja_id`, `etunimi`, `sukunimi`, `aine`) VALUES
(1, 'Matti', 'Virtanen', 'Matematiikka'),
(2, 'Liisa', 'Korhonen', 'Ohjelmointi'),
(3, 'Pekka', 'Nieminen', 'Fysiikka'),
(4, 'Anna', 'Mäkinen', 'Kemia'),
(5, 'Juha', 'Lehtonen', 'Tietotekniikka');

-- --------------------------------------------------------

--
-- Table structure for table `oppilaat`
--

CREATE TABLE `oppilaat` (
  `oppilas_id` int(11) NOT NULL,
  `etunimi` varchar(50) NOT NULL,
  `sukunimi` varchar(50) NOT NULL,
  `syntymaaika` date NOT NULL,
  `vuosikurssi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oppilaat`
--

INSERT INTO `oppilaat` (`oppilas_id`, `etunimi`, `sukunimi`, `syntymaaika`, `vuosikurssi`) VALUES
(1, 'Eetu', 'Saarinen', '2006-03-15', 1),
(2, 'Emma', 'Virtanen', '2005-07-22', 2),
(3, 'Mikko', 'Korhonen', '2004-11-08', 3),
(4, 'Aino', 'Nieminen', '2006-01-30', 1),
(5, 'Ville', 'Mäkinen', '2005-09-12', 2),
(6, 'Saara', 'Lehtonen', '2004-05-18', 3),
(7, 'Oskari', 'Koskinen', '2006-08-25', 1),
(8, 'Liisa', 'Järvinen', '2005-12-03', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tilat`
--

CREATE TABLE `tilat` (
  `tila_id` int(11) NOT NULL,
  `tila_nimi` varchar(50) NOT NULL,
  `paikkoja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tilat`
--

INSERT INTO `tilat` (`tila_id`, `tila_nimi`, `paikkoja`) VALUES
(1, 'A101', 30),
(2, 'A102', 25),
(3, 'B205', 40),
(4, 'B206', 20),
(5, 'C303', 35);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ilmoittautuminen`
--
ALTER TABLE `ilmoittautuminen`
  ADD PRIMARY KEY (`ilmoittautuminen_id`),
  ADD UNIQUE KEY `opiskelija_id` (`opiskelija_id`,`kurssi_id`),
  ADD KEY `kurssi_id` (`kurssi_id`);

--
-- Indexes for table `kurssit`
--
ALTER TABLE `kurssit`
  ADD PRIMARY KEY (`kurssi_id`),
  ADD UNIQUE KEY `kurssin_tunnus` (`kurssin_tunnus`),
  ADD KEY `opettaja_id` (`opettaja_id`),
  ADD KEY `tila_id` (`tila_id`);

--
-- Indexes for table `opettajat`
--
ALTER TABLE `opettajat`
  ADD PRIMARY KEY (`opettaja_id`);

--
-- Indexes for table `oppilaat`
--
ALTER TABLE `oppilaat`
  ADD PRIMARY KEY (`oppilas_id`);

--
-- Indexes for table `tilat`
--
ALTER TABLE `tilat`
  ADD PRIMARY KEY (`tila_id`),
  ADD UNIQUE KEY `tila_nimi` (`tila_nimi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ilmoittautuminen`
--
ALTER TABLE `ilmoittautuminen`
  MODIFY `ilmoittautuminen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kurssit`
--
ALTER TABLE `kurssit`
  MODIFY `kurssi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `opettajat`
--
ALTER TABLE `opettajat`
  MODIFY `opettaja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `oppilaat`
--
ALTER TABLE `oppilaat`
  MODIFY `oppilas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tilat`
--
ALTER TABLE `tilat`
  MODIFY `tila_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ilmoittautuminen`
--
ALTER TABLE `ilmoittautuminen`
  ADD CONSTRAINT `ilmoittautuminen_ibfk_1` FOREIGN KEY (`opiskelija_id`) REFERENCES `oppilaat` (`oppilas_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ilmoittautuminen_ibfk_2` FOREIGN KEY (`kurssi_id`) REFERENCES `kurssit` (`kurssi_id`) ON DELETE CASCADE;

--
-- Constraints for table `kurssit`
--
ALTER TABLE `kurssit`
  ADD CONSTRAINT `kurssit_ibfk_1` FOREIGN KEY (`opettaja_id`) REFERENCES `opettajat` (`opettaja_id`),
  ADD CONSTRAINT `kurssit_ibfk_2` FOREIGN KEY (`tila_id`) REFERENCES `tilat` (`tila_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
