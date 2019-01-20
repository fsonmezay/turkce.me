-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 20 Oca 2019, 22:33:52
-- Sunucu sürümü: 5.7.15
-- PHP Sürümü: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Veritabanı: `me_turkce`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tm_app_config`
--

CREATE TABLE `tm_app_config` (
  `key` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `value` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tm_app_config`
--

INSERT INTO `tm_app_config` (`key`, `value`, `type`) VALUES
('uygulama_aktif_mi', '1', 'aktif'),
('default_timezone', 'Europe/Istanbul', 'timezone');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tm_definitions`
--

CREATE TABLE `tm_definitions` (
  `id` int(11) NOT NULL,
  `locution_id` int(11) NOT NULL,
  `definition` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `definition_key` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `creation_date` varchar(14) COLLATE utf8_turkish_ci NOT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tm_definitions`
--

INSERT INTO `tm_definitions` (`id`, `locution_id`, `definition`, `definition_key`, `creation_date`, `state`) VALUES
(1, 1, 'Eklemek', 'eklemek', '20190121011305', 0),
(2, 1, 'Ekleme', 'ekleme', '20190121011305', 0),
(3, 1, 'Kaydetme', 'kaydetme', '20190121011305', 0),
(4, 2, 'Arama', 'arama', '20190121011339', 0),
(5, 2, 'Aramak', 'aramak', '20190121011339', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tm_locutions`
--

CREATE TABLE `tm_locutions` (
  `id` int(11) NOT NULL,
  `locution` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `locution_key` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `date_created` varchar(14) COLLATE utf8_turkish_ci NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tm_locutions`
--

INSERT INTO `tm_locutions` (`id`, `locution`, `locution_key`, `date_created`, `state`) VALUES
(1, 'insert', 'insert', '20190121011305', 0),
(2, 'Search', 'search', '20190121011339', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tm_state`
--

CREATE TABLE `tm_state` (
  `id` tinyint(1) NOT NULL,
  `name` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `state_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tm_state`
--

INSERT INTO `tm_state` (`id`, `name`, `state_id`) VALUES
(0, 'Pasif', 1),
(1, 'Aktif', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `tm_app_config`
--
ALTER TABLE `tm_app_config`
  ADD UNIQUE KEY `key` (`key`);

--
-- Tablo için indeksler `tm_definitions`
--
ALTER TABLE `tm_definitions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locution_id` (`locution_id`,`definition_key`);

--
-- Tablo için indeksler `tm_locutions`
--
ALTER TABLE `tm_locutions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locution_key` (`locution_key`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `tm_definitions`
--
ALTER TABLE `tm_definitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Tablo için AUTO_INCREMENT değeri `tm_locutions`
--
ALTER TABLE `tm_locutions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;