-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 17 Haz 2025, 07:38:34
-- Sunucu sürümü: 8.0.41
-- PHP Sürümü: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `crm`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `email` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `phone` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `note` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `support` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT 'bos',
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `phone`, `note`, `support`, `tarih`, `user_id`) VALUES
(2, 'Özgür', 'ozgur@gmail.com', '123', '5449435919', 'asda', 'bos', '2025-05-17 13:13:25', 3),
(4, 'Ahmet', 'ozgurasd@admin.com', '123', '5449435911', 'asd', 'pEcnZpyJ', '2025-05-27 09:33:31', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `groups`
--

CREATE TABLE `groups` (
  `id` int NOT NULL,
  `title` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `auth` text COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `groups`
--

INSERT INTO `groups` (`id`, `title`, `auth`) VALUES
(1, 'Süper Admin', '1,2,3,4,5,7,8,9'),
(4, 'Yönetici', '1,2,3,4,5');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `invoices`
--

CREATE TABLE `invoices` (
  `id` int NOT NULL,
  `title` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `amount` int NOT NULL,
  `provider` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `paytr_merchantid` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `paytr_merchantkey` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `paytr_merchantsalt` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `stripe_key` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `iyzico_apikey` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `iyzico_secretkey` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `netgsm_un` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `netgsm_pass` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `customer` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `officer` text COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `paytr_merchantid`, `paytr_merchantkey`, `paytr_merchantsalt`, `stripe_key`, `iyzico_apikey`, `iyzico_secretkey`, `netgsm_un`, `netgsm_pass`, `customer`, `officer`) VALUES
(1, 'PAYTR_MERCHANT_ID', 'PAYTR_MERCHANT_KEY', 'PAYTR_MERCHANT_SALT', 'STRIPE_API_KEY', 'IYZICO_API_KEY', 'IYZICO_SECRET_KEY', 'NETGSM_UN', 'NETGSM_PASS', '1', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stock`
--

CREATE TABLE `stock` (
  `id` int NOT NULL,
  `title` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `stock` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `adet` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `stock`
--

INSERT INTO `stock` (`id`, `title`, `stock`, `adet`) VALUES
(1, 'Valorant 550 VP', 'OSLAFN, OSAIOSDG, JOSDIHSA, OSISBNaG.', 256);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `title` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `text` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `user_id` int NOT NULL,
  `group_id` int NOT NULL DEFAULT '0',
  `file` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `text`, `user_id`, `group_id`, `file`, `status`) VALUES
(5, 'Pazarlama Görevlerinizi Tamamlayın', 'Pazarlama Görevlerinizi Tamamlayın', 4, 0, 'images/2844727382doribilişim-1.png', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tickets`
--

CREATE TABLE `tickets` (
  `id` int NOT NULL,
  `title` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `icerik` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `yanit` varchar(5000) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT 'bos',
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `icerik`, `yanit`, `user_id`) VALUES
(1, 'Destek Talebim', 'asdadas', 'ASDASDSADSA', 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `surname` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `email` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `group_id` int NOT NULL,
  `token` text COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `group_id`, `token`) VALUES
(1, 'Özgür', 'Ege', 'admin@admin.com', '202cb962ac59075b964b07152d234b70', 1, 'A755B711O1S3U55516D9'),
(4, 'Özlem', 'Nur', 'ozlemnur@gmail.com', '202cb962ac59075b964b07152d234b70', 4, 'J1S2L0F5O1S0O2H6B3H6');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
