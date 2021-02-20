-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2021 at 04:22 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_bioskop`
--

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `durasi` int(3) NOT NULL,
  `aktor` varchar(255) NOT NULL,
  `genre` varchar(10) NOT NULL,
  `kategori` varchar(12) NOT NULL,
  `bahasa` varchar(20) NOT NULL,
  `subtitle` varchar(20) NOT NULL,
  `sutradara` varchar(20) NOT NULL,
  `produksi` varchar(20) NOT NULL,
  `link_trailer` varchar(255) NOT NULL,
  `sinopsis` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  `data_status` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `judul`, `durasi`, `aktor`, `genre`, `kategori`, `bahasa`, `subtitle`, `sutradara`, `produksi`, `link_trailer`, `sinopsis`, `cover`, `data_status`) VALUES
(1, 'James Bond : No Time To Die', 163, 'Daniel Craig, Rami Malek, LÃ©a Seydoux', 'Action', 'Dewasa', 'Inggris', 'Indonesia', 'Cary Joji Fukunaga', 'Metro Goldwyn Mayer', 'https://www.youtube.com/embed/vw2FOYjCz38', 'Bond telah meninggalkan layanan aktif dan menikmati kehidupan yang tenang di Jamaika. Kedamaiannya berumur pendek ketika teman lamanya Felix Leiter dari CIA muncul untuk meminta bantuan. Misi untuk menyelamatkan seorang ilmuwan yang diculik ternyata jauh lebih berbahaya dari yang diperkirakan, membawa Bond ke jejak penjahat misterius yang dipersenjatai dengan teknologi baru yang berbahaya.', '5fbaa68889d05.jpg', 'Aktif'),
(2, 'The SpongeBob Movie: Sponge on the Run', 95, '-', 'Animation', 'Segala Umur', 'Inggris', 'Indonesia', 'Tim Hill', 'Paramount Pictures', 'https://www.youtube.com/embed/HfiH_526qhY', 'Ketika sahabatnya Gary tiba-tiba direnggut, SpongeBob membawa Patrick dalam misi gila yang jauh melampaui Bikini Bottom untuk menyelamatkan teman bercangkang merah muda mereka.', '5fbaa5ed3e269.jpg', 'Upcoming'),
(3, 'John Wick: Parabellum', 133, 'Keanu Reeves, Halle Berry, Ian McShane', 'Action', 'Remaja', 'Inggris', 'Indonesia', 'Chad Stahelski', '-', 'https://www.youtube.com/embed/pU8-7BX9uxs', 'Pembunuh super John Wick kembali dengan label harga $ 14 juta di kepalanya dan pasukan pembunuh pemburu hadiah mengikutinya. Setelah membunuh anggota serikat pembunuh bayaran internasional, High Table, John Wick dikucilkan, tetapi pembunuh bayaran paling kejam di dunia menunggu setiap gilirannya.', '5fbaa8e79b979.jpg', 'Upcoming'),
(4, 'Avengers: Endgame', 180, 'Robert Downey Jr, Chris Evans, Chris Hemsworth', 'Action', 'Remaja', 'Inggris', 'Indonesia', 'Anthony Russo, Joe R', 'Marvel', 'https://www.youtube.com/embed/AMSITikqKiM', 'Setelah peristiwa yang menghancurkan dari Avengers: Infinity War, alam semesta hancur karena upaya Titan Gila, Thanos. Dengan bantuan sekutu yang tersisa, Avengers harus berkumpul sekali lagi untuk membatalkan tindakan Thanos dan memulihkan ketertiban alam semesta untuk selamanya, tidak peduli konsekuensi apa yang mungkin ada.\r\n', '5fbaa9b38fab6.jpg', 'Aktif'),
(5, 'Deadpool 2', 119, 'Ryan Reynolds, Morena Baccarin', 'Action', 'Dewasa', 'Inggris', 'Indonesia', 'David Leitch', 'Marvel', 'https://www.youtube.com/embed/20bpjtCbCz0', 'Deadpool tentara bayaran yang cerdik bertempur melawan Cable yang jahat dan kuat serta orang-orang jahat lainnya untuk menyelamatkan nyawa seorang anak laki-laki.\r\n', '5fbaaa9ebfc34.jpg', 'Aktif'),
(6, 'Mission: Impossible - Fallout', 147, 'Tom Cruise, Ving Rhames', 'Action', 'Remaja', 'Inggris', 'Indonesia', 'Christopher McQuarri', 'Bad Robot Production', 'https://www.youtube.com/embed/XiHiW4N7-bo', 'Ketika misi IMF berakhir dengan buruk, dunia dihadapkan pada konsekuensi yang mengerikan. Saat Ethan Hunt mengambil tanggung jawab untuk memenuhi pengarahan aslinya, CIA mulai mempertanyakan kesetiaan dan motifnya. Tim IMF menemukan diri mereka berpacu dengan waktu, diburu oleh para pembunuh sambil mencoba mencegah bencana global.\r\n', '5fbaab5f4d175.jpg', 'Aktif'),
(7, 'Kingsman: The Golden Circle', 141, 'Taron Egerton, Edward Holcroft, Mark Strong', 'Action', 'Remaja', 'Inggris', 'Indonesia', 'Matthew Vaughn', '20th Century Fox', 'https://www.youtube.com/embed/0fvqnGmr9S8', 'Ketika serangan di markas Kingsman terjadi dan penjahat baru muncul, Eggsy dan Merlin dipaksa untuk bekerja sama dengan agen Amerika yang dikenal sebagai Statesman untuk menyelamatkan dunia.', '5fbaae697f14b.jpg', 'Aktif'),
(8, 'The Fate of the Furious ', 136, 'Vin Diesel, Jason Statham, Dwayne Johnson', 'Action', 'Remaja', 'Inggris', 'Indonesia', 'F. Gary Gray', 'Universal Pictures', 'https://www.youtube.com/embed/JwMKRevYa_M', 'Ketika seorang wanita misterius merayu Dom ke dunia kejahatan dan pengkhianatan terhadap orang-orang terdekatnya, para kru menghadapi cobaan yang akan menguji mereka lebih dari sebelumnya.', '5fbaafd5c5aa3.jpg', 'Aktif'),
(9, 'How to Train Your Dragon: The Hidden World', 144, '-', 'Animation', 'Segala Umur', 'Inggris', 'Indonesia', 'Dean DeBlois', 'DreamWorks Animation', 'https://www.youtube.com/embed/acDHTkslk2w', 'Saat Hiccup memenuhi mimpinya untuk menciptakan utopia naga yang damai, penemuan Toothless tentang pasangan yang liar dan sulit dipahami menarik Night Fury menjauh. Ketika bahaya memuncak di rumah dan pemerintahan Hiccup sebagai kepala desa diuji, baik naga maupun penunggangnya harus membuat keputusan yang mustahil untuk menyelamatkan jenis mereka.\r\n', '5fbab0f29f236.jpg', 'Upcoming'),
(10, 'Fast & Furious Presents: Hobbs & Shaw ', 137, 'Dwayne Johnson, Jason Statham, Idris Elba', 'Action', 'Remaja', 'Inggris', 'Indonesia', 'David Leitch', 'Universal Pictures', 'https://www.youtube.com/embed/HZ7PAyCDwEg', 'Sejak Agen Layanan Keamanan Diplomatik AS Hobbs dan Shaw yang terbuang tanpa hukum pertama kali berhadapan, mereka hanya bertukar pukulan dan kata-kata buruk. Tetapi ketika tindakan kejam anarkis Brixton yang secara genetis meningkatkan dunia maya mengancam masa depan umat manusia, keduanya bergabung untuk mengalahkannya. (Sebuah spin-off dari \"The Fate of the Furious,\" berfokus pada Luke Hobbs dari Johnson dan Deckard Shaw dari Statham.)', '5fbab4744e9c7.jpg', 'Upcoming'),
(11, 'The Lion King', 118, '-', 'Animation', 'Segala Umur', 'Inggris', 'Indonesia', 'Jon Favreau', 'Walt Disney Pictures', 'https://www.youtube.com/embed/7TavVZMewpY', 'Simba mengidolakan ayahnya, Raja Mufasa, dan memperhatikan takdir kerajaannya sendiri. Tapi tidak semua orang di kerajaan merayakan kedatangan anak baru itu. Scar, saudara laki-laki Mufasa â€” dan mantan pewaris takhta â€” punya rencana sendiri. Pertempuran untuk Pride Rock dirusak dengan pengkhianatan, tragedi dan drama, yang pada akhirnya mengakibatkan pengasingan Simba. Dengan bantuan dari sepasang teman baru yang penasaran, Simba harus mencari cara untuk tumbuh dewasa dan mengambil kembali apa yang menjadi haknya.\r\n', '5fbab52de861c.jpg', 'Upcoming'),
(12, 'Jumanji: The Next Level', 123, 'Dwayne Johnson, Kevin Hart', 'Adventure', 'Remaja', 'Inggris', 'Indonesia', 'Jake Kasdan', 'Columbia Pictures', 'https://www.youtube.com/embed/rBxcF-r9Ibs', 'Saat geng kembali ke Jumanji untuk menyelamatkan salah satu dari mereka, mereka menemukan bahwa tidak ada yang seperti yang mereka harapkan. Para pemain harus menantang bagian yang tidak diketahui dan belum dijelajahi untuk melarikan diri dari game paling berbahaya di dunia.', '5fbab5db922d2.jpg', 'Upcoming'),
(13, 'Spider-Man: Far from Home', 129, 'Tom Holland, Samuel L. Jackson', 'Action', 'Remaja', 'Inggris', 'Indonesia', 'Jon Watts', 'Marvel Studio', 'https://www.youtube.com/embed/LFoz8ZJWmPs', 'Peter Parker dan teman-temannya melakukan perjalanan musim panas ke Eropa. Namun, mereka hampir tidak bisa beristirahat - Peter harus setuju untuk membantu Nick Fury mengungkap misteri makhluk yang menyebabkan bencana alam dan kehancuran di seluruh benua.\r\n', '5fbab69328cd5.jpg', 'Aktif'),
(14, 'Star Wars: The Rise of Skywalker', 142, 'Carrie Fisher, Mark Hamill', 'Action', 'Remaja', 'Inggris', 'Indonesia', 'J.J. Abrams', 'Lucasfilm Ltd.', 'https://www.youtube.com/embed/8Qn_spdM5Zg', 'Perlawanan yang bertahan menghadapi First Order sekali lagi seiring perjalanan Rey, Finn dan Poe Dameron berlanjut. Dengan kekuatan dan pengetahuan generasi di belakang mereka, pertempuran terakhir dimulai.\r\n', '5fbab76bc508d.jpg', 'Upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `id_film` int(11) NOT NULL,
  `data_timestamp` int(11) NOT NULL,
  `studio` varchar(5) NOT NULL,
  `harga` int(11) NOT NULL,
  `data_status` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `id_film`, `data_timestamp`, `studio`, `harga`, `data_status`) VALUES
(1, 1, 1763694120, 'B2', 25000, 'Aktif'),
(2, 1, 1763705700, 'B2', 25000, 'Aktif'),
(3, 1, 1763715000, 'B2', 25000, 'Aktif'),
(4, 1, 1763727060, 'B2', 25000, 'Aktif'),
(5, 1, 1763736300, 'B2', 25000, 'Aktif'),
(6, 1, 1763780400, 'B2', 30000, 'Aktif'),
(7, 1, 1763792100, 'B2', 30000, 'Aktif'),
(8, 1, 1763801400, 'B2', 30000, 'Aktif'),
(9, 1, 1763813460, 'B2', 30000, 'Aktif'),
(10, 1, 1763822700, 'B2', 30000, 'Aktif'),
(11, 4, 1763694000, 'A1', 25000, 'Aktif'),
(13, 4, 1763705700, 'A1', 25000, 'Aktif'),
(14, 4, 1763715000, 'A1', 25000, 'Aktif'),
(15, 4, 1763727300, 'A1', 25000, 'Aktif'),
(16, 4, 1763736300, 'A1', 25000, 'Aktif'),
(17, 4, 1763780400, 'A1', 30000, 'Aktif'),
(18, 4, 1763792100, 'A1', 30000, 'Aktif'),
(19, 4, 1763801400, 'A1', 30000, 'Aktif'),
(20, 4, 1763813700, 'A1', 30000, 'Aktif'),
(21, 4, 1763822700, 'A1', 30000, 'Aktif'),
(22, 5, 1763694000, 'C3', 25000, 'Non - Aktif'),
(23, 5, 1763705700, 'C3', 25000, 'Aktif'),
(24, 5, 1763715000, 'C3', 25000, 'Aktif'),
(25, 5, 1763727300, 'C3', 25000, 'Aktif'),
(26, 5, 1763736300, 'C3', 25000, 'Aktif'),
(28, 5, 1763792100, 'C3', 30000, 'Aktif'),
(29, 5, 1763801400, 'C3', 30000, 'Aktif'),
(30, 5, 1763813700, 'C3', 30000, 'Aktif'),
(31, 5, 1763822700, 'C3', 30000, 'Aktif'),
(32, 6, 1763694000, 'D4', 25000, 'Aktif'),
(33, 6, 1763705700, 'D4', 25000, 'Aktif'),
(34, 6, 1763715000, 'D4', 25000, 'Aktif'),
(35, 6, 1763727300, 'D4', 25000, 'Aktif'),
(36, 6, 1763736300, 'D4', 25000, 'Aktif'),
(37, 6, 1763780400, 'D4', 30000, 'Aktif'),
(38, 6, 1763792100, 'D4', 30000, 'Aktif'),
(39, 6, 1763801400, 'D4', 30000, 'Aktif'),
(40, 6, 1763813700, 'D4', 30000, 'Aktif'),
(41, 6, 1763822700, 'D4', 30000, 'Aktif'),
(42, 7, 1763694000, 'E5', 25000, 'Aktif'),
(43, 7, 1763705700, 'E5', 25000, 'Aktif'),
(44, 7, 1763715000, 'E5', 25000, 'Aktif'),
(45, 7, 1763727300, 'E5', 25000, 'Aktif'),
(46, 7, 1763736300, 'E5', 25000, 'Aktif'),
(48, 7, 1763792100, 'E5', 30000, 'Aktif'),
(49, 7, 1763801400, 'E5', 30000, 'Aktif'),
(50, 7, 1763813700, 'E5', 30000, 'Aktif'),
(51, 7, 1763822700, 'E5', 30000, 'Aktif'),
(52, 8, 1763866800, 'A1', 30000, 'Aktif'),
(53, 8, 1763878500, 'A1', 30000, 'Aktif'),
(54, 8, 1763887800, 'A1', 30000, 'Aktif'),
(55, 8, 1763900100, 'A1', 30000, 'Aktif'),
(56, 8, 1763909100, 'A1', 30000, 'Aktif'),
(57, 8, 1763953200, 'A1', 25000, 'Aktif'),
(58, 8, 1763964900, 'A1', 25000, 'Aktif'),
(59, 8, 1763974200, 'A1', 25000, 'Aktif'),
(60, 8, 1763986500, 'A1', 25000, 'Aktif'),
(61, 8, 1763995500, 'A1', 25000, 'Aktif'),
(62, 13, 1763866800, 'B2', 30000, 'Aktif'),
(63, 13, 1763878500, 'B2', 30000, 'Aktif'),
(64, 13, 1763887800, 'B2', 30000, 'Aktif'),
(65, 13, 1763900100, 'B2', 30000, 'Aktif'),
(66, 13, 1763909100, 'B2', 30000, 'Aktif'),
(67, 13, 1763953200, 'B2', 25000, 'Aktif'),
(68, 13, 1763964900, 'B2', 25000, 'Aktif'),
(69, 13, 1763974200, 'B2', 25000, 'Aktif'),
(70, 13, 1763986500, 'B2', 25000, 'Aktif'),
(72, 4, 1763780400, 'E5', 30000, 'Aktif'),
(73, 4, 1763780400, 'C3', 30000, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL,
  `harga_akhir` int(11) NOT NULL,
  `data_timestamp` int(11) NOT NULL,
  `payment_status` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `id_penjualan`, `harga_total`, `harga_akhir`, `data_timestamp`, `payment_status`) VALUES
(1, 1, 50000, 45000, 1605927989, 'BERHASIL'),
(2, 2, 25000, 25000, 1606032465, 'BERHASIL'),
(3, 3, 50000, 45000, 1606148077, 'BERHASIL'),
(4, 4, 25000, 25000, 1606153284, 'BERHASIL'),
(5, 5, 25000, 25000, 1606153264, 'BERHASIL'),
(6, 6, 25000, 25000, 1606153262, 'BERHASIL'),
(7, 7, 50000, 50000, 1608110680, 'BERHASIL'),
(8, 8, 50000, 45000, 1608145175, 'BERHASIL'),
(9, 9, 75000, 75000, 1608145628, 'BERHASIL'),
(10, 10, 100000, 100000, 1608729920, 'BERHASIL'),
(11, 11, 50000, 50000, 0, 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `id_tiket` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `waktu_pembelian` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `id_tiket`, `id_user`, `tanggal_pembelian`, `waktu_pembelian`) VALUES
(1, 1, 2, '2020-11-21', '10:04:52'),
(1, 2, 2, '2020-11-21', '10:04:52'),
(2, 3, 2, '2020-11-22', '15:07:24'),
(3, 4, 2, '2020-11-23', '23:10:51'),
(3, 5, 2, '2020-11-23', '23:10:51'),
(4, 6, 2, '2020-11-23', '23:11:30'),
(5, 7, 2, '2020-11-23', '23:12:03'),
(6, 8, 2, '2020-11-23', '23:12:31'),
(7, 9, 3, '2020-12-16', '16:24:33'),
(7, 10, 3, '2020-12-16', '16:24:33'),
(8, 11, 2, '2020-12-17', '01:57:38'),
(8, 12, 2, '2020-12-17', '01:57:38'),
(9, 13, 3, '2020-12-17', '02:06:57'),
(9, 14, 3, '2020-12-17', '02:06:57'),
(9, 15, 3, '2020-12-17', '02:06:57'),
(10, 16, 2, '2020-12-23', '20:24:58'),
(10, 17, 2, '2020-12-23', '20:24:58'),
(10, 18, 2, '2020-12-23', '20:24:58'),
(10, 19, 2, '2020-12-23', '20:24:58'),
(11, 20, 2, '2020-12-23', '20:58:23'),
(11, 21, 2, '2020-12-23', '20:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `id` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `id_kursi` varchar(5) NOT NULL,
  `tiket_key` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tiket`
