-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2025 at 10:32 AM
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
(17, 8, 4, '2025-10-21 09:16:46'),
(18, 39, 12, '2025-06-20 11:54:29'),
(19, 35, 26, '2025-10-21 09:16:46'),
(20, 43, 1, '2025-10-21 09:18:46'),
(21, 37, 30, '2025-06-20 17:54:29'),
(22, 9, 25, '2025-10-21 09:16:46'),
(23, 53, 24, '2025-10-22 12:03:59'),
(24, 46, 2, '2025-06-20 11:54:29'),
(25, 10, 4, '2025-06-20 11:54:29'),
(26, 2, 16, '2025-10-21 09:16:46'),
(27, 14, 28, '2025-06-20 22:54:29'),
(28, 50, 26, '2025-06-20 22:54:29'),
(29, 23, 29, '2025-10-21 09:16:46'),
(30, 16, 22, '2025-06-20 16:54:29'),
(31, 45, 15, '2025-06-10 16:54:29'),
(32, 51, 16, '2025-06-20 16:54:29'),
(33, 55, 3, '2025-06-15 15:54:29'),
(34, 54, 1, '2025-06-15 15:54:29'),
(35, 47, 24, '2025-06-15 15:54:54'),
(36, 44, 4, '2025-01-16 21:23:32'),
(37, 19, 21, '2025-01-16 21:23:32'),
(38, 23, 19, '2025-10-21 09:18:46'),
(39, 11, 3, '2025-01-16 21:23:33'),
(40, 36, 1, '2025-01-16 21:23:34'),
(41, 46, 21, '2025-01-16 21:23:35'),
(42, 31, 27, '2025-01-15 21:24:32'),
(43, 2, 30, '2025-01-15 21:24:32'),
(44, 35, 28, '2025-01-15 21:24:36'),
(45, 45, 20, '2025-02-15 21:24:32'),
(46, 8, 23, '2025-03-15 21:24:35'),
(47, 30, 12, '2025-03-15 21:24:34'),
(48, 48, 12, '2025-03-15 21:24:34'),
(49, 3, 24, '2025-03-15 21:24:37'),
(50, 29, 26, '2025-02-15 16:24:34'),
(51, 17, 23, '2025-02-15 16:24:36'),
(52, 43, 24, '2025-02-15 14:24:34'),
(53, 19, 30, '2025-02-15 14:24:35'),
(54, 15, 5, '2025-02-15 15:24:34'),
(55, 55, 15, '2025-02-15 14:26:24'),
(56, 49, 12, '2025-02-13 12:24:34'),
(57, 2, 28, '2025-02-13 12:24:34'),
(58, 38, 3, '2025-02-13 12:44:54'),
(59, 31, 19, '2025-02-17 13:44:34'),
(60, 25, 18, '2025-01-22 23:04:22'),
(61, 50, 27, '2025-01-22 23:04:22'),
(62, 52, 5, '2025-01-22 12:04:22'),
(63, 18, 20, '2025-01-28 11:23:22'),
(64, 53, 18, '2025-02-17 13:44:34'),
(65, 54, 24, '2025-01-28 11:23:22'),
(66, 48, 26, '2025-01-28 11:23:26'),
(67, 24, 5, '2025-01-10 15:26:22'),
(68, 40, 14, '2025-02-13 12:24:34'),
(69, 51, 6, '2025-01-22 18:54:45'),
(70, 30, 2, '2025-02-17 13:44:34'),
(71, 16, 5, '2025-01-22 23:04:22'),
(72, 57, 18, '2025-01-03 19:53:32'),
(73, 58, 7, '2025-01-27 14:41:21'),
(74, 19, 17, '2025-01-26 12:11:19'),
(75, 48, 14, '2025-01-25 12:23:22'),
(76, 20, 4, '2025-01-04 16:17:18'),
(77, 55, 6, '2025-01-26 18:15:11'),
(78, 21, 1, '2025-01-22 23:04:22'),
(79, 40, 3, '2025-01-10 21:13:14'),
(80, 22, 19, '2025-02-17 13:44:34'),
(81, 21, 7, '2025-10-22 12:03:58'),
(82, 6, 22, '2025-10-22 12:03:58'),
(323, 52, 38, '2025-10-22 12:03:58'),
(324, 47, 38, '2025-10-22 12:03:58'),
(325, 20, 38, '2025-10-22 12:03:58'),
(326, 30, 38, '2025-10-22 12:03:58'),
(327, 19, 38, '2025-10-22 12:03:58'),
(328, 54, 38, '2025-10-22 12:03:58'),
(329, 32, 38, '2025-10-22 12:03:58'),
(330, 35, 38, '2025-10-22 12:03:58'),
(331, 8, 38, '2025-10-22 12:03:58'),
(332, 14, 38, '2025-10-22 12:03:58'),
(333, 33, 38, '2025-10-22 12:03:58'),
(334, 56, 38, '2025-10-22 12:03:58'),
(335, 34, 38, '2025-10-22 12:03:58'),
(336, 31, 38, '2025-10-22 12:03:58'),
(337, 36, 38, '2025-10-22 12:03:58'),
(338, 44, 38, '2025-10-22 12:03:58'),
(339, 43, 38, '2025-10-22 12:03:58'),
(340, 26, 38, '2025-10-22 12:03:58'),
(341, 16, 38, '2025-10-22 12:03:58'),
(342, 50, 38, '2025-10-22 12:03:58'),
(343, 51, 38, '2025-10-22 12:03:58'),
(344, 21, 38, '2025-10-22 12:03:58'),
(345, 3, 38, '2025-10-22 12:03:58'),
(346, 7, 38, '2025-10-22 12:03:58'),
(347, 22, 38, '2025-10-22 12:03:58');

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
(5, 'TIK501', 'Tietokannat', 'SQL ja tietokantasuunnittelu', '2025-02-05', '2025-06-10', 5, 5),
(6, 'MAT201', 'Matematiikka 2', 'Trigonometria ja analyyttinen geometria', '2025-01-15', '2025-05-30', 1, 1),
(7, 'OHJ301', 'Ohjelmointi 2', 'Olioohjelmointi Java-kielellä', '2025-01-20', '2025-05-25', 2, 2),
(12, 'MAT301', 'Matematiikka 3', 'Differentiaali- ja integraalilaskenta', '2025-02-01', '2025-06-15', 1, 1),
(14, 'OHJ401', 'Web-ohjelmointi', 'HTML, CSS ja JavaScript', '2025-02-05', '2025-06-10', 2, 2),
(15, 'FYS201', 'Fysiikka 2', 'Sähköoppi ja magnetismi', '2025-01-10', '2025-05-20', 3, 3),
(16, 'FYS401', 'Fysiikka 4', 'Aaltoliike ja optiikka', '2025-02-15', '2025-06-20', 3, 3),
(17, 'KEM201', 'Kemia 2', 'Epäorgaaninen kemia ja hapot', '2025-01-25', '2025-05-30', 4, 4),
(18, 'KEM301', 'Kemia 3', 'Orgaaninen kemia', '2025-02-10', '2025-06-05', 4, 4),
(19, 'TIK201', 'Tietokannat', 'SQL ja tietokantasuunnittelu', '2025-01-15', '2025-05-15', 5, 5),
(20, 'TIK301', 'Tietoverkot', 'Internet ja verkkoprotokollat', '2025-02-20', '2025-06-10', 5, 5),
(21, 'KUV101', 'Kuvataide 1', 'Piirustus ja maalaus', '2025-03-01', '2025-06-25', 6, 1),
(22, 'KUV201', 'Kuvataide 2', 'Digitaalinen kuvankäsittely', '2025-01-20', '2025-05-20', 14, 2),
(23, 'ÄI201', 'Äidinkieli 2', 'Kielioppi ja kirjoittaminen', '2025-02-15', '2025-06-15', 7, 3),
(24, 'ÄI301', 'Kirjallisuus 1', 'Suomalainen kirjallisuus', '2025-01-30', '2025-05-30', 10, 3),
(25, 'YH101', 'Yhteiskuntaoppi 1', 'Suomen yhteiskuntajärjestelmä', '2025-03-05', '2025-06-20', 8, 4),
(26, 'RUO201', 'Ruotsi 2', 'Keskustelutaidot', '2025-02-01', '2025-05-25', 9, 5),
(27, 'RUO301', 'Ruotsi 3', 'Kirjoittaminen ja ymmärtäminen', '2025-03-10', '2025-06-10', 9, 5),
(28, 'HIS201', 'Historia 2', 'Suomen itsenäisyys', '2025-01-15', '2025-05-15', 11, 1),
(29, 'HIS301', 'Historia 3', 'Toinen maailmansota', '2025-02-20', '2025-06-05', 11, 1),
(30, 'ENG301', 'Englanti 3', 'Keskustelutaidot', '2025-01-25', '2025-05-20', 12, 2),
(31, 'ENG401', 'Englanti 4', 'Akateeminen kirjoittaminen', '2025-03-01', '2025-06-15', 13, 2),
(32, 'KÄS101', 'Käsityö 1', 'Puutyöt', '2025-02-15', '2025-06-20', 15, 3),
(33, 'MAA101', 'Maantieto 1', 'Fyysinen maantieto', '2025-01-20', '2025-05-25', 16, 4),
(34, 'US101', 'Uskonto 1', 'Maailmanuskonnot', '2025-03-05', '2025-06-25', 17, 5),
(35, 'US201', 'Uskonto 2', 'Etiikka ja moraali', '2025-02-10', '2025-06-10', 18, 5),
(36, 'LII201', 'Liikunta 2', 'Joukkuelajit', '2025-01-15', '2025-05-30', 19, 1),
(37, 'BIO201', 'Biologia 2', 'Ekologia ja ympäristö', '2025-02-01', '2025-06-15', 20, 2),
(38, 'TEST999', 'Ylitäysi testikaurssi', 'Testi kapasiteetille', '2025-03-01', '2025-06-01', 1, 4);

