-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Úte 01. čen 2021, 12:27
-- Verze serveru: 10.3.22-MariaDB-log
-- Verze PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `garo01`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `sl_items`
--

CREATE TABLE `sl_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_list_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `count` int(10) UNSIGNED NOT NULL,
  `bought` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;


--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `sl_items`
--
ALTER TABLE `sl_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_list_id` (`shop_list_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `sl_items`
--
ALTER TABLE `sl_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `sl_items`
--
ALTER TABLE `sl_items`
  ADD CONSTRAINT `shop_list_id` FOREIGN KEY (`shop_list_id`) REFERENCES `sl_shop_lists` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
