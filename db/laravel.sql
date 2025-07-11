-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jul 2025 pada 11.57
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_code` varchar(255) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `customer_code`, `birth_date`, `gender`, `emergency_contact`, `created_at`, `updated_at`) VALUES
(1, 3, 'CUSTUiD5', '2000-06-24', 'male', NULL, '2025-06-24 03:11:56', '2025-06-24 03:11:56'),
(2, 12, 'CUS002', NULL, NULL, NULL, '2025-06-25 03:42:48', '2025-06-25 03:42:48'),
(3, 15, 'CUS003', NULL, NULL, NULL, '2025-06-26 03:20:04', '2025-06-26 03:20:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_06_22_080405_create_permission_tables', 1),
(6, '2025_06_22_080500_add_extra_fields_to_users_table', 1),
(7, '2025_06_22_080510_create_customers_table', 1),
(8, '2025_06_22_080520_create_technicians_table', 1),
(9, '2025_06_22_080530_create_vehicles_table', 1),
(10, '2025_06_22_080540_create_service_categories_table', 1),
(11, '2025_06_22_080550_create_service_bookings_table', 1),
(12, '2025_06_22_080560_create_spare_parts_table', 1),
(13, '2025_06_22_080570_create_service_details_table', 1),
(14, '2025_06_22_080580_create_service_progress_table', 1),
(15, '2025_06_22_080590_create_payments_table', 1),
(16, '2025_06_22_080600_create_reviews_table', 1),
(17, '2024_06_24_000002_create_vehicle_types_table', 2),
(18, '2024_06_24_000003_add_vehicle_type_id_to_vehicles_table', 2),
(19, '2025_06_25_123000_add_photo_path_to_service_progress_table', 3),
(20, '2025_06_25_123100_add_updated_at_to_service_progress_table', 4),
(21, '2025_06_25_000000_create_settings_table', 5),
(22, '2025_06_26_194900_add_custom_request_to_service_bookings_table', 6),
(23, '2025_06_26_201300_add_estimated_duration_to_service_bookings_table', 7),
(24, '2025_06_26_215500_add_proof_path_to_payments_table', 8),
(25, '2025_06_28_134500_add_awaiting_review_status_to_service_bookings', 9),
(26, '2025_07_11_081500_create_qr_scans_table', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` enum('cash','transfer','credit_card','ewallet') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_date` date NOT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `proof_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed','failed') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `payment_method`, `amount`, `payment_date`, `reference_number`, `proof_path`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'cash', '350000.00', '2025-06-25', NULL, NULL, 'confirmed', NULL, '2025-06-24 23:07:10', '2025-06-24 23:14:50'),
(2, 3, 'transfer', '500000.00', '2025-06-26', NULL, 'payments/hxwY6rXJexAsjMG8jJDQojdM9NE2BrVPMtsWlKcr.jpg', 'confirmed', NULL, '2025-06-26 07:22:06', '2025-06-26 07:38:01'),
(3, 5, 'cash', '440000.00', '2025-06-28', NULL, NULL, 'confirmed', 'Saya telah membayar sebesar 440rb', '2025-06-28 02:16:57', '2025-06-28 02:17:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `qr_scans`
--

CREATE TABLE `qr_scans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `token` char(36) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(512) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `technician_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `booking_id`, `customer_id`, `technician_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 5, 'Mantap sekali untuk masnya..', '2025-06-25 05:59:48', '2025-06-25 05:59:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-06-24 03:11:55', '2025-06-24 03:11:55'),
(2, 'teknisi', 'web', '2025-06-24 03:11:55', '2025-06-24 03:11:55'),
(3, 'pelanggan', 'web', '2025-06-24 03:11:55', '2025-06-24 03:11:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_bookings`
--

CREATE TABLE `service_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `service_category_id` bigint(20) UNSIGNED NOT NULL,
  `custom_request` varchar(255) DEFAULT NULL,
  `technician_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_date` date NOT NULL,
  `estimated_duration` int(11) DEFAULT NULL,
  `preferred_time` time DEFAULT NULL,
  `status` enum('pending','in_progress','awaiting_review','completed') NOT NULL DEFAULT 'pending',
  `complaint_description` text DEFAULT NULL,
  `estimated_cost` decimal(12,2) DEFAULT NULL,
  `actual_cost` decimal(12,2) DEFAULT NULL,
  `payment_status` enum('unpaid','partial','paid') NOT NULL DEFAULT 'unpaid',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `service_bookings`
--

INSERT INTO `service_bookings` (`id`, `booking_code`, `customer_id`, `vehicle_id`, `service_category_id`, `custom_request`, `technician_id`, `booking_date`, `estimated_duration`, `preferred_time`, `status`, `complaint_description`, `estimated_cost`, `actual_cost`, `payment_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'TCIPLFHS', 1, 1, 1, NULL, 1, '2025-06-26', NULL, NULL, 'completed', NULL, '350000.00', NULL, 'paid', 'Ganti Oli', '2025-06-24 21:58:27', '2025-06-24 23:14:50'),
(3, 'XB2UBWWC', 2, 2, 3, NULL, 2, '2025-06-26', 240, NULL, 'completed', NULL, '500000.00', NULL, 'paid', NULL, '2025-06-26 06:40:49', '2025-06-26 07:38:01'),
(4, 'ZBEA0EAW', 1, 1, 2, NULL, 1, '2025-06-27', 180, NULL, 'completed', NULL, '60000.00', NULL, 'unpaid', 'Service bulanan', '2025-06-26 21:08:42', '2025-06-26 23:47:43'),
(5, 'GR70PD4G', 2, 2, 1, NULL, 1, '2025-06-28', 45, NULL, 'completed', NULL, '440000.00', NULL, 'paid', 'Ganti kampas rem depan', '2025-06-27 23:00:59', '2025-06-28 02:17:34'),
(6, 'W6HO54Y1', 2, 2, 8, 'Ganti Ban', 1, '2025-06-28', 60, NULL, 'completed', NULL, '600000.00', NULL, 'unpaid', 'Ganti Ban Selesai', '2025-06-28 06:02:40', '2025-06-28 23:11:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `estimated_duration` int(10) UNSIGNED DEFAULT NULL,
  `base_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `description`, `estimated_duration`, `base_price`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Ganti Oli & Filter', 'Penggantian oli mesin dan filter oli', 45, '200000.00', 1, '2025-06-24 03:11:56', '2025-06-26 05:50:27'),
(2, 'Service Berkala 10.000 km', 'Pemeriksaan dan penggantian komponen sesuai jadwal', 180, '500000.00', 1, '2025-06-24 03:11:56', '2025-06-26 05:50:27'),
(3, 'Tune Up', 'Penyetelan performa mesin untuk efisiensi optimal', 240, '600000.00', 1, '2025-06-24 03:11:56', '2025-06-26 05:50:27'),
(4, 'Ganti Kampas Rem', 'Penggantian brake pad depan atau belakang', 120, '400000.00', 1, '2025-06-24 03:11:56', '2025-06-26 05:50:27'),
(5, 'Spooring & Balancing', 'Penyetelan geometri roda dan balancing ban', 90, '150000.00', 1, '2025-06-24 03:11:56', '2025-06-26 05:50:27'),
(6, 'Servis AC Mobil', 'Pemeriksaan dan perbaikan sistem AC', 180, '800000.00', 1, '2025-06-24 03:11:56', '2025-06-26 05:50:27'),
(7, 'Overhaul Mesin', 'Bongkar total dan rebuild mesin', 5760, '8000000.00', 1, '2025-06-24 03:11:56', '2025-06-26 05:50:27'),
(8, 'Lain-lain (Custom)', 'Permintaan servis di luar daftar', 60, '0.00', 1, '2025-06-26 05:50:27', '2025-06-26 05:50:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_details`
--

CREATE TABLE `service_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `spare_part_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `type` enum('labor','part') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `service_details`
--

INSERT INTO `service_details` (`id`, `booking_id`, `spare_part_id`, `description`, `quantity`, `unit_price`, `total_price`, `type`, `created_at`, `updated_at`) VALUES
(3, 4, 20, 'Oli Gardan 80W-90 1L', 1, '60000.00', '60000.00', 'part', '2025-06-26 23:47:43', '2025-06-26 23:47:43'),
(11, 5, NULL, 'Ganti Oli & Filter', 1, '200000.00', '200000.00', 'labor', '2025-06-28 02:02:20', '2025-06-28 02:02:20'),
(12, 5, 7, 'Kampas Rem Depan', 1, '220000.00', '220000.00', 'part', '2025-06-28 02:02:20', '2025-06-28 02:02:20'),
(13, 5, NULL, 'Jasa Ganti Kampas Rem', 1, '20000.00', '20000.00', 'labor', '2025-06-28 02:02:20', '2025-06-28 02:02:20'),
(14, 6, NULL, 'Lain-lain (Custom)', 1, '600000.00', '600000.00', 'labor', '2025-06-28 23:11:20', '2025-06-28 23:11:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_progress`
--

CREATE TABLE `service_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `technician_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `progress_percentage` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `photos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`photos`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `service_progress`
--

INSERT INTO `service_progress` (`id`, `booking_id`, `technician_id`, `status`, `description`, `photo_path`, `progress_percentage`, `photos`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'in_progress', 'pembukaan kap', 'progress/dser2IHcooqreMtolkMWPN5QRs59YOM0OpCxGAbI.webp', 0, NULL, '2025-06-24 22:36:56', '2025-06-24 22:36:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'fonnte_token', 'q3yqhiRwa2UXzpwGydZ2', '2025-06-25 07:26:46', '2025-06-25 07:26:46'),
(2, 'fonnte_url', 'https://api.fonnte.com/send', '2025-06-25 07:26:46', '2025-06-25 07:26:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spare_parts`
--

CREATE TABLE `spare_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `part_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `minimum_stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `supplier_info` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `spare_parts`
--

INSERT INTO `spare_parts` (`id`, `part_code`, `name`, `brand`, `description`, `category`, `price`, `stock_quantity`, `minimum_stock`, `supplier_info`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'OIL-5W30', 'Oli Mesin 5W-30 Synthetic', NULL, NULL, NULL, '150000.00', 50, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(2, 'OIL-10W40', 'Oli Mesin 10W-40', NULL, NULL, NULL, '135000.00', 40, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(3, 'FLT-OLI', 'Filter Oli', NULL, NULL, NULL, '45000.00', 60, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(4, 'FLT-UDARA', 'Filter Udara', NULL, NULL, NULL, '55000.00', 30, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(5, 'SPARK-PLUG', 'Busi NGK Standard', NULL, NULL, NULL, '35000.00', 100, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(6, 'BAT-NS40', 'Aki Kering NS40 35Ah', NULL, NULL, NULL, '650000.00', 15, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(7, 'BRAKE-PAD-FR', 'Kampas Rem Depan', NULL, NULL, NULL, '220000.00', 24, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-28 02:02:20'),
(8, 'BRAKE-PAD-RR', 'Kampas Rem Belakang', NULL, NULL, NULL, '210000.00', 20, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(9, 'BELT-FAN', 'Fan Belt', NULL, NULL, NULL, '90000.00', 18, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(10, 'V-BELT', 'V Belt', NULL, NULL, NULL, '120000.00', 22, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(11, 'COOLANT', 'Radiator Coolant 1L', NULL, NULL, NULL, '40000.00', 35, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(12, 'WIPER-20', 'Karet Wiper 20 inch', NULL, NULL, NULL, '55000.00', 40, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(13, 'WIPER-18', 'Karet Wiper 18 inch', NULL, NULL, NULL, '52000.00', 35, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(14, 'LAMPU-H4', 'Lampu Headlamp H4 60/55W', NULL, NULL, NULL, '80000.00', 30, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(15, 'LAMPU-STOP', 'Bohlam Lampu Rem 21/5W', NULL, NULL, NULL, '15000.00', 50, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(16, 'FUEL-FLTR', 'Filter Bensin', NULL, NULL, NULL, '65000.00', 25, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(17, 'AIRCON-FLTR', 'Filter Kabin AC', NULL, NULL, NULL, '75000.00', 30, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(18, 'POWER-STEER', 'Fluid Power Steering 1L', NULL, NULL, NULL, '48000.00', 20, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(19, 'BRAKE-FLUID', 'Minyak Rem DOT3 300ml', NULL, NULL, NULL, '45000.00', 30, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12'),
(20, 'GEAR-OIL', 'Oli Gardan 80W-90 1L', NULL, NULL, NULL, '60000.00', 25, 0, NULL, 1, '2025-06-26 20:47:12', '2025-06-26 20:47:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `technicians`
--

CREATE TABLE `technicians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `experience_years` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `certification` varchar(255) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `salary` decimal(12,2) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `technicians`
--

INSERT INTO `technicians` (`id`, `user_id`, `employee_id`, `specialization`, `experience_years`, `certification`, `hire_date`, `salary`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 2, 'EMP001', 'General Service', 3, NULL, '2024-06-24', NULL, 1, '2025-06-24 03:11:56', '2025-06-24 03:11:56'),
(2, 10, 'EMP002', NULL, 0, NULL, NULL, NULL, 1, '2025-06-25 03:35:08', '2025-06-25 03:35:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('admin','teknisi','pelanggan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `address`, `role`) VALUES
(1, 'Administrator', 'admin@example.com', NULL, '$2y$10$heK1WIKXiMdU2vOYnUs3cORdFIogpdrdnof.0JI8MVLVwdRa5c0nS', NULL, '2025-06-24 03:11:55', '2025-06-24 03:11:55', '0800000000', NULL, 'admin'),
(2, 'Technician User', 'tech@example.com', NULL, '$2y$10$zCKVgFWJ2M/ReYJNPm2wRepeVz4.565S.7rlbDfHBchvkeato8nOe', NULL, '2025-06-24 03:11:56', '2025-06-24 03:11:56', '0800000001', NULL, 'teknisi'),
(3, 'Customer User', 'customer@example.com', NULL, '$2y$10$RxrF8bvyg5OTEbQ/Yq2Pde5mr6K0KuOp5s39Q9j8CYdbfLNn/FU8K', NULL, '2025-06-24 03:11:56', '2025-06-24 03:11:56', '0800000002', NULL, 'pelanggan'),
(7, 'Taufiq Aziz', 'azizt91@gmail.com', NULL, '$2y$10$cT9Ud3CKIiSMGON1v63dBumcYghztcjnOpMwk05jvrdRiJzEVvU.y', NULL, '2025-06-24 19:40:26', '2025-06-24 21:01:23', '081914170701', NULL, 'admin'),
(10, 'Andi', 'andi@gmail.com', NULL, '$2y$10$YdbC8EtXl33hKFjXRQguL./gQg0D40ggAgvp93oCHjHjIPvlAxiru', NULL, '2025-06-25 03:35:08', '2025-06-25 03:35:08', '081914170702', NULL, 'teknisi'),
(12, 'Ayu', 'ayu@gmail.com', NULL, '$2y$10$zxZj84nCLtJlyiP6scfz8e2Q0y4gvwxVDEHdsqSkF9BLYspvR7oCe', NULL, '2025-06-25 03:42:48', '2025-06-25 03:42:48', '081914170801', NULL, 'pelanggan'),
(15, 'Aziz', 'ajes91@gmail.com', NULL, '$2y$10$19cAt83H1L/zyMTYaxUvXeePXKyhNryXVJrXMg8O49Q13faC8uRC.', NULL, '2025-06-26 03:20:04', '2025-06-26 03:20:04', '081914170703', NULL, 'pelanggan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `license_plate` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` year(4) DEFAULT NULL,
  `engine_type` varchar(255) DEFAULT NULL,
  `transmission_type` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `chassis_number` varchar(255) DEFAULT NULL,
  `engine_number` varchar(255) DEFAULT NULL,
  `qr_token` char(36) NOT NULL,
  `last_service_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `vehicle_type_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vehicles`
--

INSERT INTO `vehicles` (`id`, `customer_id`, `license_plate`, `brand`, `model`, `year`, `engine_type`, `transmission_type`, `color`, `chassis_number`, `engine_number`, `qr_token`, `last_service_date`, `created_at`, `updated_at`, `vehicle_type_id`) VALUES
(1, 1, 'G6632KM', 'Honda', 'Honda Brio', 2017, NULL, NULL, 'Merah', NULL, NULL, '', NULL, '2025-06-24 21:57:46', '2025-06-24 21:57:46', NULL),
(2, 2, 'A1234BC', 'Toyota', 'Toyota Kijang', 2010, NULL, NULL, 'Hitam', NULL, NULL, '', NULL, '2025-06-25 03:44:04', '2025-06-25 03:44:04', NULL),
(4, 1, 'G4321HI', 'BYD', 'BYD SEAL', 2024, NULL, NULL, 'Blue', NULL, NULL, '08419aec-eace-4717-b091-590ba9318246', NULL, '2025-07-11 01:34:43', '2025-07-11 01:34:43', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicle_types`
--

CREATE TABLE `vehicle_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Motorcycle', 'Motorcycle vehicles', '2025-06-24 03:27:19', '2025-06-24 03:27:19'),
(2, 'Car', 'Car vehicles', '2025-06-24 03:27:19', '2025-06-24 03:27:19'),
(3, 'Truck', 'Truck vehicles', '2025-06-24 03:27:19', '2025-06-24 03:27:19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_customer_code_unique` (`customer_code`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `qr_scans`
--
ALTER TABLE `qr_scans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qr_scans_vehicle_id_foreign` (`vehicle_id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_booking_id_foreign` (`booking_id`),
  ADD KEY `reviews_customer_id_foreign` (`customer_id`),
  ADD KEY `reviews_technician_id_foreign` (`technician_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_bookings_booking_code_unique` (`booking_code`),
  ADD KEY `service_bookings_customer_id_foreign` (`customer_id`),
  ADD KEY `service_bookings_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `service_bookings_service_category_id_foreign` (`service_category_id`),
  ADD KEY `service_bookings_technician_id_foreign` (`technician_id`);

--
-- Indeks untuk tabel `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `service_details`
--
ALTER TABLE `service_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_details_booking_id_foreign` (`booking_id`),
  ADD KEY `service_details_spare_part_id_foreign` (`spare_part_id`);

--
-- Indeks untuk tabel `service_progress`
--
ALTER TABLE `service_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_progress_booking_id_foreign` (`booking_id`),
  ADD KEY `service_progress_technician_id_foreign` (`technician_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `spare_parts`
--
ALTER TABLE `spare_parts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `spare_parts_part_code_unique` (`part_code`);

--
-- Indeks untuk tabel `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `technicians_employee_id_unique` (`employee_id`),
  ADD KEY `technicians_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_license_plate_unique` (`license_plate`),
  ADD KEY `vehicles_customer_id_foreign` (`customer_id`),
  ADD KEY `vehicles_vehicle_type_id_foreign` (`vehicle_type_id`);

--
-- Indeks untuk tabel `vehicle_types`
--
ALTER TABLE `vehicle_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `qr_scans`
--
ALTER TABLE `qr_scans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `service_bookings`
--
ALTER TABLE `service_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `service_details`
--
ALTER TABLE `service_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `service_progress`
--
ALTER TABLE `service_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `spare_parts`
--
ALTER TABLE `spare_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `service_bookings` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `qr_scans`
--
ALTER TABLE `qr_scans`
  ADD CONSTRAINT `qr_scans_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `service_bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD CONSTRAINT `service_bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_bookings_service_category_id_foreign` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`),
  ADD CONSTRAINT `service_bookings_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `service_bookings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `service_details`
--
ALTER TABLE `service_details`
  ADD CONSTRAINT `service_details_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `service_bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_details_spare_part_id_foreign` FOREIGN KEY (`spare_part_id`) REFERENCES `spare_parts` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `service_progress`
--
ALTER TABLE `service_progress`
  ADD CONSTRAINT `service_progress_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `service_bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_progress_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `technicians`
--
ALTER TABLE `technicians`
  ADD CONSTRAINT `technicians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicles_vehicle_type_id_foreign` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
