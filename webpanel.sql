-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 10 Eyl 2020, 22:03:18
-- Sunucu sürümü: 10.3.23-MariaDB
-- PHP Sürümü: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `webpanel`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `servers`
--

CREATE TABLE `servers` (
  `id` int(255) NOT NULL,
  `serveradres` varchar(255) CHARACTER SET utf8 NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `queryport` varchar(255) CHARACTER SET utf8 NOT NULL,
  `imbot` varchar(255) CHARACTER SET utf8 NOT NULL,
  `stok` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sunucuaktifmi` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `servers`
--

INSERT INTO `servers` (`id`, `serveradres`, `username`, `password`, `queryport`, `imbot`, `stok`, `sunucuaktifmi`) VALUES


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stokcontrol`
--

CREATE TABLE `stokcontrol` (
  `id` int(100) NOT NULL,
  `stok` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sunucular`
--

CREATE TABLE `sunucular` (
  `id` int(100) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `serverip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `serverport` varchar(255) CHARACTER SET utf8 NOT NULL,
  `kisisayisi` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `sunucular`
--

INSERT INTO `sunucular` (`id`, `email`, `serverip`, `serverport`, `kisisayisi`) VALUES


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ticket`
--

CREATE TABLE `ticket` (
  `id` int(100) NOT NULL,
  `baslik` varchar(255) CHARACTER SET utf8 NOT NULL,
  `kimden` varchar(255) CHARACTER SET utf8 NOT NULL,
  `adsoyad` varchar(255) CHARACTER SET utf8 NOT NULL,
  `aciliyet` varchar(255) CHARACTER SET utf8 NOT NULL,
  `tarih` varchar(255) CHARACTER SET utf8 NOT NULL,
  `icerik` varchar(255) CHARACTER SET utf8 NOT NULL,
  `durum` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ticketre`
--

CREATE TABLE `ticketre` (
  `id` int(100) NOT NULL,
  `cevap` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cevapsahibi` varchar(255) CHARACTER SET utf8 NOT NULL,
  `tarih` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ticketid` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `adsoyad` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `kadi` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `telno` varchar(255) CHARACTER SET utf8 NOT NULL,
  `profilkonum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `admin_mi` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sunucucontrol` varchar(255) CHARACTER SET utf8 NOT NULL,
  `aktif_mi` varchar(255) CHARACTER SET utf8 NOT NULL,
  `hesapban` varchar(255) CHARACTER SET utf8 NOT NULL,
  `uip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `songiristarih` varchar(255) CHARACTER SET utf8 NOT NULL,
  `songirissaat` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `adsoyad`, `email`, `kadi`, `password`, `telno`, `profilkonum`, `admin_mi`, `sunucucontrol`, `aktif_mi`, `hesapban`, `uip`, `songiristarih`, `songirissaat`) VALUES


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yedeks`
--

CREATE TABLE `yedeks` (
  `id` int(100) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yedekadi` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yedekaciklama` varchar(255) CHARACTER SET utf8 NOT NULL,
  `port` varchar(255) CHARACTER SET utf8 NOT NULL,
  `bayi` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `yedeks`
--

INSERT INTO `yedeks` (`id`, `email`, `yedekadi`, `yedekaciklama`, `port`, `bayi`) VALUES


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetsunucu`
--

CREATE TABLE `yonetsunucu` (
  `id` int(100) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yonetilecekip` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yonetilecekport` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `yonetsunucu`
--

INSERT INTO `yonetsunucu` (`id`, `email`, `yonetilecekip`, `yonetilecekport`) VALUES


--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `stokcontrol`
--
ALTER TABLE `stokcontrol`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sunucular`
--
ALTER TABLE `sunucular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ticketre`
--
ALTER TABLE `ticketre`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yedeks`
--
ALTER TABLE `yedeks`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yonetsunucu`
--
ALTER TABLE `yonetsunucu`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `stokcontrol`
--
ALTER TABLE `stokcontrol`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `sunucular`
--
ALTER TABLE `sunucular`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ticketre`
--
ALTER TABLE `ticketre`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `yedeks`
--
ALTER TABLE `yedeks`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `yonetsunucu`
--
ALTER TABLE `yonetsunucu`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
