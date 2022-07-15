-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2022 at 03:08 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_siapkerja`
--

-- --------------------------------------------------------

--
-- Table structure for table `config_kuisioner`
--

CREATE TABLE `config_kuisioner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `config_kuisioner`
--

INSERT INTO `config_kuisioner` (`id`, `start_date`, `end_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '2021-11-01', '2022-11-30', 1, 1, '2021-11-05 08:46:59', '2021-11-08 02:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_kuisioner`
--

CREATE TABLE `jawaban_kuisioner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_manajemen_kuisioner` bigint(20) DEFAULT NULL,
  `id_manajemen_kuisioner_jawaban` bigint(20) DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bobot` double NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `kode_wilayah` bigint(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tingkat` tinyint(4) NOT NULL DEFAULT '0',
  `id_prov` bigint(20) DEFAULT NULL,
  `id_kab` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jawaban_kuisioner`
--

INSERT INTO `jawaban_kuisioner` (`id`, `tahun`, `id_manajemen_kuisioner`, `id_manajemen_kuisioner_jawaban`, `value`, `bobot`, `type`, `kode_wilayah`, `created_by`, `created_at`, `updated_at`, `tingkat`, `id_prov`, `id_kab`) VALUES
(1, '2021', 1, 1, '1', 2, 1, 32, 2, NULL, NULL, 2, 32, NULL),
(2, '2021', 1, 1, '1', 2, 1, 33, 2, NULL, NULL, 3, 33, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manajemen_berita`
--

CREATE TABLE `manajemen_berita` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_prov` int(11) NOT NULL,
  `id_kab` int(11) NOT NULL,
  `judul_berita` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manajemen_berita`
--

INSERT INTO `manajemen_berita` (`id`, `id_user`, `id_prov`, `id_kab`, `judul_berita`, `tanggal`, `link`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 9, 32, 3215, 'Info terkini', '2021-11-09', 'www.soultechnology88.blogspot.com', '1636467646.png', '2021-11-09 14:20:46', '2021-11-09 14:20:46'),
(2, 5, 32, 1, 'Info terkini prov', '2021-11-09', 'www.soultechnology88.blogspot.com', '1636467742.png', '2021-11-09 14:22:22', '2021-11-09 14:22:22'),
(3, 9, 32, 3215, 'info valid 2', '2021-11-09', 'www.soultechnology88.blogspot.com', '1636473760.png', '2021-11-09 16:02:40', '2021-11-09 16:02:40'),
(4, 9, 32, 3215, 'Purwakarta jaya', '2021-12-08', 'www.soultechnology88.blogspot.com', '1638970943.jpg', '2021-12-08 13:42:23', '2021-12-08 13:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `manajemen_investasi`
--

CREATE TABLE `manajemen_investasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jan` double NOT NULL DEFAULT '0',
  `feb` double NOT NULL DEFAULT '0',
  `mar` double NOT NULL DEFAULT '0',
  `apr` double NOT NULL DEFAULT '0',
  `mei` double NOT NULL DEFAULT '0',
  `jun` double NOT NULL DEFAULT '0',
  `jul` double NOT NULL DEFAULT '0',
  `agu` double NOT NULL DEFAULT '0',
  `sep` double NOT NULL DEFAULT '0',
  `okt` double NOT NULL DEFAULT '0',
  `nov` double NOT NULL DEFAULT '0',
  `des` double NOT NULL DEFAULT '0',
  `total_realisasi` double NOT NULL DEFAULT '0',
  `nilai_anggaran` double NOT NULL DEFAULT '0',
  `kode_wilayah` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_prov` bigint(20) DEFAULT NULL,
  `id_kab` bigint(20) DEFAULT NULL,
  `tingkat` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manajemen_kategori`
--

CREATE TABLE `manajemen_kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manajemen_kategori`
--

INSERT INTO `manajemen_kategori` (`id`, `name`, `pos`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Kedewasaan', 1, 1, NULL, '2021-11-03 08:43:43', '2021-11-03 08:43:43'),
(2, 'Romantisme', 2, 4, NULL, '2021-11-03 08:45:06', '2021-11-03 08:45:06'),
(3, 'Kebersamaan', 3, 1, NULL, '2021-11-05 07:04:11', '2021-11-05 07:04:11'),
(4, 'Kekeluargaan', 4, 1, NULL, '2021-11-05 07:05:26', '2021-11-05 07:05:26');

-- --------------------------------------------------------

--
-- Table structure for table `manajemen_kuisioner`
--

CREATE TABLE `manajemen_kuisioner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_manajemen_kategori` bigint(20) DEFAULT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `pos` int(11) NOT NULL DEFAULT '1',
  `is_need_text` tinyint(4) NOT NULL DEFAULT '0',
  `is_need_upload` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manajemen_kuisioner`
--

INSERT INTO `manajemen_kuisioner` (`id`, `id_manajemen_kategori`, `question`, `pos`, `is_need_text`, `is_need_upload`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 1, 'Jika anda di tawari bertengkar dengan rekan anda, apa yang anda lakukan ?', 1, 0, 0, 1, NULL, '2021-11-08 02:26:14', '2021-11-08 02:26:14', 0),
(2, 1, 'Anda sedang sibuk namun ibu anda menyuruh anda untuk membeli beras di warung, apakah anda akan ke warung ?', 2, 1, 0, 1, NULL, '2021-11-08 02:27:40', '2021-11-08 02:27:40', 0),
(3, 1, 'Hobi atau Pekerjaan ?', 3, 1, 0, 1, NULL, '2021-11-08 02:29:40', '2021-11-08 02:29:40', 0),
(4, 2, 'Pasangan anda menginginkan makan malam romantis bersama anda, apa yang anda lakukan ?', 4, 0, 1, 1, NULL, '2021-11-08 02:43:20', '2021-11-08 02:43:20', 0),
(5, 2, 'Pasangan anda mengajak anda untuk segera menikah, namun anda sedang dalam ikatan dinas, yang anda lakukan ?', 5, 0, 0, 1, NULL, '2021-11-08 02:45:03', '2021-11-08 02:45:03', 0),
(6, 3, 'Rekan kantor anda membutuhkan bantuan anda , apa yang anda lakukan ?', 6, 0, 0, 1, NULL, '2021-11-08 02:54:15', '2021-11-08 02:54:15', 0),
(7, 3, 'Anda mendengar salah satu rekan kerja anda sedang sakit, dan anda sedang banyak pekerjaan. Apa yang akan anda lakukan ?', 7, 1, 0, 1, NULL, '2021-11-08 02:55:30', '2021-11-08 02:55:30', 0),
(8, 4, 'Ibu anda membutuhkan anda dirumah, namun anda sudah tidak memiliki cuti, apa yang anda lakukan ?', 8, 1, 0, 1, NULL, '2021-11-08 02:57:06', '2021-11-08 02:57:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `manajemen_kuisioner_jawaban`
--

CREATE TABLE `manajemen_kuisioner_jawaban` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_manajemen_kuisioner` bigint(20) DEFAULT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` double NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manajemen_kuisioner_jawaban`
--

INSERT INTO `manajemen_kuisioner_jawaban` (`id`, `id_manajemen_kuisioner`, `label`, `bobot`, `type`, `created_at`, `updated_at`, `is_deleted`, `created_by`, `updated_by`) VALUES
(1, 1, 'Menolaknya', 4, 0, '2021-11-08 02:26:14', '2021-11-08 02:26:14', 0, 1, NULL),
(2, 1, 'Menerima', 1, 0, '2021-11-08 02:26:15', '2021-11-08 02:26:15', 0, 1, NULL),
(3, 1, 'Mengajak Berdiskusi', 3, 0, '2021-11-08 02:26:15', '2021-11-08 02:26:15', 0, 1, NULL),
(4, 1, 'Menghindarinya', 2, 0, '2021-11-08 02:26:15', '2021-11-08 02:26:15', 0, 1, NULL),
(5, 2, 'Ya', 3, 0, '2021-11-08 02:27:42', '2021-11-08 02:27:42', 0, 1, NULL),
(6, 2, 'Tidak', 1, 0, '2021-11-08 02:27:42', '2021-11-08 02:27:42', 0, 1, NULL),
(7, 2, 'Alasannya ? (jika ada)', 4, 1, '2021-11-08 02:27:42', '2021-11-08 02:27:42', 0, 1, NULL),
(8, 3, 'Hobi', 2, 0, '2021-11-08 02:29:42', '2021-11-08 02:29:42', 0, 1, NULL),
(9, 3, 'Pekerjaan', 3, 0, '2021-11-08 02:29:42', '2021-11-08 02:29:42', 0, 1, NULL),
(10, 3, 'Tidak Keduanya', 1, 0, '2021-11-08 02:29:42', '2021-11-08 02:29:42', 0, 1, NULL),
(11, 3, 'Alasannya ? (jika ada)', 3, 1, '2021-11-08 02:29:43', '2021-11-08 02:29:43', 0, 1, NULL),
(12, 4, 'Segera melakukan reservasi', 5, 0, '2021-11-08 02:43:22', '2021-11-08 02:43:22', 0, 1, NULL),
(13, 4, 'Melakukan perdebatan terlebih dahulu', 2, 0, '2021-11-08 02:43:22', '2021-11-08 02:43:22', 0, 1, NULL),
(14, 4, 'Menolaknya mentah mentah', 1, 0, '2021-11-08 02:43:22', '2021-11-08 02:43:22', 0, 1, NULL),
(15, 4, 'Suasana makan malam yang anda inginkan', 3, 2, '2021-11-08 02:43:23', '2021-11-08 02:43:23', 0, 1, NULL),
(16, 5, 'Menikah secara diam diam', 2, 0, '2021-11-08 02:45:05', '2021-11-08 02:45:05', 0, 1, NULL),
(17, 5, 'Memberikan pengertian pada pasangan untuk lebih sabar', 4, 0, '2021-11-08 02:45:05', '2021-11-08 02:45:05', 0, 1, NULL),
(18, 5, 'Tidak menghiraukannya', 1, 0, '2021-11-08 02:45:05', '2021-11-08 02:45:05', 0, 1, NULL),
(19, 6, 'Segera membantunya', 3, 0, '2021-11-08 02:54:16', '2021-11-08 02:54:16', 0, 1, NULL),
(20, 6, 'Membantunya setelah pekerjaan saya selesai', 5, 0, '2021-11-08 02:54:16', '2021-11-08 02:54:16', 0, 1, NULL),
(21, 6, 'Menghiraukannya', 2, 0, '2021-11-08 02:54:16', '2021-11-08 02:54:16', 0, 1, NULL),
(22, 6, 'Hanya bertanya sebagai basa basi', 1, 0, '2021-11-08 02:54:16', '2021-11-08 02:54:16', 0, 1, NULL),
(23, 7, 'Segera menjenguknya', 4, 0, '2021-11-08 02:55:32', '2021-11-08 02:55:32', 0, 1, NULL),
(24, 7, 'Perkejaan yang utama', 2, 0, '2021-11-08 02:55:32', '2021-11-08 02:55:32', 0, 1, NULL),
(25, 7, 'Berikan kami alasannya (jika ada)', 2, 1, '2021-11-08 02:55:32', '2021-11-08 02:55:32', 0, 1, NULL),
(26, 8, 'Segera memenuhi permintaan ibu, meski gaji harus dipotong', 5, 0, '2021-11-08 02:57:08', '2021-11-08 02:57:08', 0, 1, NULL),
(27, 8, 'Menolaknya dengan alasan gaji tidak mau di potong', 1, 0, '2021-11-08 02:57:08', '2021-11-08 02:57:08', 0, 1, NULL),
(28, 8, 'Berikan kami alasannya (jika ada)', 3, 1, '2021-11-08 02:57:08', '2021-11-08 02:57:08', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manajemen_peraturan`
--

CREATE TABLE `manajemen_peraturan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nama_peraturan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `file_pendukung` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manajemen_peraturan`
--

INSERT INTO `manajemen_peraturan` (`id`, `created_at`, `updated_at`, `nama_peraturan`, `tanggal`, `file_pendukung`) VALUES
(1, '2021-11-09 14:18:17', '2021-11-09 14:18:17', 'RU KUHP', '2021-11-09', '1636467497.pdf'),
(2, '2021-12-08 13:44:27', '2021-12-08 13:44:27', 'Cipta kerja', '2021-12-08', '1638971067.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `manajemen_users`
--

CREATE TABLE `manajemen_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pengguna` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peran_pengguna` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `id_provinsi` int(11) NOT NULL,
  `id_kab` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manajemen_users`
--

INSERT INTO `manajemen_users` (`id`, `nama_pengguna`, `peran_pengguna`, `email`, `email_verified_at`, `id_provinsi`, `id_kab`, `status`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'FirstAdministrator', '1', 'first.admin@gmail.com', NULL, 32, 1, 1, '$2y$10$p7C0e5wpD9geJO/mOVLRROIY1YX19vQmU/ZQkMH0jhe.hZqS.c.g2', NULL, NULL, '2021-12-08 13:46:33'),
(2, 'SecondAdministrator', '1', 'second.admin@gmail.com', NULL, 32, 1, 0, '$2y$10$TGIiBV3ZGnCJiHDc1HoAMe9v0x0nLLCQJRHDT/cjcVyZog6MY1UO6', NULL, NULL, NULL),
(3, 'ThirdAdministrator', '1', 'third.admin@gmail.com', NULL, 32, 1, 0, '$2y$10$K1GqipybYeufmHhJpvNWKe3lLes2aduIEf442h.8kEkrjstF0lWme', NULL, NULL, NULL),
(4, 'FourthAdministrator', '1', 'Fourth.admin@gmail.com', NULL, 32, 1, 0, '$2y$10$mxqLRpBzUop2U4yKyBPHk.sBF2rCLkr/WMtaDj4ulFlclu5V5HcnO', NULL, NULL, NULL),
(5, 'FirstProvinsi', '2', 'first.ptspprovinsi@gmail.com', NULL, 32, 1, 0, '$2y$10$c/OLkCoihdP5bXj6XROIquFyWmF7LJ1Xk8vBHVJio6Wf3VleieCB2', NULL, NULL, NULL),
(6, 'SecondProvinsi', '2', 'second.ptspprovinsi@gmail.com', NULL, 32, 1, 0, '$2y$10$3kpMmpknOzwAGzi4KTnUJuS6LSbTdpIZPaUn0sjKjS7OC2z5UJ0J6', NULL, NULL, NULL),
(7, 'ThirdProvinsi', '2', 'third.ptspprovinsi@gmail.com', NULL, 32, 1, 0, '$2y$10$FKKjG.jUfXzLQCus2AU4pu6kn65mjLBXJq6Ul8xMUC79Xx0fgwuPa', NULL, NULL, NULL),
(8, 'FourthProvinsi', '2', 'Fourth.ptspprovinsi@gmail.com', NULL, 32, 1, 0, '$2y$10$8tZi8tHm1GMyo0kxqn/MguQYrPa/gUFkKeaFnZGjA.VphdPLEyJoW', NULL, NULL, NULL),
(9, 'FirstKabupaten', '3', 'first.ptspkab@gmail.com', NULL, 32, 3215, 0, '$2y$10$qLl8DaKCuW0XaZnsoTHjO.1VA1i8eDy94rqIwbCTabqYHlO.4PO0W', NULL, NULL, NULL),
(10, 'SecondKabupaten', '3', 'second.ptspkab@gmail.com', NULL, 32, 3215, 0, '$2y$10$ByylbUFyZ2/kcxQZrpO.mOMuTASlyHjP7hd84m7JeNmM74kwSGove', NULL, NULL, NULL),
(11, 'ThirdKabupaten', '3', 'third.ptspkab@gmail.com', NULL, 32, 3215, 0, '$2y$10$bvALfIwadv.L7wLM7j.5u.mT2jxxAOV/mSyxWY2y5XuEgWKaDnSIS', NULL, NULL, NULL),
(12, 'FourthKabupaten', '3', 'Fourth.ptspkab@gmail.com', NULL, 32, 3215, 0, '$2y$10$sV8HVrG/.YY7OU8lXQcqr.eD8RXlFQJmMYfTjE6.jI84R/evfx3Di', NULL, NULL, NULL),
(13, 'FirstPengguna', '4', 'first.pengguna@gmail.com', NULL, 32, 1, 0, '$2y$10$Dis/FP7S0hGI2ogR2dmHL.dwub3MUFOQ9JIqPqtddrl18W6hSuUpu', NULL, NULL, NULL),
(14, 'SecondPengguna', '4', 'second.pengguna@gmail.com', NULL, 32, 1, 0, '$2y$10$H4fc41.EVgCwznDvn08eb.faHUqaykl9uDzRgIn5rOJL.cTu7lDLC', NULL, NULL, NULL),
(15, 'ThirdPengguna', '4', 'third.pengguna@gmail.com', NULL, 32, 1, 0, '$2y$10$XgwaakFHHtTyxcP3uGWzKuxJRv8cxqPK01dgUavPguWk4FvBR/jk.', NULL, NULL, NULL),
(16, 'FourthPengguna', '4', 'Fourth.pengguna@gmail.com', NULL, 32, 1, 0, '$2y$10$b71T1b7PEHDQVl2AdjDd4uMIk5y0J6xPtUHFw6Bl0L.sHo5AuvADq', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_manajemen_user_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_10_31_120917_create_table_manajemen_investasi', 1),
(5, '2021_11_01_145357_create_manajemen_berita_table', 1),
(6, '2021_11_01_222036_create_m_provinsi', 1),
(7, '2021_11_01_222043_create_m_kabupaten_kota', 1),
(8, '2021_11_02_004604_create_manajemen_kategori', 1),
(9, '2021_11_02_232952_create_manajemen_kuisioner', 1),
(10, '2021_11_02_235736_create_manajemen_kuisioner_jawaban', 1),
(11, '2021_11_03_171535_rename_column_value_kuisioner_jawaban', 1),
(12, '2021_11_03_222641_add_column_start_date_end_date', 1),
(13, '2021_11_03_224959_is_deleted_on_manajemen_kuisioner_jawaban', 1),
(14, '2021_11_03_231723_created_by_updated_by_on_manajemen_kuisioner_jawaban', 1),
(15, '2021_11_04_004350_is_deleted_on_manajemen_kuisioner', 1),
(16, '2021_11_04_103941_create_table_manajemen_peraturan', 1),
(17, '2021_11_04_170904_add_column_id_prov_id_kab_manajemen_investasi', 1),
(18, '2021_11_04_234603_create_jawaban_kuisioner', 1),
(19, '2021_11_05_141640_create_config_kuisioner', 1),
(20, '2021_11_06_181220_drop_column_date_manajemen_kuisioner', 1),
(21, '2021_11_08_164529_add_column_tingkat_manajemen_investasi', 1),
(22, '2021_11_08_164636_add_column_tingkat_id_prov_id_kab_jawaban_kuisioner', 1),
(23, '2021_11_08_172122_modify_column_value', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_kabupaten_kota`
--

CREATE TABLE `m_kabupaten_kota` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `m_provinsi` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_kabupaten_kota`
--

INSERT INTO `m_kabupaten_kota` (`id`, `m_provinsi`, `nama`, `created_at`, `updated_at`) VALUES
(1101, 11, 'KABUPATEN SIMEULUE', NULL, NULL),
(1102, 11, 'KABUPATEN ACEH SINGKIL', NULL, NULL),
(1103, 11, 'KABUPATEN ACEH SELATAN', NULL, NULL),
(1104, 11, 'KABUPATEN ACEH TENGGARA', NULL, NULL),
(1105, 11, 'KABUPATEN ACEH TIMUR', NULL, NULL),
(1106, 11, 'KABUPATEN ACEH TENGAH', NULL, NULL),
(1107, 11, 'KABUPATEN ACEH BARAT', NULL, NULL),
(1108, 11, 'KABUPATEN ACEH BESAR', NULL, NULL),
(1109, 11, 'KABUPATEN PIDIE', NULL, NULL),
(1110, 11, 'KABUPATEN BIREUEN', NULL, NULL),
(1111, 11, 'KABUPATEN ACEH UTARA', NULL, NULL),
(1112, 11, 'KABUPATEN ACEH BARAT DAYA', NULL, NULL),
(1113, 11, 'KABUPATEN GAYO LUES', NULL, NULL),
(1114, 11, 'KABUPATEN ACEH TAMIANG', NULL, NULL),
(1115, 11, 'KABUPATEN NAGAN RAYA', NULL, NULL),
(1116, 11, 'KABUPATEN ACEH JAYA', NULL, NULL),
(1117, 11, 'KABUPATEN BENER MERIAH', NULL, NULL),
(1118, 11, 'KABUPATEN PIDIE JAYA', NULL, NULL),
(1171, 11, 'KOTA BANDA ACEH', NULL, NULL),
(1172, 11, 'KOTA SABANG', NULL, NULL),
(1173, 11, 'KOTA LANGSA', NULL, NULL),
(1174, 11, 'KOTA LHOKSEUMAWE', NULL, NULL),
(1175, 11, 'KOTA SUBULUSSALAM', NULL, NULL),
(1201, 12, 'KABUPATEN NIAS', NULL, NULL),
(1202, 12, 'KABUPATEN MANDAILING NATAL', NULL, NULL),
(1203, 12, 'KABUPATEN TAPANULI SELATAN', NULL, NULL),
(1204, 12, 'KABUPATEN TAPANULI TENGAH', NULL, NULL),
(1205, 12, 'KABUPATEN TAPANULI UTARA', NULL, NULL),
(1206, 12, 'KABUPATEN TOBA SAMOSIR', NULL, NULL),
(1207, 12, 'KABUPATEN LABUHAN BATU', NULL, NULL),
(1208, 12, 'KABUPATEN ASAHAN', NULL, NULL),
(1209, 12, 'KABUPATEN SIMALUNGUN', NULL, NULL),
(1210, 12, 'KABUPATEN DAIRI', NULL, NULL),
(1211, 12, 'KABUPATEN KARO', NULL, NULL),
(1212, 12, 'KABUPATEN DELI SERDANG', NULL, NULL),
(1213, 12, 'KABUPATEN LANGKAT', NULL, NULL),
(1214, 12, 'KABUPATEN NIAS SELATAN', NULL, NULL),
(1215, 12, 'KABUPATEN HUMBANG HASUNDUTAN', NULL, NULL),
(1216, 12, 'KABUPATEN PAKPAK BHARAT', NULL, NULL),
(1217, 12, 'KABUPATEN SAMOSIR', NULL, NULL),
(1218, 12, 'KABUPATEN SERDANG BEDAGAI', NULL, NULL),
(1219, 12, 'KABUPATEN BATU BARA', NULL, NULL),
(1220, 12, 'KABUPATEN PADANG LAWAS UTARA', NULL, NULL),
(1221, 12, 'KABUPATEN PADANG LAWAS', NULL, NULL),
(1222, 12, 'KABUPATEN LABUHAN BATU SELATAN', NULL, NULL),
(1223, 12, 'KABUPATEN LABUHAN BATU UTARA', NULL, NULL),
(1224, 12, 'KABUPATEN NIAS UTARA', NULL, NULL),
(1225, 12, 'KABUPATEN NIAS BARAT', NULL, NULL),
(1271, 12, 'KOTA SIBOLGA', NULL, NULL),
(1272, 12, 'KOTA TANJUNG BALAI', NULL, NULL),
(1273, 12, 'KOTA PEMATANG SIANTAR', NULL, NULL),
(1274, 12, 'KOTA TEBING TINGGI', NULL, NULL),
(1275, 12, 'KOTA MEDAN', NULL, NULL),
(1276, 12, 'KOTA BINJAI', NULL, NULL),
(1277, 12, 'KOTA PADANGSIDIMPUAN', NULL, NULL),
(1278, 12, 'KOTA GUNUNGSITOLI', NULL, NULL),
(1301, 13, 'KABUPATEN KEPULAUAN MENTAWAI', NULL, NULL),
(1302, 13, 'KABUPATEN PESISIR SELATAN', NULL, NULL),
(1303, 13, 'KABUPATEN SOLOK', NULL, NULL),
(1304, 13, 'KABUPATEN SIJUNJUNG', NULL, NULL),
(1305, 13, 'KABUPATEN TANAH DATAR', NULL, NULL),
(1306, 13, 'KABUPATEN PADANG PARIAMAN', NULL, NULL),
(1307, 13, 'KABUPATEN AGAM', NULL, NULL),
(1308, 13, 'KABUPATEN LIMA PULUH KOTA', NULL, NULL),
(1309, 13, 'KABUPATEN PASAMAN', NULL, NULL),
(1310, 13, 'KABUPATEN SOLOK SELATAN', NULL, NULL),
(1311, 13, 'KABUPATEN DHARMASRAYA', NULL, NULL),
(1312, 13, 'KABUPATEN PASAMAN BARAT', NULL, NULL),
(1371, 13, 'KOTA PADANG', NULL, NULL),
(1372, 13, 'KOTA SOLOK', NULL, NULL),
(1373, 13, 'KOTA SAWAH LUNTO', NULL, NULL),
(1374, 13, 'KOTA PADANG PANJANG', NULL, NULL),
(1375, 13, 'KOTA BUKITTINGGI', NULL, NULL),
(1376, 13, 'KOTA PAYAKUMBUH', NULL, NULL),
(1377, 13, 'KOTA PARIAMAN', NULL, NULL),
(1401, 14, 'KABUPATEN KUANTAN SINGINGI', NULL, NULL),
(1402, 14, 'KABUPATEN INDRAGIRI HULU', NULL, NULL),
(1403, 14, 'KABUPATEN INDRAGIRI HILIR', NULL, NULL),
(1404, 14, 'KABUPATEN PELALAWAN', NULL, NULL),
(1405, 14, 'KABUPATEN S I A K', NULL, NULL),
(1406, 14, 'KABUPATEN KAMPAR', NULL, NULL),
(1407, 14, 'KABUPATEN ROKAN HULU', NULL, NULL),
(1408, 14, 'KABUPATEN BENGKALIS', NULL, NULL),
(1409, 14, 'KABUPATEN ROKAN HILIR', NULL, NULL),
(1410, 14, 'KABUPATEN KEPULAUAN MERANTI', NULL, NULL),
(1471, 14, 'KOTA PEKANBARU', NULL, NULL),
(1473, 14, 'KOTA D U M A I', NULL, NULL),
(1501, 15, 'KABUPATEN KERINCI', NULL, NULL),
(1502, 15, 'KABUPATEN MERANGIN', NULL, NULL),
(1503, 15, 'KABUPATEN SAROLANGUN', NULL, NULL),
(1504, 15, 'KABUPATEN BATANG HARI', NULL, NULL),
(1505, 15, 'KABUPATEN MUARO JAMBI', NULL, NULL),
(1506, 15, 'KABUPATEN TANJUNG JABUNG TIMUR', NULL, NULL),
(1507, 15, 'KABUPATEN TANJUNG JABUNG BARAT', NULL, NULL),
(1508, 15, 'KABUPATEN TEBO', NULL, NULL),
(1509, 15, 'KABUPATEN BUNGO', NULL, NULL),
(1571, 15, 'KOTA JAMBI', NULL, NULL),
(1572, 15, 'KOTA SUNGAI PENUH', NULL, NULL),
(1601, 16, 'KABUPATEN OGAN KOMERING ULU', NULL, NULL),
(1602, 16, 'KABUPATEN OGAN KOMERING ILIR', NULL, NULL),
(1603, 16, 'KABUPATEN MUARA ENIM', NULL, NULL),
(1604, 16, 'KABUPATEN LAHAT', NULL, NULL),
(1605, 16, 'KABUPATEN MUSI RAWAS', NULL, NULL),
(1606, 16, 'KABUPATEN MUSI BANYUASIN', NULL, NULL),
(1607, 16, 'KABUPATEN BANYU ASIN', NULL, NULL),
(1608, 16, 'KABUPATEN OGAN KOMERING ULU SELATAN', NULL, NULL),
(1609, 16, 'KABUPATEN OGAN KOMERING ULU TIMUR', NULL, NULL),
(1610, 16, 'KABUPATEN OGAN ILIR', NULL, NULL),
(1611, 16, 'KABUPATEN EMPAT LAWANG', NULL, NULL),
(1612, 16, 'KABUPATEN PENUKAL ABAB LEMATANG ILIR', NULL, NULL),
(1613, 16, 'KABUPATEN MUSI RAWAS UTARA', NULL, NULL),
(1671, 16, 'KOTA PALEMBANG', NULL, NULL),
(1672, 16, 'KOTA PRABUMULIH', NULL, NULL),
(1673, 16, 'KOTA PAGAR ALAM', NULL, NULL),
(1674, 16, 'KOTA LUBUKLINGGAU', NULL, NULL),
(1701, 17, 'KABUPATEN BENGKULU SELATAN', NULL, NULL),
(1702, 17, 'KABUPATEN REJANG LEBONG', NULL, NULL),
(1703, 17, 'KABUPATEN BENGKULU UTARA', NULL, NULL),
(1704, 17, 'KABUPATEN KAUR', NULL, NULL),
(1705, 17, 'KABUPATEN SELUMA', NULL, NULL),
(1706, 17, 'KABUPATEN MUKOMUKO', NULL, NULL),
(1707, 17, 'KABUPATEN LEBONG', NULL, NULL),
(1708, 17, 'KABUPATEN KEPAHIANG', NULL, NULL),
(1709, 17, 'KABUPATEN BENGKULU TENGAH', NULL, NULL),
(1771, 17, 'KOTA BENGKULU', NULL, NULL),
(1801, 18, 'KABUPATEN LAMPUNG BARAT', NULL, NULL),
(1802, 18, 'KABUPATEN TANGGAMUS', NULL, NULL),
(1803, 18, 'KABUPATEN LAMPUNG SELATAN', NULL, NULL),
(1804, 18, 'KABUPATEN LAMPUNG TIMUR', NULL, NULL),
(1805, 18, 'KABUPATEN LAMPUNG TENGAH', NULL, NULL),
(1806, 18, 'KABUPATEN LAMPUNG UTARA', NULL, NULL),
(1807, 18, 'KABUPATEN WAY KANAN', NULL, NULL),
(1808, 18, 'KABUPATEN TULANGBAWANG', NULL, NULL),
(1809, 18, 'KABUPATEN PESAWARAN', NULL, NULL),
(1810, 18, 'KABUPATEN PRINGSEWU', NULL, NULL),
(1811, 18, 'KABUPATEN MESUJI', NULL, NULL),
(1812, 18, 'KABUPATEN TULANG BAWANG BARAT', NULL, NULL),
(1813, 18, 'KABUPATEN PESISIR BARAT', NULL, NULL),
(1871, 18, 'KOTA BANDAR LAMPUNG', NULL, NULL),
(1872, 18, 'KOTA METRO', NULL, NULL),
(1901, 19, 'KABUPATEN BANGKA', NULL, NULL),
(1902, 19, 'KABUPATEN BELITUNG', NULL, NULL),
(1903, 19, 'KABUPATEN BANGKA BARAT', NULL, NULL),
(1904, 19, 'KABUPATEN BANGKA TENGAH', NULL, NULL),
(1905, 19, 'KABUPATEN BANGKA SELATAN', NULL, NULL),
(1906, 19, 'KABUPATEN BELITUNG TIMUR', NULL, NULL),
(1971, 19, 'KOTA PANGKAL PINANG', NULL, NULL),
(2101, 21, 'KABUPATEN KARIMUN', NULL, NULL),
(2102, 21, 'KABUPATEN BINTAN', NULL, NULL),
(2103, 21, 'KABUPATEN NATUNA', NULL, NULL),
(2104, 21, 'KABUPATEN LINGGA', NULL, NULL),
(2105, 21, 'KABUPATEN KEPULAUAN ANAMBAS', NULL, NULL),
(2171, 21, 'KOTA B A T A M', NULL, NULL),
(2172, 21, 'KOTA TANJUNG PINANG', NULL, NULL),
(3101, 31, 'KABUPATEN KEPULAUAN SERIBU', NULL, NULL),
(3171, 31, 'KOTA JAKARTA SELATAN', NULL, NULL),
(3172, 31, 'KOTA JAKARTA TIMUR', NULL, NULL),
(3173, 31, 'KOTA JAKARTA PUSAT', NULL, NULL),
(3174, 31, 'KOTA JAKARTA BARAT', NULL, NULL),
(3175, 31, 'KOTA JAKARTA UTARA', NULL, NULL),
(3201, 32, 'KABUPATEN BOGOR', NULL, NULL),
(3202, 32, 'KABUPATEN SUKABUMI', NULL, NULL),
(3203, 32, 'KABUPATEN CIANJUR', NULL, NULL),
(3204, 32, 'KABUPATEN BANDUNG', NULL, NULL),
(3205, 32, 'KABUPATEN GARUT', NULL, NULL),
(3206, 32, 'KABUPATEN TASIKMALAYA', NULL, NULL),
(3207, 32, 'KABUPATEN CIAMIS', NULL, NULL),
(3208, 32, 'KABUPATEN KUNINGAN', NULL, NULL),
(3209, 32, 'KABUPATEN CIREBON', NULL, NULL),
(3210, 32, 'KABUPATEN MAJALENGKA', NULL, NULL),
(3211, 32, 'KABUPATEN SUMEDANG', NULL, NULL),
(3212, 32, 'KABUPATEN INDRAMAYU', NULL, NULL),
(3213, 32, 'KABUPATEN SUBANG', NULL, NULL),
(3214, 32, 'KABUPATEN PURWAKARTA', NULL, NULL),
(3215, 32, 'KABUPATEN KARAWANG', NULL, NULL),
(3216, 32, 'KABUPATEN BEKASI', NULL, NULL),
(3217, 32, 'KABUPATEN BANDUNG BARAT', NULL, NULL),
(3218, 32, 'KABUPATEN PANGANDARAN', NULL, NULL),
(3271, 32, 'KOTA BOGOR', NULL, NULL),
(3272, 32, 'KOTA SUKABUMI', NULL, NULL),
(3273, 32, 'KOTA BANDUNG', NULL, NULL),
(3274, 32, 'KOTA CIREBON', NULL, NULL),
(3275, 32, 'KOTA BEKASI', NULL, NULL),
(3276, 32, 'KOTA DEPOK', NULL, NULL),
(3277, 32, 'KOTA CIMAHI', NULL, NULL),
(3278, 32, 'KOTA TASIKMALAYA', NULL, NULL),
(3279, 32, 'KOTA BANJAR', NULL, NULL),
(3301, 33, 'KABUPATEN CILACAP', NULL, NULL),
(3302, 33, 'KABUPATEN BANYUMAS', NULL, NULL),
(3303, 33, 'KABUPATEN PURBALINGGA', NULL, NULL),
(3304, 33, 'KABUPATEN BANJARNEGARA', NULL, NULL),
(3305, 33, 'KABUPATEN KEBUMEN', NULL, NULL),
(3306, 33, 'KABUPATEN PURWOREJO', NULL, NULL),
(3307, 33, 'KABUPATEN WONOSOBO', NULL, NULL),
(3308, 33, 'KABUPATEN MAGELANG', NULL, NULL),
(3309, 33, 'KABUPATEN BOYOLALI', NULL, NULL),
(3310, 33, 'KABUPATEN KLATEN', NULL, NULL),
(3311, 33, 'KABUPATEN SUKOHARJO', NULL, NULL),
(3312, 33, 'KABUPATEN WONOGIRI', NULL, NULL),
(3313, 33, 'KABUPATEN KARANGANYAR', NULL, NULL),
(3314, 33, 'KABUPATEN SRAGEN', NULL, NULL),
(3315, 33, 'KABUPATEN GROBOGAN', NULL, NULL),
(3316, 33, 'KABUPATEN BLORA', NULL, NULL),
(3317, 33, 'KABUPATEN REMBANG', NULL, NULL),
(3318, 33, 'KABUPATEN PATI', NULL, NULL),
(3319, 33, 'KABUPATEN KUDUS', NULL, NULL),
(3320, 33, 'KABUPATEN JEPARA', NULL, NULL),
(3321, 33, 'KABUPATEN DEMAK', NULL, NULL),
(3322, 33, 'KABUPATEN SEMARANG', NULL, NULL),
(3323, 33, 'KABUPATEN TEMANGGUNG', NULL, NULL),
(3324, 33, 'KABUPATEN KENDAL', NULL, NULL),
(3325, 33, 'KABUPATEN BATANG', NULL, NULL),
(3326, 33, 'KABUPATEN PEKALONGAN', NULL, NULL),
(3327, 33, 'KABUPATEN PEMALANG', NULL, NULL),
(3328, 33, 'KABUPATEN TEGAL', NULL, NULL),
(3329, 33, 'KABUPATEN BREBES', NULL, NULL),
(3371, 33, 'KOTA MAGELANG', NULL, NULL),
(3372, 33, 'KOTA SURAKARTA', NULL, NULL),
(3373, 33, 'KOTA SALATIGA', NULL, NULL),
(3374, 33, 'KOTA SEMARANG', NULL, NULL),
(3375, 33, 'KOTA PEKALONGAN', NULL, NULL),
(3376, 33, 'KOTA TEGAL', NULL, NULL),
(3401, 34, 'KABUPATEN KULON PROGO', NULL, NULL),
(3402, 34, 'KABUPATEN BANTUL', NULL, NULL),
(3403, 34, 'KABUPATEN GUNUNG KIDUL', NULL, NULL),
(3404, 34, 'KABUPATEN SLEMAN', NULL, NULL),
(3471, 34, 'KOTA YOGYAKARTA', NULL, NULL),
(3501, 35, 'KABUPATEN PACITAN', NULL, NULL),
(3502, 35, 'KABUPATEN PONOROGO', NULL, NULL),
(3503, 35, 'KABUPATEN TRENGGALEK', NULL, NULL),
(3504, 35, 'KABUPATEN TULUNGAGUNG', NULL, NULL),
(3505, 35, 'KABUPATEN BLITAR', NULL, NULL),
(3506, 35, 'KABUPATEN KEDIRI', NULL, NULL),
(3507, 35, 'KABUPATEN MALANG', NULL, NULL),
(3508, 35, 'KABUPATEN LUMAJANG', NULL, NULL),
(3509, 35, 'KABUPATEN JEMBER', NULL, NULL),
(3510, 35, 'KABUPATEN BANYUWANGI', NULL, NULL),
(3511, 35, 'KABUPATEN BONDOWOSO', NULL, NULL),
(3512, 35, 'KABUPATEN SITUBONDO', NULL, NULL),
(3513, 35, 'KABUPATEN PROBOLINGGO', NULL, NULL),
(3514, 35, 'KABUPATEN PASURUAN', NULL, NULL),
(3515, 35, 'KABUPATEN SIDOARJO', NULL, NULL),
(3516, 35, 'KABUPATEN MOJOKERTO', NULL, NULL),
(3517, 35, 'KABUPATEN JOMBANG', NULL, NULL),
(3518, 35, 'KABUPATEN NGANJUK', NULL, NULL),
(3519, 35, 'KABUPATEN MADIUN', NULL, NULL),
(3520, 35, 'KABUPATEN MAGETAN', NULL, NULL),
(3521, 35, 'KABUPATEN NGAWI', NULL, NULL),
(3522, 35, 'KABUPATEN BOJONEGORO', NULL, NULL),
(3523, 35, 'KABUPATEN TUBAN', NULL, NULL),
(3524, 35, 'KABUPATEN LAMONGAN', NULL, NULL),
(3525, 35, 'KABUPATEN GRESIK', NULL, NULL),
(3526, 35, 'KABUPATEN BANGKALAN', NULL, NULL),
(3527, 35, 'KABUPATEN SAMPANG', NULL, NULL),
(3528, 35, 'KABUPATEN PAMEKASAN', NULL, NULL),
(3529, 35, 'KABUPATEN SUMENEP', NULL, NULL),
(3571, 35, 'KOTA KEDIRI', NULL, NULL),
(3572, 35, 'KOTA BLITAR', NULL, NULL),
(3573, 35, 'KOTA MALANG', NULL, NULL),
(3574, 35, 'KOTA PROBOLINGGO', NULL, NULL),
(3575, 35, 'KOTA PASURUAN', NULL, NULL),
(3576, 35, 'KOTA MOJOKERTO', NULL, NULL),
(3577, 35, 'KOTA MADIUN', NULL, NULL),
(3578, 35, 'KOTA SURABAYA', NULL, NULL),
(3579, 35, 'KOTA BATU', NULL, NULL),
(3601, 36, 'KABUPATEN PANDEGLANG', NULL, NULL),
(3602, 36, 'KABUPATEN LEBAK', NULL, NULL),
(3603, 36, 'KABUPATEN TANGERANG', NULL, NULL),
(3604, 36, 'KABUPATEN SERANG', NULL, NULL),
(3671, 36, 'KOTA TANGERANG', NULL, NULL),
(3672, 36, 'KOTA CILEGON', NULL, NULL),
(3673, 36, 'KOTA SERANG', NULL, NULL),
(3674, 36, 'KOTA TANGERANG SELATAN', NULL, NULL),
(5101, 51, 'KABUPATEN JEMBRANA', NULL, NULL),
(5102, 51, 'KABUPATEN TABANAN', NULL, NULL),
(5103, 51, 'KABUPATEN BADUNG', NULL, NULL),
(5104, 51, 'KABUPATEN GIANYAR', NULL, NULL),
(5105, 51, 'KABUPATEN KLUNGKUNG', NULL, NULL),
(5106, 51, 'KABUPATEN BANGLI', NULL, NULL),
(5107, 51, 'KABUPATEN KARANG ASEM', NULL, NULL),
(5108, 51, 'KABUPATEN BULELENG', NULL, NULL),
(5171, 51, 'KOTA DENPASAR', NULL, NULL),
(5201, 52, 'KABUPATEN LOMBOK BARAT', NULL, NULL),
(5202, 52, 'KABUPATEN LOMBOK TENGAH', NULL, NULL),
(5203, 52, 'KABUPATEN LOMBOK TIMUR', NULL, NULL),
(5204, 52, 'KABUPATEN SUMBAWA', NULL, NULL),
(5205, 52, 'KABUPATEN DOMPU', NULL, NULL),
(5206, 52, 'KABUPATEN BIMA', NULL, NULL),
(5207, 52, 'KABUPATEN SUMBAWA BARAT', NULL, NULL),
(5208, 52, 'KABUPATEN LOMBOK UTARA', NULL, NULL),
(5271, 52, 'KOTA MATARAM', NULL, NULL),
(5272, 52, 'KOTA BIMA', NULL, NULL),
(5301, 53, 'KABUPATEN SUMBA BARAT', NULL, NULL),
(5302, 53, 'KABUPATEN SUMBA TIMUR', NULL, NULL),
(5303, 53, 'KABUPATEN KUPANG', NULL, NULL),
(5304, 53, 'KABUPATEN TIMOR TENGAH SELATAN', NULL, NULL),
(5305, 53, 'KABUPATEN TIMOR TENGAH UTARA', NULL, NULL),
(5306, 53, 'KABUPATEN BELU', NULL, NULL),
(5307, 53, 'KABUPATEN ALOR', NULL, NULL),
(5308, 53, 'KABUPATEN LEMBATA', NULL, NULL),
(5309, 53, 'KABUPATEN FLORES TIMUR', NULL, NULL),
(5310, 53, 'KABUPATEN SIKKA', NULL, NULL),
(5311, 53, 'KABUPATEN ENDE', NULL, NULL),
(5312, 53, 'KABUPATEN NGADA', NULL, NULL),
(5313, 53, 'KABUPATEN MANGGARAI', NULL, NULL),
(5314, 53, 'KABUPATEN ROTE NDAO', NULL, NULL),
(5315, 53, 'KABUPATEN MANGGARAI BARAT', NULL, NULL),
(5316, 53, 'KABUPATEN SUMBA TENGAH', NULL, NULL),
(5317, 53, 'KABUPATEN SUMBA BARAT DAYA', NULL, NULL),
(5318, 53, 'KABUPATEN NAGEKEO', NULL, NULL),
(5319, 53, 'KABUPATEN MANGGARAI TIMUR', NULL, NULL),
(5320, 53, 'KABUPATEN SABU RAIJUA', NULL, NULL),
(5321, 53, 'KABUPATEN MALAKA', NULL, NULL),
(5371, 53, 'KOTA KUPANG', NULL, NULL),
(6101, 61, 'KABUPATEN SAMBAS', NULL, NULL),
(6102, 61, 'KABUPATEN BENGKAYANG', NULL, NULL),
(6103, 61, 'KABUPATEN LANDAK', NULL, NULL),
(6104, 61, 'KABUPATEN MEMPAWAH', NULL, NULL),
(6105, 61, 'KABUPATEN SANGGAU', NULL, NULL),
(6106, 61, 'KABUPATEN KETAPANG', NULL, NULL),
(6107, 61, 'KABUPATEN SINTANG', NULL, NULL),
(6108, 61, 'KABUPATEN KAPUAS HULU', NULL, NULL),
(6109, 61, 'KABUPATEN SEKADAU', NULL, NULL),
(6110, 61, 'KABUPATEN MELAWI', NULL, NULL),
(6111, 61, 'KABUPATEN KAYONG UTARA', NULL, NULL),
(6112, 61, 'KABUPATEN KUBU RAYA', NULL, NULL),
(6171, 61, 'KOTA PONTIANAK', NULL, NULL),
(6172, 61, 'KOTA SINGKAWANG', NULL, NULL),
(6201, 62, 'KABUPATEN KOTAWARINGIN BARAT', NULL, NULL),
(6202, 62, 'KABUPATEN KOTAWARINGIN TIMUR', NULL, NULL),
(6203, 62, 'KABUPATEN KAPUAS', NULL, NULL),
(6204, 62, 'KABUPATEN BARITO SELATAN', NULL, NULL),
(6205, 62, 'KABUPATEN BARITO UTARA', NULL, NULL),
(6206, 62, 'KABUPATEN SUKAMARA', NULL, NULL),
(6207, 62, 'KABUPATEN LAMANDAU', NULL, NULL),
(6208, 62, 'KABUPATEN SERUYAN', NULL, NULL),
(6209, 62, 'KABUPATEN KATINGAN', NULL, NULL),
(6210, 62, 'KABUPATEN PULANG PISAU', NULL, NULL),
(6211, 62, 'KABUPATEN GUNUNG MAS', NULL, NULL),
(6212, 62, 'KABUPATEN BARITO TIMUR', NULL, NULL),
(6213, 62, 'KABUPATEN MURUNG RAYA', NULL, NULL),
(6271, 62, 'KOTA PALANGKA RAYA', NULL, NULL),
(6301, 63, 'KABUPATEN TANAH LAUT', NULL, NULL),
(6302, 63, 'KABUPATEN KOTA BARU', NULL, NULL),
(6303, 63, 'KABUPATEN BANJAR', NULL, NULL),
(6304, 63, 'KABUPATEN BARITO KUALA', NULL, NULL),
(6305, 63, 'KABUPATEN TAPIN', NULL, NULL),
(6306, 63, 'KABUPATEN HULU SUNGAI SELATAN', NULL, NULL),
(6307, 63, 'KABUPATEN HULU SUNGAI TENGAH', NULL, NULL),
(6308, 63, 'KABUPATEN HULU SUNGAI UTARA', NULL, NULL),
(6309, 63, 'KABUPATEN TABALONG', NULL, NULL),
(6310, 63, 'KABUPATEN TANAH BUMBU', NULL, NULL),
(6311, 63, 'KABUPATEN BALANGAN', NULL, NULL),
(6371, 63, 'KOTA BANJARMASIN', NULL, NULL),
(6372, 63, 'KOTA BANJAR BARU', NULL, NULL),
(6401, 64, 'KABUPATEN PASER', NULL, NULL),
(6402, 64, 'KABUPATEN KUTAI BARAT', NULL, NULL),
(6403, 64, 'KABUPATEN KUTAI KARTANEGARA', NULL, NULL),
(6404, 64, 'KABUPATEN KUTAI TIMUR', NULL, NULL),
(6405, 64, 'KABUPATEN BERAU', NULL, NULL),
(6409, 64, 'KABUPATEN PENAJAM PASER UTARA', NULL, NULL),
(6411, 64, 'KABUPATEN MAHAKAM HULU', NULL, NULL),
(6471, 64, 'KOTA BALIKPAPAN', NULL, NULL),
(6472, 64, 'KOTA SAMARINDA', NULL, NULL),
(6474, 64, 'KOTA BONTANG', NULL, NULL),
(6501, 65, 'KABUPATEN MALINAU', NULL, NULL),
(6502, 65, 'KABUPATEN BULUNGAN', NULL, NULL),
(6503, 65, 'KABUPATEN TANA TIDUNG', NULL, NULL),
(6504, 65, 'KABUPATEN NUNUKAN', NULL, NULL),
(6571, 65, 'KOTA TARAKAN', NULL, NULL),
(7101, 71, 'KABUPATEN BOLAANG MONGONDOW', NULL, NULL),
(7102, 71, 'KABUPATEN MINAHASA', NULL, NULL),
(7103, 71, 'KABUPATEN KEPULAUAN SANGIHE', NULL, NULL),
(7104, 71, 'KABUPATEN KEPULAUAN TALAUD', NULL, NULL),
(7105, 71, 'KABUPATEN MINAHASA SELATAN', NULL, NULL),
(7106, 71, 'KABUPATEN MINAHASA UTARA', NULL, NULL),
(7107, 71, 'KABUPATEN BOLAANG MONGONDOW UTARA', NULL, NULL),
(7108, 71, 'KABUPATEN SIAU TAGULANDANG BIARO', NULL, NULL),
(7109, 71, 'KABUPATEN MINAHASA TENGGARA', NULL, NULL),
(7110, 71, 'KABUPATEN BOLAANG MONGONDOW SELATAN', NULL, NULL),
(7111, 71, 'KABUPATEN BOLAANG MONGONDOW TIMUR', NULL, NULL),
(7171, 71, 'KOTA MANADO', NULL, NULL),
(7172, 71, 'KOTA BITUNG', NULL, NULL),
(7173, 71, 'KOTA TOMOHON', NULL, NULL),
(7174, 71, 'KOTA KOTAMOBAGU', NULL, NULL),
(7201, 72, 'KABUPATEN BANGGAI KEPULAUAN', NULL, NULL),
(7202, 72, 'KABUPATEN BANGGAI', NULL, NULL),
(7203, 72, 'KABUPATEN MOROWALI', NULL, NULL),
(7204, 72, 'KABUPATEN POSO', NULL, NULL),
(7205, 72, 'KABUPATEN DONGGALA', NULL, NULL),
(7206, 72, 'KABUPATEN TOLI-TOLI', NULL, NULL),
(7207, 72, 'KABUPATEN BUOL', NULL, NULL),
(7208, 72, 'KABUPATEN PARIGI MOUTONG', NULL, NULL),
(7209, 72, 'KABUPATEN TOJO UNA-UNA', NULL, NULL),
(7210, 72, 'KABUPATEN SIGI', NULL, NULL),
(7211, 72, 'KABUPATEN BANGGAI LAUT', NULL, NULL),
(7212, 72, 'KABUPATEN MOROWALI UTARA', NULL, NULL),
(7271, 72, 'KOTA PALU', NULL, NULL),
(7301, 73, 'KABUPATEN KEPULAUAN SELAYAR', NULL, NULL),
(7302, 73, 'KABUPATEN BULUKUMBA', NULL, NULL),
(7303, 73, 'KABUPATEN BANTAENG', NULL, NULL),
(7304, 73, 'KABUPATEN JENEPONTO', NULL, NULL),
(7305, 73, 'KABUPATEN TAKALAR', NULL, NULL),
(7306, 73, 'KABUPATEN GOWA', NULL, NULL),
(7307, 73, 'KABUPATEN SINJAI', NULL, NULL),
(7308, 73, 'KABUPATEN MAROS', NULL, NULL),
(7309, 73, 'KABUPATEN PANGKAJENE DAN KEPULAUAN', NULL, NULL),
(7310, 73, 'KABUPATEN BARRU', NULL, NULL),
(7311, 73, 'KABUPATEN BONE', NULL, NULL),
(7312, 73, 'KABUPATEN SOPPENG', NULL, NULL),
(7313, 73, 'KABUPATEN WAJO', NULL, NULL),
(7314, 73, 'KABUPATEN SIDENRENG RAPPANG', NULL, NULL),
(7315, 73, 'KABUPATEN PINRANG', NULL, NULL),
(7316, 73, 'KABUPATEN ENREKANG', NULL, NULL),
(7317, 73, 'KABUPATEN LUWU', NULL, NULL),
(7318, 73, 'KABUPATEN TANA TORAJA', NULL, NULL),
(7322, 73, 'KABUPATEN LUWU UTARA', NULL, NULL),
(7325, 73, 'KABUPATEN LUWU TIMUR', NULL, NULL),
(7326, 73, 'KABUPATEN TORAJA UTARA', NULL, NULL),
(7371, 73, 'KOTA MAKASSAR', NULL, NULL),
(7372, 73, 'KOTA PAREPARE', NULL, NULL),
(7373, 73, 'KOTA PALOPO', NULL, NULL),
(7401, 74, 'KABUPATEN BUTON', NULL, NULL),
(7402, 74, 'KABUPATEN MUNA', NULL, NULL),
(7403, 74, 'KABUPATEN KONAWE', NULL, NULL),
(7404, 74, 'KABUPATEN KOLAKA', NULL, NULL),
(7405, 74, 'KABUPATEN KONAWE SELATAN', NULL, NULL),
(7406, 74, 'KABUPATEN BOMBANA', NULL, NULL),
(7407, 74, 'KABUPATEN WAKATOBI', NULL, NULL),
(7408, 74, 'KABUPATEN KOLAKA UTARA', NULL, NULL),
(7409, 74, 'KABUPATEN BUTON UTARA', NULL, NULL),
(7410, 74, 'KABUPATEN KONAWE UTARA', NULL, NULL),
(7411, 74, 'KABUPATEN KOLAKA TIMUR', NULL, NULL),
(7412, 74, 'KABUPATEN KONAWE KEPULAUAN', NULL, NULL),
(7413, 74, 'KABUPATEN MUNA BARAT', NULL, NULL),
(7414, 74, 'KABUPATEN BUTON TENGAH', NULL, NULL),
(7415, 74, 'KABUPATEN BUTON SELATAN', NULL, NULL),
(7471, 74, 'KOTA KENDARI', NULL, NULL),
(7472, 74, 'KOTA BAUBAU', NULL, NULL),
(7501, 75, 'KABUPATEN BOALEMO', NULL, NULL),
(7502, 75, 'KABUPATEN GORONTALO', NULL, NULL),
(7503, 75, 'KABUPATEN POHUWATO', NULL, NULL),
(7504, 75, 'KABUPATEN BONE BOLANGO', NULL, NULL),
(7505, 75, 'KABUPATEN GORONTALO UTARA', NULL, NULL),
(7571, 75, 'KOTA GORONTALO', NULL, NULL),
(7601, 76, 'KABUPATEN MAJENE', NULL, NULL),
(7602, 76, 'KABUPATEN POLEWALI MANDAR', NULL, NULL),
(7603, 76, 'KABUPATEN MAMASA', NULL, NULL),
(7604, 76, 'KABUPATEN MAMUJU', NULL, NULL),
(7605, 76, 'KABUPATEN MAMUJU UTARA', NULL, NULL),
(7606, 76, 'KABUPATEN MAMUJU TENGAH', NULL, NULL),
(8101, 81, 'KABUPATEN MALUKU TENGGARA BARAT', NULL, NULL),
(8102, 81, 'KABUPATEN MALUKU TENGGARA', NULL, NULL),
(8103, 81, 'KABUPATEN MALUKU TENGAH', NULL, NULL),
(8104, 81, 'KABUPATEN BURU', NULL, NULL),
(8105, 81, 'KABUPATEN KEPULAUAN ARU', NULL, NULL),
(8106, 81, 'KABUPATEN SERAM BAGIAN BARAT', NULL, NULL),
(8107, 81, 'KABUPATEN SERAM BAGIAN TIMUR', NULL, NULL),
(8108, 81, 'KABUPATEN MALUKU BARAT DAYA', NULL, NULL),
(8109, 81, 'KABUPATEN BURU SELATAN', NULL, NULL),
(8171, 81, 'KOTA AMBON', NULL, NULL),
(8172, 81, 'KOTA TUAL', NULL, NULL),
(8201, 82, 'KABUPATEN HALMAHERA BARAT', NULL, NULL),
(8202, 82, 'KABUPATEN HALMAHERA TENGAH', NULL, NULL),
(8203, 82, 'KABUPATEN KEPULAUAN SULA', NULL, NULL),
(8204, 82, 'KABUPATEN HALMAHERA SELATAN', NULL, NULL),
(8205, 82, 'KABUPATEN HALMAHERA UTARA', NULL, NULL),
(8206, 82, 'KABUPATEN HALMAHERA TIMUR', NULL, NULL),
(8207, 82, 'KABUPATEN PULAU MOROTAI', NULL, NULL),
(8208, 82, 'KABUPATEN PULAU TALIABU', NULL, NULL),
(8271, 82, 'KOTA TERNATE', NULL, NULL),
(8272, 82, 'KOTA TIDORE KEPULAUAN', NULL, NULL),
(9101, 91, 'KABUPATEN FAKFAK', NULL, NULL),
(9102, 91, 'KABUPATEN KAIMANA', NULL, NULL),
(9103, 91, 'KABUPATEN TELUK WONDAMA', NULL, NULL),
(9104, 91, 'KABUPATEN TELUK BINTUNI', NULL, NULL),
(9105, 91, 'KABUPATEN MANOKWARI', NULL, NULL),
(9106, 91, 'KABUPATEN SORONG SELATAN', NULL, NULL),
(9107, 91, 'KABUPATEN SORONG', NULL, NULL),
(9108, 91, 'KABUPATEN RAJA AMPAT', NULL, NULL),
(9109, 91, 'KABUPATEN TAMBRAUW', NULL, NULL),
(9110, 91, 'KABUPATEN MAYBRAT', NULL, NULL),
(9111, 91, 'KABUPATEN MANOKWARI SELATAN', NULL, NULL),
(9112, 91, 'KABUPATEN PEGUNUNGAN ARFAK', NULL, NULL),
(9171, 91, 'KOTA SORONG', NULL, NULL),
(9401, 94, 'KABUPATEN MERAUKE', NULL, NULL),
(9402, 94, 'KABUPATEN JAYAWIJAYA', NULL, NULL),
(9403, 94, 'KABUPATEN JAYAPURA', NULL, NULL),
(9404, 94, 'KABUPATEN NABIRE', NULL, NULL),
(9408, 94, 'KABUPATEN KEPULAUAN YAPEN', NULL, NULL),
(9409, 94, 'KABUPATEN BIAK NUMFOR', NULL, NULL),
(9410, 94, 'KABUPATEN PANIAI', NULL, NULL),
(9411, 94, 'KABUPATEN PUNCAK JAYA', NULL, NULL),
(9412, 94, 'KABUPATEN MIMIKA', NULL, NULL),
(9413, 94, 'KABUPATEN BOVEN DIGOEL', NULL, NULL),
(9414, 94, 'KABUPATEN MAPPI', NULL, NULL),
(9415, 94, 'KABUPATEN ASMAT', NULL, NULL),
(9416, 94, 'KABUPATEN YAHUKIMO', NULL, NULL),
(9417, 94, 'KABUPATEN PEGUNUNGAN BINTANG', NULL, NULL),
(9418, 94, 'KABUPATEN TOLIKARA', NULL, NULL),
(9419, 94, 'KABUPATEN SARMI', NULL, NULL),
(9420, 94, 'KABUPATEN KEEROM', NULL, NULL),
(9426, 94, 'KABUPATEN WAROPEN', NULL, NULL),
(9427, 94, 'KABUPATEN SUPIORI', NULL, NULL),
(9428, 94, 'KABUPATEN MAMBERAMO RAYA', NULL, NULL),
(9429, 94, 'KABUPATEN NDUGA', NULL, NULL),
(9430, 94, 'KABUPATEN LANNY JAYA', NULL, NULL),
(9431, 94, 'KABUPATEN MAMBERAMO TENGAH', NULL, NULL),
(9432, 94, 'KABUPATEN YALIMO', NULL, NULL),
(9433, 94, 'KABUPATEN PUNCAK', NULL, NULL),
(9434, 94, 'KABUPATEN DOGIYAI', NULL, NULL),
(9435, 94, 'KABUPATEN INTAN JAYA', NULL, NULL),
(9436, 94, 'KABUPATEN DEIYAI', NULL, NULL),
(9471, 94, 'KOTA JAYAPURA', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_provinsi`
--

CREATE TABLE `m_provinsi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_provinsi`
--

INSERT INTO `m_provinsi` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(11, 'ACEH', NULL, NULL),
(12, 'SUMATERA UTARA', NULL, NULL),
(13, 'SUMATERA BARAT', NULL, NULL),
(14, 'RIAU', NULL, NULL),
(15, 'JAMBI', NULL, NULL),
(16, 'SUMATERA SELATAN', NULL, NULL),
(17, 'BENGKULU', NULL, NULL),
(18, 'LAMPUNG', NULL, NULL),
(19, 'KEPULAUAN BANGKA BELITUNG', NULL, NULL),
(21, 'KEPULAUAN RIAU', NULL, NULL),
(31, 'DKI JAKARTA', NULL, NULL),
(32, 'JAWA BARAT', NULL, NULL),
(33, 'JAWA TENGAH', NULL, NULL),
(34, 'DI YOGYAKARTA', NULL, NULL),
(35, 'JAWA TIMUR', NULL, NULL),
(36, 'BANTEN', NULL, NULL),
(51, 'BALI', NULL, NULL),
(52, 'NUSA TENGGARA BARAT', NULL, NULL),
(53, 'NUSA TENGGARA TIMUR', NULL, NULL),
(61, 'KALIMANTAN BARAT', NULL, NULL),
(62, 'KALIMANTAN TENGAH', NULL, NULL),
(63, 'KALIMANTAN SELATAN', NULL, NULL),
(64, 'KALIMANTAN TIMUR', NULL, NULL),
(65, 'KALIMANTAN UTARA', NULL, NULL),
(71, 'SULAWESI UTARA', NULL, NULL),
(72, 'SULAWESI TENGAH', NULL, NULL),
(73, 'SULAWESI SELATAN', NULL, NULL),
(74, 'SULAWESI TENGGARA', NULL, NULL),
(75, 'GORONTALO', NULL, NULL),
(76, 'SULAWESI BARAT', NULL, NULL),
(81, 'MALUKU', NULL, NULL),
(82, 'MALUKU UTARA', NULL, NULL),
(91, 'PAPUA BARAT', NULL, NULL),
(94, 'PAPUA', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config_kuisioner`
--
ALTER TABLE `config_kuisioner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jawaban_kuisioner`
--
ALTER TABLE `jawaban_kuisioner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manajemen_berita`
--
ALTER TABLE `manajemen_berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manajemen_investasi`
--
ALTER TABLE `manajemen_investasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manajemen_kategori`
--
ALTER TABLE `manajemen_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manajemen_kuisioner`
--
ALTER TABLE `manajemen_kuisioner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manajemen_kuisioner_jawaban`
--
ALTER TABLE `manajemen_kuisioner_jawaban`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manajemen_peraturan`
--
ALTER TABLE `manajemen_peraturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manajemen_users`
--
ALTER TABLE `manajemen_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `manajemen_users_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_kabupaten_kota`
--
ALTER TABLE `m_kabupaten_kota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_kabupaten_kota_m_provinsi_foreign` (`m_provinsi`);

--
-- Indexes for table `m_provinsi`
--
ALTER TABLE `m_provinsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `config_kuisioner`
--
ALTER TABLE `config_kuisioner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jawaban_kuisioner`
--
ALTER TABLE `jawaban_kuisioner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manajemen_berita`
--
ALTER TABLE `manajemen_berita`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `manajemen_investasi`
--
ALTER TABLE `manajemen_investasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manajemen_kategori`
--
ALTER TABLE `manajemen_kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `manajemen_kuisioner`
--
ALTER TABLE `manajemen_kuisioner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `manajemen_kuisioner_jawaban`
--
ALTER TABLE `manajemen_kuisioner_jawaban`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `manajemen_peraturan`
--
ALTER TABLE `manajemen_peraturan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manajemen_users`
--
ALTER TABLE `manajemen_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `m_kabupaten_kota`
--
ALTER TABLE `m_kabupaten_kota`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9472;

--
-- AUTO_INCREMENT for table `m_provinsi`
--
ALTER TABLE `m_provinsi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_kabupaten_kota`
--
ALTER TABLE `m_kabupaten_kota`
  ADD CONSTRAINT `m_kabupaten_kota_m_provinsi_foreign` FOREIGN KEY (`m_provinsi`) REFERENCES `m_provinsi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