-- --------------------------------------------------------

--
-- Stand-in structure for view `nakyma_kaynnissa_olevat_kurssit`
-- (See below for the actual view)
--
CREATE TABLE `nakyma_kaynnissa_olevat_kurssit` (
`kurssi_nimi` varchar(100)
,`kurssin_tunnus` varchar(20)
,`aloituspaiva` date
,`lopetuspaiva` date
,`opettaja` varchar(101)
,`tila_nimi` varchar(50)
,`ilmoittautuneet` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `nakyma_kurssit_taydellinen`
-- (See below for the actual view)
--
CREATE TABLE `nakyma_kurssit_taydellinen` (
`kurssi_id` int(11)
,`kurssin_tunnus` varchar(20)
,`kurssi_nimi` varchar(100)
,`kurssikuvaus` text
,`aloituspaiva` date
,`lopetuspaiva` date
,`opettaja` varchar(101)
,`opettajan_aine` varchar(100)
,`tila_nimi` varchar(50)
,`tilan_kapasiteetti` int(11)
,`ilmoittautuneet` bigint(21)
,`vapaita_paikkoja` bigint(22)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `nakyma_opettajat_kurssit`
-- (See below for the actual view)
--
CREATE TABLE `nakyma_opettajat_kurssit` (
`opettaja_id` int(11)
,`opettaja` varchar(101)
,`aine` varchar(100)
,`kurssien_maara` bigint(21)
,`kurssit` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `nakyma_opiskelijat_aktiivisuus`
-- (See below for the actual view)
--
CREATE TABLE `nakyma_opiskelijat_aktiivisuus` (
`oppilas_id` int(11)
,`opiskelija` varchar(101)
,`vuosikurssi` int(11)
,`kurssien_maara` bigint(21)
,`aktiivisuus_taso` varchar(14)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `nakyma_opiskelijat_kurssit`
-- (See below for the actual view)
--
CREATE TABLE `nakyma_opiskelijat_kurssit` (
`oppilas_id` int(11)
,`opiskelija` varchar(101)
,`vuosikurssi` int(11)
,`kurssi_nimi` varchar(100)
,`kurssin_tunnus` varchar(20)
,`aloituspaiva` date
,`lopetuspaiva` date
,`opettaja` varchar(101)
,`ilmoittautumispaiva` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `nakyma_tilat_kaytto`
-- (See below for the actual view)
--
CREATE TABLE `nakyma_tilat_kaytto` (
`tila_id` int(11)
,`tila_nimi` varchar(50)
,`kapasiteetti` int(11)
,`kurssien_maara` bigint(21)
,`keskimaara_opiskelijoita` decimal(24,4)
,`suurin_maara_opiskelijoita` bigint(21)
,`status` varchar(12)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `nakyma_tulevat_kurssit`
-- (See below for the actual view)
--
CREATE TABLE `nakyma_tulevat_kurssit` (
`kurssi_nimi` varchar(100)
,`kurssin_tunnus` varchar(20)
,`aloituspaiva` date
,`lopetuspaiva` date
,`opettaja` varchar(101)
,`tila_nimi` varchar(50)
,`ilmoittautuneet` bigint(21)
,`kapasiteetti` int(11)
,`vapaita_paikkoja` bigint(22)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `nakyma_ylibuukatut_kurssit`
-- (See below for the actual view)
--
CREATE TABLE `nakyma_ylibuukatut_kurssit` (
`kurssi_nimi` varchar(100)
,`kurssin_tunnus` varchar(20)
,`opettaja` varchar(101)
,`tila_nimi` varchar(50)
,`tilan_kapasiteetti` int(11)
,`ilmoittautuneet` bigint(21)
,`ylimaaraisia_opiskelijoita` bigint(22)
);

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
(5, 'Juha', 'Lehtonen', 'Tietotekniikka'),
(6, 'Riitta', 'Palmunen', 'Kuvataide'),
(7, 'Juhana', 'Järvinen', 'Äidinkieli ja kirjallisuus'),
(8, 'Asta', 'Järvinen', 'Yhteiskuntaoppi'),
(9, 'Alina', 'Virtanen', 'Ruotsi'),
(10, 'Heidi', 'Järvinen', 'Äidinkieli ja kirjallisuus'),
(11, 'Riitta', 'Palmunen', 'Historia'),
(12, 'Karita', 'Järvinen', 'Englanti'),
(13, 'Ari', 'Roos', 'Englanti'),
(14, 'Riitta', 'Palmunen', 'Kuvataide'),
(15, 'Minna', 'Lappalainen', 'Käsityö'),
(16, 'Karita', 'Palmunen', 'Maantieto'),
(17, 'Riitta', 'Järvi', 'Uskonto'),
(18, 'Alina', 'Roos', 'Uskonto'),
(19, 'Julia', 'Roos', 'Liikunta'),
(20, 'Julia', 'Riihko', 'Biologia');

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
(8, 'Liisa', 'Järvinen', '2005-12-03', 2),
(9, 'Lilja', 'Manninen', '2006-04-01', 2),
(10, 'Lilja', 'Nieminen', '2006-04-12', 3),
(11, 'Antti', 'Vuori', '2003-10-08', 2),
(12, 'Sade', 'Lahtinen', '2005-11-12', 2),
(13, 'Ville', 'Virtanen', '2004-06-03', 2),
(14, 'Sini', 'Järvinen', '2004-11-08', 1),
(15, 'Maria', 'Lehtonen', '2004-12-30', 2),
(16, 'Thomas', 'Karhu', '2004-10-25', 1),
(17, 'Riku', 'Mäkinen', '2003-12-11', 3),
(18, 'Aamu', 'Ojala', '2003-12-08', 1),
(19, 'Alex', 'Hautamäki', '2003-08-06', 2),
(20, 'Riku', 'Aalto', '2005-10-17', 3),
(21, 'Alina', 'Korhonen', '2005-12-26', 2),
(22, 'Sini', 'Kosonen', '2005-07-04', 3),
(23, 'Janina', 'Vuori', '2004-10-29', 1),
(24, 'Aamu', 'Lahtinen', '2006-08-19', 1),
(25, 'Mari', 'Ojala', '2003-05-09', 3),
(26, 'Sini', 'Karhu', '2006-01-01', 1),
(27, 'Henni', 'Mäkinen', '2004-06-10', 2),
(28, 'Otso', 'Lahtinen', '2004-11-02', 1),
(29, 'Kalle', 'Pitkänen', '2005-09-02', 3),
(30, 'Maria', 'Hämäläinen', '2006-12-05', 1),
(31, 'Janina', 'Kallioinen', '2004-05-07', 1),
(32, 'Sanna', 'Hautamäki', '2005-02-04', 2),
(33, 'Aamu', 'Jokinen', '2004-10-03', 1),
(34, 'Aaro', 'Kallioinen', '2005-09-19', 3),
(35, 'Sini', 'Hautamäki', '2006-07-06', 3),
(36, 'Heidi', 'Karhu', '2003-10-04', 3),
(37, 'Elmeri', 'Mäkinen', '2006-06-29', 1),
(38, 'Niko', 'Tuominen', '2004-08-22', 3),
(39, 'Mari', 'Saarinen', '2005-06-06', 2),
(40, 'Petteri', 'Saarinen', '2006-02-11', 2),
(41, 'Aamu', 'Rantanen', '2003-04-06', 1),
(42, 'Minna', 'Mäkinen', '2005-08-27', 2),
(43, 'Samuli', 'Karhu', '2004-09-06', 2),
(44, 'Otso', 'Karhu', '2005-12-30', 1),
(45, 'Sade', 'Vuori', '2003-09-22', 3),
(46, 'Ville', 'Savolainen', '2004-02-20', 1),
(47, 'Elmeri', 'Aalto', '2005-08-23', 1),
(48, 'Heidi', 'Seppänen', '2006-06-20', 2),
(49, 'Alina', 'Lahtinen', '2004-02-02', 3),
(50, 'Heidi', 'Kivinen', '2006-09-27', 1),
(51, 'Sade', 'Koivisto', '2006-11-15', 3),
(52, 'Antti', 'Aalto', '2003-05-15', 3),
(53, 'Tommi', 'Peltola', '2004-07-20', 2),
(54, 'Elmeri', 'Hautamäki', '2003-06-02', 1),
(55, 'Elmeri', 'Nurmi', '2006-11-24', 2),
(56, 'Oskari', 'Jokinen', '2004-08-03', 3),
(57, 'Heidi', 'Vainio', '2005-02-22', 1),
(58, 'Pekka', 'Mäkelä', '2006-04-09', 2);

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
(5, 'C303', 35),
(6, 'A104', 38),
(7, 'C308', 50),
(8, 'E501', 32),
(9, 'C310', 47),
(10, 'D401', 19),
(11, 'D404', 40),
(12, 'B207', 44),
(13, 'D406', 50),
(14, 'D402', 22),
(15, 'A103', 20);

-- --------------------------------------------------------

--
-- Structure for view `nakyma_kaynnissa_olevat_kurssit`
--
DROP TABLE IF EXISTS `nakyma_kaynnissa_olevat_kurssit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nakyma_kaynnissa_olevat_kurssit`  AS SELECT `k`.`kurssi_nimi` AS `kurssi_nimi`, `k`.`kurssin_tunnus` AS `kurssin_tunnus`, `k`.`aloituspaiva` AS `aloituspaiva`, `k`.`lopetuspaiva` AS `lopetuspaiva`, concat(`o`.`etunimi`,' ',`o`.`sukunimi`) AS `opettaja`, `t`.`tila_nimi` AS `tila_nimi`, count(`i`.`ilmoittautuminen_id`) AS `ilmoittautuneet` FROM (((`kurssit` `k` left join `opettajat` `o` on(`k`.`opettaja_id` = `o`.`opettaja_id`)) left join `tilat` `t` on(`k`.`tila_id` = `t`.`tila_id`)) left join `ilmoittautuminen` `i` on(`k`.`kurssi_id` = `i`.`kurssi_id`)) WHERE `k`.`aloituspaiva` <= curdate() AND `k`.`lopetuspaiva` >= curdate() GROUP BY `k`.`kurssi_id` ORDER BY `k`.`kurssi_nimi` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `nakyma_kurssit_taydellinen`
--
DROP TABLE IF EXISTS `nakyma_kurssit_taydellinen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nakyma_kurssit_taydellinen`  AS SELECT `k`.`kurssi_id` AS `kurssi_id`, `k`.`kurssin_tunnus` AS `kurssin_tunnus`, `k`.`kurssi_nimi` AS `kurssi_nimi`, `k`.`kurssikuvaus` AS `kurssikuvaus`, `k`.`aloituspaiva` AS `aloituspaiva`, `k`.`lopetuspaiva` AS `lopetuspaiva`, concat(`o`.`etunimi`,' ',`o`.`sukunimi`) AS `opettaja`, `o`.`aine` AS `opettajan_aine`, `t`.`tila_nimi` AS `tila_nimi`, `t`.`paikkoja` AS `tilan_kapasiteetti`, count(`i`.`ilmoittautuminen_id`) AS `ilmoittautuneet`, `t`.`paikkoja`- count(`i`.`ilmoittautuminen_id`) AS `vapaita_paikkoja` FROM (((`kurssit` `k` left join `opettajat` `o` on(`k`.`opettaja_id` = `o`.`opettaja_id`)) left join `tilat` `t` on(`k`.`tila_id` = `t`.`tila_id`)) left join `ilmoittautuminen` `i` on(`k`.`kurssi_id` = `i`.`kurssi_id`)) GROUP BY `k`.`kurssi_id` ;

-- --------------------------------------------------------

--
-- Structure for view `nakyma_opettajat_kurssit`
--
DROP TABLE IF EXISTS `nakyma_opettajat_kurssit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nakyma_opettajat_kurssit`  AS SELECT `o`.`opettaja_id` AS `opettaja_id`, concat(`o`.`etunimi`,' ',`o`.`sukunimi`) AS `opettaja`, `o`.`aine` AS `aine`, count(`k`.`kurssi_id`) AS `kurssien_maara`, group_concat(`k`.`kurssi_nimi` separator ', ') AS `kurssit` FROM (`opettajat` `o` left join `kurssit` `k` on(`o`.`opettaja_id` = `k`.`opettaja_id`)) GROUP BY `o`.`opettaja_id` ;

-- --------------------------------------------------------

--
-- Structure for view `nakyma_opiskelijat_aktiivisuus`
--
DROP TABLE IF EXISTS `nakyma_opiskelijat_aktiivisuus`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nakyma_opiskelijat_aktiivisuus`  AS SELECT `op`.`oppilas_id` AS `oppilas_id`, concat(`op`.`etunimi`,' ',`op`.`sukunimi`) AS `opiskelija`, `op`.`vuosikurssi` AS `vuosikurssi`, count(`i`.`kurssi_id`) AS `kurssien_maara`, CASE WHEN count(`i`.`kurssi_id`) >= 5 THEN 'Aktiivinen' WHEN count(`i`.`kurssi_id`) >= 3 THEN 'Normaali' WHEN count(`i`.`kurssi_id`) >= 1 THEN 'Vähän kursseja' ELSE 'Ei kursseja!' END AS `aktiivisuus_taso` FROM (`oppilaat` `op` left join `ilmoittautuminen` `i` on(`op`.`oppilas_id` = `i`.`opiskelija_id`)) GROUP BY `op`.`oppilas_id` ORDER BY count(`i`.`kurssi_id`) DESC ;

-- --------------------------------------------------------

--
-- Structure for view `nakyma_opiskelijat_kurssit`
--
DROP TABLE IF EXISTS `nakyma_opiskelijat_kurssit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nakyma_opiskelijat_kurssit`  AS SELECT `op`.`oppilas_id` AS `oppilas_id`, concat(`op`.`etunimi`,' ',`op`.`sukunimi`) AS `opiskelija`, `op`.`vuosikurssi` AS `vuosikurssi`, `k`.`kurssi_nimi` AS `kurssi_nimi`, `k`.`kurssin_tunnus` AS `kurssin_tunnus`, `k`.`aloituspaiva` AS `aloituspaiva`, `k`.`lopetuspaiva` AS `lopetuspaiva`, concat(`o`.`etunimi`,' ',`o`.`sukunimi`) AS `opettaja`, `i`.`ilmoittautumispaiva` AS `ilmoittautumispaiva` FROM (((`oppilaat` `op` join `ilmoittautuminen` `i` on(`op`.`oppilas_id` = `i`.`opiskelija_id`)) join `kurssit` `k` on(`i`.`kurssi_id` = `k`.`kurssi_id`)) join `opettajat` `o` on(`k`.`opettaja_id` = `o`.`opettaja_id`)) ORDER BY `op`.`sukunimi` ASC, `op`.`etunimi` ASC, `k`.`aloituspaiva` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `nakyma_tilat_kaytto`
--
DROP TABLE IF EXISTS `nakyma_tilat_kaytto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nakyma_tilat_kaytto`  AS SELECT `t`.`tila_id` AS `tila_id`, `t`.`tila_nimi` AS `tila_nimi`, `t`.`paikkoja` AS `kapasiteetti`, count(`k`.`kurssi_id`) AS `kurssien_maara`, avg(`osallistujat`.`lkm`) AS `keskimaara_opiskelijoita`, max(`osallistujat`.`lkm`) AS `suurin_maara_opiskelijoita`, CASE WHEN max(`osallistujat`.`lkm`) > `t`.`paikkoja` THEN 'YLIBUUKATTU!' WHEN max(`osallistujat`.`lkm`) = `t`.`paikkoja` THEN 'Täynnä' ELSE 'OK' END AS `status` FROM ((`tilat` `t` left join `kurssit` `k` on(`t`.`tila_id` = `k`.`tila_id`)) left join (select `ilmoittautuminen`.`kurssi_id` AS `kurssi_id`,count(0) AS `lkm` from `ilmoittautuminen` group by `ilmoittautuminen`.`kurssi_id`) `osallistujat` on(`k`.`kurssi_id` = `osallistujat`.`kurssi_id`)) GROUP BY `t`.`tila_id` ;

-- --------------------------------------------------------

--
-- Structure for view `nakyma_tulevat_kurssit`
--
DROP TABLE IF EXISTS `nakyma_tulevat_kurssit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nakyma_tulevat_kurssit`  AS SELECT `k`.`kurssi_nimi` AS `kurssi_nimi`, `k`.`kurssin_tunnus` AS `kurssin_tunnus`, `k`.`aloituspaiva` AS `aloituspaiva`, `k`.`lopetuspaiva` AS `lopetuspaiva`, concat(`o`.`etunimi`,' ',`o`.`sukunimi`) AS `opettaja`, `t`.`tila_nimi` AS `tila_nimi`, count(`i`.`ilmoittautuminen_id`) AS `ilmoittautuneet`, `t`.`paikkoja` AS `kapasiteetti`, `t`.`paikkoja`- count(`i`.`ilmoittautuminen_id`) AS `vapaita_paikkoja` FROM (((`kurssit` `k` left join `opettajat` `o` on(`k`.`opettaja_id` = `o`.`opettaja_id`)) left join `tilat` `t` on(`k`.`tila_id` = `t`.`tila_id`)) left join `ilmoittautuminen` `i` on(`k`.`kurssi_id` = `i`.`kurssi_id`)) WHERE `k`.`aloituspaiva` > curdate() GROUP BY `k`.`kurssi_id` ORDER BY `k`.`aloituspaiva` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `nakyma_ylibuukatut_kurssit`
--
DROP TABLE IF EXISTS `nakyma_ylibuukatut_kurssit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nakyma_ylibuukatut_kurssit`  AS SELECT `k`.`kurssi_nimi` AS `kurssi_nimi`, `k`.`kurssin_tunnus` AS `kurssin_tunnus`, concat(`o`.`etunimi`,' ',`o`.`sukunimi`) AS `opettaja`, `t`.`tila_nimi` AS `tila_nimi`, `t`.`paikkoja` AS `tilan_kapasiteetti`, count(`i`.`ilmoittautuminen_id`) AS `ilmoittautuneet`, count(`i`.`ilmoittautuminen_id`) - `t`.`paikkoja` AS `ylimaaraisia_opiskelijoita` FROM (((`kurssit` `k` join `opettajat` `o` on(`k`.`opettaja_id` = `o`.`opettaja_id`)) join `tilat` `t` on(`k`.`tila_id` = `t`.`tila_id`)) join `ilmoittautuminen` `i` on(`k`.`kurssi_id` = `i`.`kurssi_id`)) GROUP BY `k`.`kurssi_id` HAVING `ilmoittautuneet` > `t`.`paikkoja` ORDER BY count(`i`.`ilmoittautuminen_id`) - `t`.`paikkoja` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ilmoittautuminen`
--
ALTER TABLE `ilmoittautuminen`
  ADD PRIMARY KEY (`ilmoittautuminen_id`),
  ADD UNIQUE KEY `opiskelija_id` (`opiskelija_id`,`kurssi_id`),
  ADD KEY `idx_ilmoittautuminen_opiskelija` (`opiskelija_id`),
  ADD KEY `idx_ilmoittautuminen_kurssi` (`kurssi_id`),
  ADD KEY `idx_ilmoittautuminen_pvm` (`ilmoittautumispaiva`);

--
-- Indexes for table `kurssit`
--
ALTER TABLE `kurssit`
  ADD PRIMARY KEY (`kurssi_id`),
  ADD UNIQUE KEY `kurssin_tunnus` (`kurssin_tunnus`),
  ADD KEY `opettaja_id` (`opettaja_id`),
  ADD KEY `tila_id` (`tila_id`),
  ADD KEY `idx_kurssit_paivamaarat` (`aloituspaiva`,`lopetuspaiva`),
  ADD KEY `idx_kurssit_tunnus` (`kurssin_tunnus`);

--
-- Indexes for table `opettajat`
--
ALTER TABLE `opettajat`
  ADD PRIMARY KEY (`opettaja_id`),
  ADD KEY `idx_opettajat_aine` (`aine`);

--
-- Indexes for table `oppilaat`
--
ALTER TABLE `oppilaat`
  ADD PRIMARY KEY (`oppilas_id`),
  ADD KEY `idx_oppilaat_nimi` (`sukunimi`,`etunimi`);

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
  MODIFY `ilmoittautuminen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=354;

--
-- AUTO_INCREMENT for table `kurssit`
--
ALTER TABLE `kurssit`
  MODIFY `kurssi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `opettajat`
--
ALTER TABLE `opettajat`
  MODIFY `opettaja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `oppilaat`
--
ALTER TABLE `oppilaat`
  MODIFY `oppilas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tilat`
--
ALTER TABLE `tilat`
  MODIFY `tila_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
