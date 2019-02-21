-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 21 Şub 2019, 20:05:04
-- Sunucu sürümü: 5.7.19
-- PHP Sürümü: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `bp`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `chemical`
--

DROP TABLE IF EXISTS `chemical`;
CREATE TABLE IF NOT EXISTS `chemical` (
  `unique_id` int(11) NOT NULL AUTO_INCREMENT,
  `n_name` int(11) NOT NULL,
  `n_formula` int(11) NOT NULL,
  `n_manufacturer` int(11) NOT NULL,
  `quantity` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `stock` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `entry_date` date NOT NULL,
  PRIMARY KEY (`unique_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `chemical`
--

INSERT INTO `chemical` (`unique_id`, `n_name`, `n_formula`, `n_manufacturer`, `quantity`, `stock`, `entry_date`) VALUES
(1, 1, 1, 1, '100g', '1 Adet', '2019-02-19'),
(2, 2, 2, 1, '300g', '1 Adet', '2019-02-06'),
(3, 2, 2, 1, '900g', '3 Adet', '2019-02-03');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `chemical_formula`
--

DROP TABLE IF EXISTS `chemical_formula`;
CREATE TABLE IF NOT EXISTS `chemical_formula` (
  `n_formula` int(11) NOT NULL,
  `formula` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`n_formula`),
  UNIQUE KEY `formula` (`formula`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `chemical_formula`
--

INSERT INTO `chemical_formula` (`n_formula`, `formula`) VALUES
(1, 'indikator'),
(2, 'Al<sub>2</sub>(SO<sub>4</sub>)<sub>3</sub>');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `chemical_name`
--

DROP TABLE IF EXISTS `chemical_name`;
CREATE TABLE IF NOT EXISTS `chemical_name` (
  `n_name` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`n_name`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `chemical_name`
--

INSERT INTO `chemical_name` (`n_name`, `name`) VALUES
(1, 'Alizarin Sarisi'),
(2, 'Alüminyum Klorur');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `manufacturer_names`
--

DROP TABLE IF EXISTS `manufacturer_names`;
CREATE TABLE IF NOT EXISTS `manufacturer_names` (
  `n_manufacturer` int(11) NOT NULL,
  `manufacturer` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`n_manufacturer`),
  UNIQUE KEY `manufacturer` (`manufacturer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `manufacturer_names`
--

INSERT INTO `manufacturer_names` (`n_manufacturer`, `manufacturer`) VALUES
(1, 'Sigma Aldrich');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(88) COLLATE utf8_turkish_ci NOT NULL,
  `level` varchar(2) COLLATE utf8_turkish_ci NOT NULL DEFAULT '1',
  `user_auth` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `user_login_time` varchar(12) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`id`, `user_id`, `level`, `user_auth`, `user_login_time`) VALUES
(9, 'erdem', '3', 'b46794f2a71231181494293e08479ded', '1550778486'),
(12, 'arslan.erdem@ogr.deu.edu.tr', '1', '42031d0f6b113aff96ffe577acc5c5bb', '1550778372');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