--

INSERT INTO `tiket` (`id`, `id_jadwal`, `id_kursi`, `tiket_key`) VALUES
(1, 1, 'G7', '5fb883d4082a9'),
(2, 1, 'G8', '5fb883d4082a9'),
(3, 1, 'K15', '5fba1c3c2300d'),
(4, 1, 'K9', '5fbbdf0b5cc45'),
(5, 1, 'K10', '5fbbdf0b5cc45'),
(6, 1, 'K11', '5fbbdf32bf3c6'),
(7, 1, 'K8', '5fbbdf532449d'),
(8, 1, 'K7', '5fbbdf6fc2b0d'),
(9, 1, 'H8', '5fd9d2510c3bd'),
(10, 1, 'H9', '5fd9d2510c3bd'),
(11, 1, 'I5', '5fda58a1e972d'),
(12, 1, 'I6', '5fda58a1e972d'),
(13, 43, 'H7', '5fda5ad1468d6'),
(14, 43, 'H8', '5fda5ad1468d6'),
(15, 43, 'H9', '5fda5ad1468d6'),
(16, 1, 'G15', '5fe34529e7c63'),
(17, 1, 'F15', '5fe34529e7c63'),
(18, 1, 'D15', '5fe34529e7c63'),
(19, 1, 'E15', '5fe34529e7c63'),
(20, 1, 'E7', '5fe34cff4da7e'),
(21, 1, 'E8', '5fe34cff4da7e');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(12) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `no_hp`, `email`, `password`, `role`) VALUES
(1, 'Ruly Adhika', '2001-02-13', 'Laki-Laki', '082241148983', 'rulihanif@gmail.com', '$2y$10$k136e/CMWwfKrj9uYUn1OumDKbd8No1a3vv8hqyh5s7btBB/FuH4S', 'manajer'),
(2, 'M.Pascal R', '2001-05-01', 'Laki-Laki', '08543027486', 'pascal@gmail.com', '$2y$10$p0oKEOFxzXYRDDQHFBxjb.2dM.mHvI/pFCboFhw5ADJ9cMfveUb.G', 'konsumen'),
(3, 'Sihabudin Affandi', '2001-10-08', 'Laki-Laki', '08950746931', 'sihab@gmail.com', '$2y$10$N90m1k3Q276jJy4uOdAz2OpiHeYq1.8kAOlHOcZTESxS/5CVAOUIi', 'konsumen'),
(4, 'Muh Faris A', '1996-02-12', 'Perempuan', '081104574803', 'faris@gmail.com', '$2y$10$RQ1HToyvD2Whr2GGJAurKO5nOxgNbIiFADBJJJxAammodZzAtim7O', 'petugas'),
(5, 'Vito Bramanta', '2001-06-05', 'Laki-Laki', '08141149831', 'vito@gmail.com', '$2y$10$0xfSITc89Il/5UHR5tzs9umkhUBsYEgTGhIV.0jW8ITj7e7Vp4DJC', 'petugas'),
(6, 'Dhandy Artama', '2001-04-11', 'Laki-Laki', '081931875394', 'dhandy@gmail.com', '$2y$10$zsQeEtAgxTT25E8WBbRGTOsOgwo8IDdb4/wlhNlTMl5ec.vq84TLe', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id` int(11) NOT NULL,
  `kode` varchar(25) NOT NULL,
  `persentase` int(2) NOT NULL,
  `data_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`id`, `kode`, `persentase`, `data_status`) VALUES
(1, 'HNFGRANDOPENING10', 10, 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_film` (`id_film`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`,`id_tiket`) USING BTREE,
  ADD KEY `id_tiket` (`id_tiket`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
