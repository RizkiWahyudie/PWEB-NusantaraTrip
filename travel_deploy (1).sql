-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jun 2022 pada 16.59
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel_deploy`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addCardPayment` (IN `nomorRekening` INT(11), IN `nomorKartu` INT(11), IN `namaUser` VARCHAR(250), IN `pinUser` INT(8), IN `saldoUser` INT(250), OUT `pesan` VARCHAR(250))  BEGIN
INSERT INTO transaksi (`nomor_rekening`, `nomor_kartu`, `nama`, `pin`, `saldo`) VALUES (nomorRekening, nomorKartu, namaUser, pinUser, saldoUser);
SET pesan = "Tambah Kartu Berhasil!";
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteBooking` (IN `reservasi` INT(11))  BEGIN
DELETE FROM booking WHERE id = reservasi;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `detailBooking` (IN `sql_username` VARCHAR(250))  BEGIN
SELECT * FROM users, booking WHERE booking.id_login=users.id_login AND users.username=sql_username ORDER BY booking.id DESC LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `detailBookingAll` (IN `sql_username` VARCHAR(250), IN `sql_idbook` INT(11))  BEGIN
SELECT * FROM users, booking WHERE booking.id=sql_idbook;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `payment` (IN `nsbh_nomor_kartu` INT(20), IN `nsbh_pin` INT(10), IN `jmlh_pembayaran` INT(15), IN `nsbh_id_booking` INT(11), IN `nsbh_nama_hotel` VARCHAR(250), OUT `pesan` VARCHAR(250))  BEGIN
DECLARE exist int;
DECLARE nsbh_saldo decimal(12,2);
DECLARE nsbh_sisa decimal(12,2);
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
SET pesan = 'Sistem Error';
ROLLBACK;
END;
START TRANSACTION;
SELECT COUNT(*) INTO exist FROM transaksi WHERE nomor_kartu = nsbh_nomor_kartu AND pin = nsbh_pin;
IF exist <> 1 THEN
SET pesan = 'PIN tidak valid';
ROLLBACK;
ELSE
SELECT saldo INTO nsbh_saldo FROM transaksi WHERE nomor_kartu = nsbh_nomor_kartu AND pin = nsbh_pin;
SET nsbh_sisa = nsbh_saldo - jmlh_pembayaran;
IF jmlh_pembayaran < 50000 THEN
SET pesan = 'Penarikan minimal Rp. 50.000';
ROLLBACK;
ELSE
IF nsbh_sisa < 50000 THEN
SET pesan = 'Minimal sisa saldo adalah Rp. 50.000';
ROLLBACK;
ELSE
UPDATE transaksi SET saldo = nsbh_sisa, id_booking = nsbh_id_booking, nama_hotel = nsbh_nama_hotel, nominal = jmlh_pembayaran WHERE nomor_kartu = nsbh_nomor_kartu AND pin = nsbh_pin;
SET pesan = 'Pembayaran booking hotel berhasil!';
COMMIT;
END IF;
END IF;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `totalUsers` (OUT `total_user` INT(11))  BEGIN
SELECT COUNT(id_login) INTO total_user FROM users;
END$$

--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `jumlahAdmin` (`boolean` INT(11)) RETURNS INT(11) BEGIN
DECLARE jml INT;
SELECT COUNT(*) INTO jml FROM users WHERE admin=Boolean;
RETURN jml;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `admindata`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `admindata` (
`id_admin` varchar(13)
,`username` varchar(255)
,`name` varchar(255)
,`email` varchar(255)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `hotel` varchar(250) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `room_type` varchar(250) NOT NULL,
  `tamu` int(11) NOT NULL,
  `arrived` date NOT NULL,
  `departure` date NOT NULL,
  `jml_malam` int(11) NOT NULL,
  `price` int(250) NOT NULL,
  `id_login` int(11) NOT NULL,
  `id_hotel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`id`, `hotel`, `nama`, `phone`, `room_type`, `tamu`, `arrived`, `departure`, `jml_malam`, `price`, `id_login`, `id_hotel`) VALUES
(1, 'Jiwa Jawa Bromo Hotel', 'Rizki Wahyudie', '08951234567', 'Deluxe Room', 2, '2022-06-05', '2022-06-07', 2, 3000000, 37, 2),
(2, 'Dedanau Hotel', 'Reyhan Agus', '123456789', 'Deluxe Room', 2, '2022-06-13', '2022-06-15', 2, 2500000, 46, 4),
(3, 'Dedanau Hotel', 'Reyhan Agus', '123456789', 'Private Room', 2, '2022-06-13', '2022-06-16', 3, 2550000, 46, 4),
(4, 'Mercure Jakarta Hotel', 'Rizki Wahyudie', '123456789', 'Deluxe Room', 3, '2022-06-12', '2022-06-14', 2, 1510000, 37, 3),
(6, 'Jiwa Jawa Bromo Hotel', 'Rizki Wahyudie', '08151861461', 'Party Room', 2, '2022-06-12', '2022-06-14', 2, 4000000, 37, 2),
(7, 'Jiwa Jawa Bromo Hotel', 'Fadil Ihsan', '08151861461', 'Private Room', 1, '2022-06-12', '2022-06-15', 3, 3750000, 46, 2),
(8, 'Jiwa Jawa Bromo Hotel', 'Fadil Ihsan', '08151861461', 'Private Room', 1, '2022-06-12', '2022-06-15', 3, 3750000, 46, 2),
(9, 'Jiwa Jawa Bromo Hotel', 'Fadil Ihsan', '08151861461', 'Private Room', 1, '2022-06-12', '2022-06-15', 3, 3750000, 46, 2);

--
-- Trigger `booking`
--
DELIMITER $$
CREATE TRIGGER `log_delete_booking` AFTER DELETE ON `booking` FOR EACH ROW BEGIN
INSERT INTO log_booking (status, id_booking, hotel, nama_pemesan, time) VALUES ('Delete Form Booking', OLD.id, OLD.hotel, OLD.nama, NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_insert_booking` AFTER INSERT ON `booking` FOR EACH ROW BEGIN
INSERT INTO log_booking (status, id_booking, hotel, nama_pemesan, roomtype_new, guests_new, arrived_new, departure_new, time) VALUES ('Insert Form Booking', NEW.id, NEW.hotel, NEW.nama, NEW.room_type, NEW.tamu, NEW.arrived, NEW.departure, NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_update_booking` BEFORE UPDATE ON `booking` FOR EACH ROW BEGIN
INSERT INTO log_booking (status, id_booking, hotel, nama_pemesan, roomtype_old, roomtype_new, guests_old, guests_new, arrived_old, arrived_new, departure_old, departure_new, time) VALUES ('Update Form Booking', NEW.id, NEW.hotel, NEW.nama, OLD.room_type, NEW.room_type, OLD.tamu, NEW.tamu, OLD.arrived, NEW.arrived, OLD.departure, NEW.departure, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hotel`
--

CREATE TABLE `hotel` (
  `id_hotel` int(11) NOT NULL,
  `namaHotel` varchar(250) NOT NULL,
  `alamatHotel` varchar(250) NOT NULL,
  `pictOne` varchar(250) NOT NULL,
  `pictTwo` varchar(250) NOT NULL,
  `pictThree` varchar(250) NOT NULL,
  `descHotel` varchar(1250) NOT NULL,
  `bedroom` varchar(250) NOT NULL,
  `livingroom` varchar(250) NOT NULL,
  `breakfast` varchar(250) NOT NULL,
  `bathup` varchar(250) NOT NULL,
  `speedWifi` varchar(250) NOT NULL,
  `ac` varchar(250) NOT NULL,
  `refrigerator` varchar(250) NOT NULL,
  `tv` varchar(250) NOT NULL,
  `priceTypeOne` int(250) NOT NULL,
  `priceTypeTwo` int(250) NOT NULL,
  `priceTypeThree` int(250) NOT NULL,
  `thumbnail` varchar(250) NOT NULL,
  `thumbnailTitle` varchar(250) NOT NULL,
  `thumbnailSubTitle` varchar(250) NOT NULL,
  `maps` varchar(3500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hotel`
--

INSERT INTO `hotel` (`id_hotel`, `namaHotel`, `alamatHotel`, `pictOne`, `pictTwo`, `pictThree`, `descHotel`, `bedroom`, `livingroom`, `breakfast`, `bathup`, `speedWifi`, `ac`, `refrigerator`, `tv`, `priceTypeOne`, `priceTypeTwo`, `priceTypeThree`, `thumbnail`, `thumbnailTitle`, `thumbnailSubTitle`, `maps`) VALUES
(1, 'Pesona Bamboe Hotel', 'Lembang, Bandung', 'pesonabambu1.jpg', 'pesonabambu2.jpg', 'pesonabambu3.jpg', 'Nikmati menginap dan dikelilingi oleh pegunungan yang nyaman dan menyejukkan, dekat dengan tempat-tempat terbaik di Lembang, Jawa Barat.', '1', '1', '1x', '1', '10', '1', '1', '1', 550000, 750000, 1000000, 'tangkubanPerahu.jpg', 'Tangkuban Perahu', 'Lembang, Bandung', ''),
(2, 'Jiwa Jawa Bromo Hotel', 'Bromo, Jawa Timur', 'jiwajawa1.jpg', 'jiwajawa2.jpg', 'jiwajawa3.jpg', 'Jiwa Jawa Resort Bromo hadir untuk memadukan keindahan alam dengan pelayanan penuh perasaan bagi mereka yang menghargai keindahan. Nikmati pemandangan menakjubkan gunung Bromo! Jiwa Jawa Resort Bromo terletak di Bromo , 3,3 km dari Gunung Bromo . Resor ini memiliki restoran, pusat kebugaran, taman, dan Wi-Fi gratis.', '2', '1', '1x', '1', '15', '3', '1', '2', 1250000, 1500000, 2000000, 'bromo.png', 'Gunung Bromo', 'Jiwa Jawa Bromo Hotel', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15806.180045972278!2d112.94425741586593!3d-7.942493358463455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd637aaab794a41%3A0xada40d36ecd2a5dd!2sMt%20Bromo!5e0!3m2!1sen!2sid!4v1648692042301!5m2!1sen!2sid'),
(3, 'Mercure Jakarta Hotel', 'Monas, DKI Jakarta', 'mercurehotel1.jpg', 'mercurehotel2.jpg', 'mercurehotel3.jpg', 'Hotel Mercure paling banyak dipesan di Jakarta bulan ini · Mercure Convention Center Ancol, Hotel Mercure di Jakarta. Hotel Mercure 4 bintang. Mercure Jakarta Gatot Subroto adalah hal baru di antara properti terkemuka di Jakarta Selatan. Berlokasi strategis di kawasan segitiga emas bisnis', '1', '1', '1x', '1', '30', '2', '1', '1', 450000, 755000, 958000, 'monas.png', 'Monumen Nasional', 'Mercure Hotel, DKI Jakarta', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6664270097594!2d106.82496411406314!3d-6.175392395529166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sNational%20Monument!5e0!3m2!1sen!2sid!4v1648692128958!5m2!1sen!2sid'),
(4, 'Dedanau Hotel', 'Pura Ulun Danu Bratan, Bali', 'dedanau1.jpg', 'dedanau2.jpg', 'dedanau3.jpg', 'Terletak di Bedugul, 500 meter dari Pura Ulun Danu, dedanau Hotel menyediakan akomodasi dengan restoran, parkir pribadi gratis, bar, dan lounge bersama. Fasilitas yang ditawarkan di akomodasi ini meliputi resepsionis 24 jam, layanan kamar, dan Wi-Fi ', '1', '1', '1x', '1', '20', '2', '1', '1', 850000, 1250000, 1500000, 'bali.png', 'Pura Ulun Danu Bratan', 'Dedanau Hotel, Bali', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.2776104750574!2d115.16183911407882!3d-8.275143994045951!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd1891516fc01e7%3A0xa44cf1cad220915a!2sdedanau%20Hotel!5e0!3m2!1sen!2sid!4v1648691450371!5m2!1sen!2sid'),
(5, 'Pesona Bamboe Hotel', 'Lembang, Bandung', 'pesonabambu1.jpg', 'pesonabambu2.jpg', 'pesonabambu3.jpg', 'Nikmati menginap dan dikelilingi oleh pegunungan yang nyaman dan menyejukkan, dekat dengan tempat-tempat terbaik di Lembang, Jawa Barat.', '1', '1', '1x', '1', '10', '1', '1', '1', 550000, 750000, 1000000, 'tangkubanPerahu.jpg', 'Tangkuban Perahu', 'Pesona Bamboe Hotel', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15848.33514543452!2d107.6010259157217!3d-6.759637471818919!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e1ddc59713db%3A0xa01c96b73428fedc!2sTangkuban%20Perahu!5e0!3m2!1sen!2sid!4v1648691960249!5m2!1sen!2sid');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_booking`
--

CREATE TABLE `log_booking` (
  `id_log` int(11) NOT NULL,
  `status` varchar(250) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `hotel` varchar(250) NOT NULL,
  `nama_pemesan` varchar(250) NOT NULL,
  `roomtype_old` varchar(250) DEFAULT '-',
  `roomtype_new` varchar(250) DEFAULT '-',
  `guests_old` int(11) DEFAULT 0,
  `guests_new` int(11) DEFAULT 0,
  `arrived_old` date DEFAULT NULL,
  `arrived_new` date DEFAULT NULL,
  `departure_old` date DEFAULT NULL,
  `departure_new` date DEFAULT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `log_booking`
--

INSERT INTO `log_booking` (`id_log`, `status`, `id_booking`, `hotel`, `nama_pemesan`, `roomtype_old`, `roomtype_new`, `guests_old`, `guests_new`, `arrived_old`, `arrived_new`, `departure_old`, `departure_new`, `time`) VALUES
(1, 'Insert Form Booking', 1, 'Jiwa Jawa Bromo Hotel', 'Rizki Wahyudie', '-', 'Deluxe Room', 0, 2, NULL, '2022-06-05', NULL, '2022-06-07', '2022-06-05 21:07:25'),
(2, 'Insert Form Booking', 2, 'Dedanau Hotel', 'Reyhan Agus', '-', 'Deluxe Room', 0, 2, NULL, '2022-06-13', NULL, '2022-06-15', '2022-06-12 11:17:14'),
(3, 'Insert Form Booking', 3, 'Dedanau Hotel', 'Reyhan Agus', '-', 'Deluxe Room', 0, 2, NULL, '2022-06-13', NULL, '2022-06-15', '2022-06-12 11:18:27'),
(4, 'Update Form Booking', 3, 'Dedanau Hotel', 'Reyhan Agus', 'Deluxe Room', 'Private Room', 2, 2, '2022-06-13', '2022-06-13', '2022-06-15', '2022-06-16', '2022-06-12 11:21:49'),
(5, 'Insert Form Booking', 4, 'Mercure Jakarta Hotel', 'Rizki Wahyudie', '-', 'Deluxe Room', 0, 3, NULL, '2022-06-12', NULL, '2022-06-14', '2022-06-12 11:36:59'),
(6, 'Insert Form Booking', 5, 'Dedanau Hotel', 'Rizki Wahyudie', '-', 'Deluxe Room', 0, 3, NULL, '2022-06-12', NULL, '2022-06-14', '2022-06-12 11:37:07'),
(7, 'Insert Form Booking', 6, 'Jiwa Jawa Bromo Hotel', 'Rizki Wahyudie', '-', 'Party Room', 0, 2, NULL, '2022-06-12', NULL, '2022-06-14', '2022-06-12 14:01:15'),
(8, 'Delete Form Booking', 5, 'Dedanau Hotel', 'Rizki Wahyudie', '-', '-', 0, 0, NULL, NULL, NULL, NULL, '2022-06-12 14:12:21'),
(9, 'Insert Form Booking', 7, 'Jiwa Jawa Bromo Hotel', 'Fadil Ihsan', '-', 'Private Room', 0, 1, NULL, '2022-06-12', NULL, '2022-06-15', '2022-06-12 14:45:40'),
(10, 'Insert Form Booking', 8, 'Jiwa Jawa Bromo Hotel', 'Fadil Ihsan', '-', 'Private Room', 0, 1, NULL, '2022-06-12', NULL, '2022-06-15', '2022-06-12 14:45:48'),
(11, 'Insert Form Booking', 9, 'Jiwa Jawa Bromo Hotel', 'Fadil Ihsan', '-', 'Private Room', 0, 1, NULL, '2022-06-12', NULL, '2022-06-15', '2022-06-12 14:45:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_transaksi`
--

CREATE TABLE `log_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `status` varchar(250) NOT NULL,
  `namauser` varchar(250) NOT NULL,
  `nomorkartu` int(11) NOT NULL,
  `idbooking_transaksi` int(11) NOT NULL,
  `namahotel_transaksi` varchar(250) NOT NULL,
  `nominal_transaksi` int(15) NOT NULL,
  `waktu_transaksi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `log_transaksi`
--

INSERT INTO `log_transaksi` (`id_transaksi`, `status`, `namauser`, `nomorkartu`, `idbooking_transaksi`, `namahotel_transaksi`, `nominal_transaksi`, `waktu_transaksi`) VALUES
(1, 'Pembayaran Hotel Terkonfirmasi', 'rizki10', 343434, 1, 'Jiwa Jawa Bromo Hotel', 3000000, '2022-06-05 21:09:10'),
(2, 'Pembayaran Hotel Terkonfirmasi', 'reyhan3', 565656, 3, 'Dedanau Hotel', 255000, '2022-06-12 11:29:45'),
(3, 'Pembayaran Hotel Terkonfirmasi', 'reyhan3', 565656, 9, 'Jiwa Jawa Bromo Hotel', 3750000, '2022-06-12 21:08:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `maps`
--

CREATE TABLE `maps` (
  `id_maps` int(11) NOT NULL,
  `kota_kab` varchar(250) NOT NULL,
  `latitude` varchar(250) NOT NULL,
  `longitude` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `maps`
--

INSERT INTO `maps` (`id_maps`, `kota_kab`, `latitude`, `longitude`) VALUES
(1, 'Stadion Gelora Bandung Lautan Api', '-6.957724', '107.712135'),
(2, 'Stasiun Cimekar', '-6.949774', '107.714503'),
(3, 'Ciwidey', '-7.103732', '107.453705'),
(4, 'Cimahi', '-6.873029', '107.542447'),
(5, 'Stasiun Bandung', '-6.914015', '107.602739'),
(6, 'Gedung Sate', '-6.914015', '107.602739'),
(7, 'Tangkuban Perahu', '-6.758772', '107.611885'),
(8, 'Katapang', '-7.00505', '107.550058'),
(9, 'Cibaduyut', '-6.953209', '107.593119'),
(10, 'Jalan Braga', '-6.953209', '107.593119');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `nomor_rekening` int(11) NOT NULL,
  `nomor_kartu` int(11) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `pin` int(11) NOT NULL,
  `saldo` int(12) NOT NULL,
  `id_booking` int(11) DEFAULT NULL,
  `nama_hotel` varchar(250) DEFAULT NULL,
  `nominal` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`nomor_rekening`, `nomor_kartu`, `nama`, `pin`, `saldo`, `id_booking`, `nama_hotel`, `nominal`) VALUES
(98765, 565656, 'reyhan3', 12345, 995000, 9, 'Jiwa Jawa Bromo Hotel', 3750000),
(454545, 343434, 'rizki10', 12345, 12000000, 1, 'Jiwa Jawa Bromo Hotel', 3000000);

--
-- Trigger `transaksi`
--
DELIMITER $$
CREATE TRIGGER `log_pembayaran` BEFORE UPDATE ON `transaksi` FOR EACH ROW BEGIN
INSERT INTO log_transaksi (status, namauser, nomorkartu, idbooking_transaksi, namahotel_transaksi, nominal_transaksi, waktu_transaksi) VALUES ('Pembayaran Hotel Terkonfirmasi', NEW.nama, NEW.nomor_kartu, NEW.id_booking, NEW.nama_hotel, NEW.nominal, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_login` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'default.svg',
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_login`, `username`, `email`, `password`, `name`, `photo`, `admin`) VALUES
(37, 'rizki10', 'rizkiwahyudie@gmail.com', '202cb962ac59075b964b07152d234b70', 'Rizki Wahyudie', 'default.svg', 1),
(44, 'fadil35', 'rizkiwahyudie101201@gmail.com', '202cb962ac59075b964b07152d234b70', 'Ihsan Nur Fadil', 'default.svg', 0),
(45, 'ditaa', 'rizkiwhyd23@gmail.com', '202cb962ac59075b964b07152d234b70', 'Dita Raudya', 'default.svg', 0),
(46, 'reyhan3', 'reyhanap@upi.edu', '202cb962ac59075b964b07152d234b70', 'Reyhan Agus', 'default.svg', 1);

-- --------------------------------------------------------

--
-- Struktur untuk view `admindata`
--
DROP TABLE IF EXISTS `admindata`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `admindata`  AS SELECT concat('00',`users`.`id_login`) AS `id_admin`, `users`.`username` AS `username`, `users`.`name` AS `name`, `users`.`email` AS `email` FROM `users` WHERE `users`.`admin` = 1 ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_login` (`id_login`);

--
-- Indeks untuk tabel `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id_hotel`);

--
-- Indeks untuk tabel `log_booking`
--
ALTER TABLE `log_booking`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `log_transaksi`
--
ALTER TABLE `log_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id_maps`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`nomor_rekening`),
  ADD UNIQUE KEY `nomor_kartu` (`nomor_kartu`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id_hotel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `log_booking`
--
ALTER TABLE `log_booking`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `log_transaksi`
--
ALTER TABLE `log_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `maps`
--
ALTER TABLE `maps`
  MODIFY `id_maps` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `users` (`id_login`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
