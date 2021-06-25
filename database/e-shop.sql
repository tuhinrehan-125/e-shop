-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2021 at 08:14 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` enum('saving_current','capital') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_transactions`
--

CREATE TABLE `account_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `type` enum('debit','credit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_type` enum('opening_balance','fund_transfer','deposit') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(22,4) NOT NULL,
  `reff_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `transaction_payment_id` int(11) DEFAULT NULL,
  `transfer_transaction_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barcodes`
--

CREATE TABLE `barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` double(8,2) DEFAULT NULL,
  `height` double(8,2) DEFAULT NULL,
  `paper_width` double(8,2) DEFAULT NULL,
  `paper_height` double(8,2) DEFAULT NULL,
  `top_margin` double(8,2) DEFAULT NULL,
  `left_margin` double(8,2) DEFAULT NULL,
  `row_distance` double(8,2) DEFAULT NULL,
  `col_distance` double(8,2) DEFAULT NULL,
  `stickers_in_one_row` int(11) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_continuous` tinyint(1) NOT NULL DEFAULT 0,
  `stickers_in_one_sheet` int(11) DEFAULT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `business_id`, `name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Universal', NULL, NULL, '2021-04-06 05:34:50', '2021-04-06 05:34:50'),
(2, 2, 'abc', NULL, NULL, '2021-04-10 00:13:21', '2021-04-10 00:13:21'),
(3, 2, 'new one', 'adddd', NULL, '2021-04-10 00:15:05', '2021-04-10 00:15:05'),
(4, 2, 'fgdfgdf', NULL, NULL, '2021-04-10 00:17:13', '2021-04-10 00:17:13'),
(5, 2, 'Nioko', NULL, NULL, '2021-04-10 00:46:48', '2021-04-10 00:46:48'),
(6, 2, 'yuiop', NULL, NULL, '2021-04-10 00:47:03', '2021-04-10 00:47:03'),
(7, 2, 'gffghfdg', NULL, NULL, '2021-04-10 00:53:19', '2021-04-10 00:53:19'),
(8, 2, 'hyfyf', NULL, NULL, '2021-04-10 00:56:29', '2021-04-10 00:56:29'),
(9, 2, 'jjj', NULL, NULL, '2021-04-10 00:58:32', '2021-04-10 00:58:32'),
(10, 2, 'uii', NULL, NULL, '2021-04-10 00:58:49', '2021-04-10 00:58:49'),
(11, 2, 'jjj', NULL, NULL, '2021-04-10 01:02:08', '2021-04-10 01:02:08'),
(12, 2, 'iopp', NULL, NULL, '2021-04-10 01:03:11', '2021-04-10 01:03:11'),
(13, 2, 'uiii', NULL, NULL, '2021-04-10 01:04:16', '2021-04-10 01:04:16'),
(14, 2, 'ggjg', NULL, NULL, '2021-04-10 01:07:39', '2021-04-10 01:07:39'),
(15, 2, 'gklgg', NULL, NULL, '2021-04-10 01:07:53', '2021-04-10 01:07:53'),
(16, 2, 'ggg', NULL, NULL, '2021-04-13 08:13:17', '2021-04-13 08:13:17'),
(17, 2, 'New one', NULL, NULL, '2021-04-17 23:29:52', '2021-04-17 23:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `default_profit_percent` double(5,2) NOT NULL DEFAULT 0.00,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `time_zone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Asia/Kolkata',
  `default_sales_discount` decimal(5,2) DEFAULT NULL,
  `sell_price_tax` enum('includes','excludes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'includes',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku_prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enable_price_tax` tinyint(1) NOT NULL DEFAULT 1,
  `default_unit` int(11) DEFAULT NULL,
  `date_format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'm/d/Y',
  `time_format` enum('12','24') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '24',
  `email_settings` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_settings` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol_placement` enum('before','after') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'before',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`id`, `name`, `currency_id`, `start_date`, `default_profit_percent`, `owner_id`, `time_zone`, `default_sales_discount`, `sell_price_tax`, `logo`, `sku_prefix`, `enable_price_tax`, `default_unit`, `date_format`, `time_format`, `email_settings`, `sms_settings`, `currency_symbol_placement`, `created_at`, `updated_at`) VALUES
(1, 'Xyz', 1, NULL, 0.00, 1, 'Asia/Kolkata', NULL, 'includes', NULL, NULL, 1, NULL, 'm/d/Y', '24', NULL, NULL, 'before', NULL, NULL),
(2, 'Imti-store', 134, NULL, 0.00, 2, 'Asia/Dhaka', NULL, 'includes', NULL, NULL, 1, NULL, 'm/d/Y', '24', NULL, NULL, 'before', '2021-04-05 00:08:47', '2021-05-08 03:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `business_locations`
--

CREATE TABLE `business_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternate_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_locations`
--

INSERT INTO `business_locations` (`id`, `business_id`, `location_id`, `name`, `country`, `state`, `city`, `zip_code`, `mobile`, `alternate_number`, `email`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'Store-1', 'BD', 'Dhaka', 'Dhaka', '1234', '01683207978', NULL, NULL, NULL, '2021-04-05 00:12:12', '2021-04-05 00:12:12'),
(2, 2, NULL, 'Store-2', 'BD', 'Dhaka', 'Dhaka', '1234', '01683207978', NULL, NULL, NULL, '2021-04-05 00:12:12', '2021-04-05 00:12:12'),
(3, 2, NULL, 'new store', 'BD', 'Dhaka', 'Dhaka', '123', '0167373733', NULL, NULL, NULL, '2021-05-08 23:35:54', '2021-05-08 23:35:54');

-- --------------------------------------------------------

--
-- Table structure for table `business_location_user`
--

CREATE TABLE `business_location_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_location_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_location_user`
--

INSERT INTO `business_location_user` (`id`, `business_location_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `short_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `business_id`, `short_code`, `parent_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'cat_1', 2, 'st', 0, NULL, '2021-04-05 06:24:14', '2021-04-05 06:24:14'),
(2, 'cat_2', 2, NULL, 0, NULL, '2021-04-10 04:50:40', '2021-04-10 04:50:40'),
(3, 'sub_cat', 2, 'sc', 1, NULL, '2021-04-10 04:50:58', '2021-04-10 04:50:58');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('supplier','customer','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternate_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_group_id` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `business_id`, `type`, `supplier_business_name`, `name`, `email`, `address`, `tax_number`, `city`, `state`, `country`, `zip_code`, `mobile`, `alternate_number`, `customer_group_id`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'supplier', 'pran', 'Abul', 'ajajj@gm.com', 'House: 23, Road: 1, Block C, Tajmahal road, Mohammadpur', '23456', 'Dhaka', NULL, 'Bangladesh', '1207', '01683207978', NULL, NULL, 2, NULL, '2021-04-07 23:36:15', '2021-04-07 23:36:15'),
(2, 2, 'customer', NULL, 'Abdul halim', 'abdul@gmail.com', 'sdjfsjdfjdjfdsf', '234567', 'Dhaka', 'Dhaka', 'BD', '345', '2345678', NULL, NULL, 2, NULL, '2021-04-12 00:03:13', '2021-04-12 00:03:13');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thousand_separator` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `decimal_separator` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `country`, `currency`, `code`, `symbol`, `thousand_separator`, `decimal_separator`, `created_at`, `updated_at`) VALUES
(1, 'Albania', 'Leke', 'ALL', 'Lek', ',', '.', NULL, NULL),
(2, 'America', 'Dollars', 'USD', '$', ',', '.', NULL, NULL),
(3, 'Afghanistan', 'Afghanis', 'AF', '؋', ',', '.', NULL, NULL),
(4, 'Argentina', 'Pesos', 'ARS', '$', ',', '.', NULL, NULL),
(5, 'Aruba', 'Guilders', 'AWG', 'ƒ', ',', '.', NULL, NULL),
(6, 'Australia', 'Dollars', 'AUD', '$', ',', '.', NULL, NULL),
(7, 'Azerbaijan', 'New Manats', 'AZ', 'ман', ',', '.', NULL, NULL),
(8, 'Bahamas', 'Dollars', 'BSD', '$', ',', '.', NULL, NULL),
(9, 'Barbados', 'Dollars', 'BBD', '$', ',', '.', NULL, NULL),
(10, 'Belarus', 'Rubles', 'BYR', 'p.', ',', '.', NULL, NULL),
(11, 'Belgium', 'Euro', 'EUR', '€', ',', '.', NULL, NULL),
(12, 'Beliz', 'Dollars', 'BZD', 'BZ$', ',', '.', NULL, NULL),
(13, 'Bermuda', 'Dollars', 'BMD', '$', ',', '.', NULL, NULL),
(14, 'Bolivia', 'Bolivianos', 'BOB', '$b', ',', '.', NULL, NULL),
(15, 'Bosnia and Herzegovina', 'Convertible Marka', 'BAM', 'KM', ',', '.', NULL, NULL),
(16, 'Botswana', 'Pula\'s', 'BWP', 'P', ',', '.', NULL, NULL),
(17, 'Bulgaria', 'Leva', 'BG', 'лв', ',', '.', NULL, NULL),
(18, 'Brazil', 'Reais', 'BRL', 'R$', ',', '.', NULL, NULL),
(19, 'Britain [United Kingdom]', 'Pounds', 'GBP', '£', ',', '.', NULL, NULL),
(20, 'Brunei Darussalam', 'Dollars', 'BND', '$', ',', '.', NULL, NULL),
(21, 'Cambodia', 'Riels', 'KHR', '៛', ',', '.', NULL, NULL),
(22, 'Canada', 'Dollars', 'CAD', '$', ',', '.', NULL, NULL),
(23, 'Cayman Islands', 'Dollars', 'KYD', '$', ',', '.', NULL, NULL),
(24, 'Chile', 'Pesos', 'CLP', '$', ',', '.', NULL, NULL),
(25, 'China', 'Yuan Renminbi', 'CNY', '¥', ',', '.', NULL, NULL),
(26, 'Colombia', 'Pesos', 'COP', '$', ',', '.', NULL, NULL),
(27, 'Costa Rica', 'Colón', 'CRC', '₡', ',', '.', NULL, NULL),
(28, 'Croatia', 'Kuna', 'HRK', 'kn', ',', '.', NULL, NULL),
(29, 'Cuba', 'Pesos', 'CUP', '₱', ',', '.', NULL, NULL),
(30, 'Cyprus', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(31, 'Czech Republic', 'Koruny', 'CZK', 'Kč', ',', '.', NULL, NULL),
(32, 'Denmark', 'Kroner', 'DKK', 'kr', ',', '.', NULL, NULL),
(33, 'Dominican Republic', 'Pesos', 'DOP ', 'RD$', ',', '.', NULL, NULL),
(34, 'East Caribbean', 'Dollars', 'XCD', '$', ',', '.', NULL, NULL),
(35, 'Egypt', 'Pounds', 'EGP', '£', ',', '.', NULL, NULL),
(36, 'El Salvador', 'Colones', 'SVC', '$', ',', '.', NULL, NULL),
(37, 'England [United Kingdom]', 'Pounds', 'GBP', '£', ',', '.', NULL, NULL),
(38, 'Euro', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(39, 'Falkland Islands', 'Pounds', 'FKP', '£', ',', '.', NULL, NULL),
(40, 'Fiji', 'Dollars', 'FJD', '$', ',', '.', NULL, NULL),
(41, 'France', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(42, 'Ghana', 'Cedis', 'GHC', '¢', ',', '.', NULL, NULL),
(43, 'Gibraltar', 'Pounds', 'GIP', '£', ',', '.', NULL, NULL),
(44, 'Greece', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(45, 'Guatemala', 'Quetzales', 'GTQ', 'Q', ',', '.', NULL, NULL),
(46, 'Guernsey', 'Pounds', 'GGP', '£', ',', '.', NULL, NULL),
(47, 'Guyana', 'Dollars', 'GYD', '$', ',', '.', NULL, NULL),
(48, 'Holland [Netherlands]', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(49, 'Honduras', 'Lempiras', 'HNL', 'L', ',', '.', NULL, NULL),
(50, 'Hong Kong', 'Dollars', 'HKD', '$', ',', '.', NULL, NULL),
(51, 'Hungary', 'Forint', 'HUF', 'Ft', ',', '.', NULL, NULL),
(52, 'Iceland', 'Kronur', 'ISK', 'kr', ',', '.', NULL, NULL),
(53, 'India', 'Rupees', 'INR', '₹', ',', '.', NULL, NULL),
(54, 'Indonesia', 'Rupiahs', 'IDR', 'Rp', ',', '.', NULL, NULL),
(55, 'Iran', 'Rials', 'IRR', '﷼', ',', '.', NULL, NULL),
(56, 'Ireland', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(57, 'Isle of Man', 'Pounds', 'IMP', '£', ',', '.', NULL, NULL),
(58, 'Israel', 'New Shekels', 'ILS', '₪', ',', '.', NULL, NULL),
(59, 'Italy', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(60, 'Jamaica', 'Dollars', 'JMD', 'J$', ',', '.', NULL, NULL),
(61, 'Japan', 'Yen', 'JPY', '¥', ',', '.', NULL, NULL),
(62, 'Jersey', 'Pounds', 'JEP', '£', ',', '.', NULL, NULL),
(63, 'Kazakhstan', 'Tenge', 'KZT', 'лв', ',', '.', NULL, NULL),
(64, 'Korea [North]', 'Won', 'KPW', '₩', ',', '.', NULL, NULL),
(65, 'Korea [South]', 'Won', 'KRW', '₩', ',', '.', NULL, NULL),
(66, 'Kyrgyzstan', 'Soms', 'KGS', 'лв', ',', '.', NULL, NULL),
(67, 'Laos', 'Kips', 'LAK', '₭', ',', '.', NULL, NULL),
(68, 'Latvia', 'Lati', 'LVL', 'Ls', ',', '.', NULL, NULL),
(69, 'Lebanon', 'Pounds', 'LBP', '£', ',', '.', NULL, NULL),
(70, 'Liberia', 'Dollars', 'LRD', '$', ',', '.', NULL, NULL),
(71, 'Liechtenstein', 'Switzerland Francs', 'CHF', 'CHF', ',', '.', NULL, NULL),
(72, 'Lithuania', 'Litai', 'LTL', 'Lt', ',', '.', NULL, NULL),
(73, 'Luxembourg', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(74, 'Macedonia', 'Denars', 'MKD', 'ден', ',', '.', NULL, NULL),
(75, 'Malaysia', 'Ringgits', 'MYR', 'RM', ',', '.', NULL, NULL),
(76, 'Malta', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(77, 'Mauritius', 'Rupees', 'MUR', '₨', ',', '.', NULL, NULL),
(78, 'Mexico', 'Pesos', 'MX', '$', ',', '.', NULL, NULL),
(79, 'Mongolia', 'Tugriks', 'MNT', '₮', ',', '.', NULL, NULL),
(80, 'Mozambique', 'Meticais', 'MZ', 'MT', ',', '.', NULL, NULL),
(81, 'Namibia', 'Dollars', 'NAD', '$', ',', '.', NULL, NULL),
(82, 'Nepal', 'Rupees', 'NPR', '₨', ',', '.', NULL, NULL),
(83, 'Netherlands Antilles', 'Guilders', 'ANG', 'ƒ', ',', '.', NULL, NULL),
(84, 'Netherlands', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(85, 'New Zealand', 'Dollars', 'NZD', '$', ',', '.', NULL, NULL),
(86, 'Nicaragua', 'Cordobas', 'NIO', 'C$', ',', '.', NULL, NULL),
(87, 'Nigeria', 'Nairas', 'NG', '₦', ',', '.', NULL, NULL),
(88, 'North Korea', 'Won', 'KPW', '₩', ',', '.', NULL, NULL),
(89, 'Norway', 'Krone', 'NOK', 'kr', ',', '.', NULL, NULL),
(90, 'Oman', 'Rials', 'OMR', '﷼', ',', '.', NULL, NULL),
(91, 'Pakistan', 'Rupees', 'PKR', '₨', ',', '.', NULL, NULL),
(92, 'Panama', 'Balboa', 'PAB', 'B/.', ',', '.', NULL, NULL),
(93, 'Paraguay', 'Guarani', 'PYG', 'Gs', ',', '.', NULL, NULL),
(94, 'Peru', 'Nuevos Soles', 'PE', 'S/.', ',', '.', NULL, NULL),
(95, 'Philippines', 'Pesos', 'PHP', 'Php', ',', '.', NULL, NULL),
(96, 'Poland', 'Zlotych', 'PL', 'zł', ',', '.', NULL, NULL),
(97, 'Qatar', 'Rials', 'QAR', '﷼', ',', '.', NULL, NULL),
(98, 'Romania', 'New Lei', 'RO', 'lei', ',', '.', NULL, NULL),
(99, 'Russia', 'Rubles', 'RUB', 'руб', ',', '.', NULL, NULL),
(100, 'Saint Helena', 'Pounds', 'SHP', '£', ',', '.', NULL, NULL),
(101, 'Saudi Arabia', 'Riyals', 'SAR', '﷼', ',', '.', NULL, NULL),
(102, 'Serbia', 'Dinars', 'RSD', 'Дин.', ',', '.', NULL, NULL),
(103, 'Seychelles', 'Rupees', 'SCR', '₨', ',', '.', NULL, NULL),
(104, 'Singapore', 'Dollars', 'SGD', '$', ',', '.', NULL, NULL),
(105, 'Slovenia', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(106, 'Solomon Islands', 'Dollars', 'SBD', '$', ',', '.', NULL, NULL),
(107, 'Somalia', 'Shillings', 'SOS', 'S', ',', '.', NULL, NULL),
(108, 'South Africa', 'Rand', 'ZAR', 'R', ',', '.', NULL, NULL),
(109, 'South Korea', 'Won', 'KRW', '₩', ',', '.', NULL, NULL),
(110, 'Spain', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(111, 'Sri Lanka', 'Rupees', 'LKR', '₨', ',', '.', NULL, NULL),
(112, 'Sweden', 'Kronor', 'SEK', 'kr', ',', '.', NULL, NULL),
(113, 'Switzerland', 'Francs', 'CHF', 'CHF', ',', '.', NULL, NULL),
(114, 'Suriname', 'Dollars', 'SRD', '$', ',', '.', NULL, NULL),
(115, 'Syria', 'Pounds', 'SYP', '£', ',', '.', NULL, NULL),
(116, 'Taiwan', 'New Dollars', 'TWD', 'NT$', ',', '.', NULL, NULL),
(117, 'Thailand', 'Baht', 'THB', '฿', ',', '.', NULL, NULL),
(118, 'Trinidad and Tobago', 'Dollars', 'TTD', 'TT$', ',', '.', NULL, NULL),
(119, 'Turkey', 'Lira', 'TRY', 'TL', ',', '.', NULL, NULL),
(120, 'Turkey', 'Liras', 'TRL', '£', ',', '.', NULL, NULL),
(121, 'Tuvalu', 'Dollars', 'TVD', '$', ',', '.', NULL, NULL),
(122, 'Ukraine', 'Hryvnia', 'UAH', '₴', ',', '.', NULL, NULL),
(123, 'United Kingdom', 'Pounds', 'GBP', '£', ',', '.', NULL, NULL),
(124, 'United States of America', 'Dollars', 'USD', '$', ',', '.', NULL, NULL),
(125, 'Uruguay', 'Pesos', 'UYU', '$U', ',', '.', NULL, NULL),
(126, 'Uzbekistan', 'Sums', 'UZS', 'лв', ',', '.', NULL, NULL),
(127, 'Vatican City', 'Euro', 'EUR', '€', '.', ',', NULL, NULL),
(128, 'Venezuela', 'Bolivares Fuertes', 'VEF', 'Bs', ',', '.', NULL, NULL),
(129, 'Vietnam', 'Dong', 'VND', '₫', ',', '.', NULL, NULL),
(130, 'Yemen', 'Rials', 'YER', '﷼', ',', '.', NULL, NULL),
(131, 'Zimbabwe', 'Zimbabwe Dollars', 'ZWD', 'Z$', ',', '.', NULL, NULL),
(132, 'Iraq', 'Iraqi dinar', 'IQD', 'د.ع', ',', '.', NULL, NULL),
(133, 'Kenya', 'Kenyan shilling', 'KES', 'KSh', ',', '.', NULL, NULL),
(134, 'Bangladesh', 'Taka', 'BDT', '৳', ',', '.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage_value` double(5,2) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_groups`
--

INSERT INTO `customer_groups` (`id`, `business_id`, `name`, `percentage_value`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Platinum', 7.00, 2, NULL, '2021-05-29 10:34:28', '2021-05-29 10:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `applicable_in_spg` tinyint(1) DEFAULT 0,
  `applicable_in_cg` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `business_location_id` bigint(20) NOT NULL,
  `is_monthly_expense` int(11) DEFAULT 0,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_for` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `exp_cat_id` int(10) UNSIGNED DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `business_id`, `business_location_id`, `is_monthly_expense`, `amount`, `ref_no`, `expense_for`, `exp_date`, `exp_cat_id`, `note`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 0, '234', '67657', 'daily chay bill', '2021-04-09', 1, 'jghjghj', 2, '2021-04-18 03:13:46', '2021-04-18 03:13:46', NULL),
(2, 2, 2, 1, '565', 'ghfgh', 'ddsg', '2021-04-24', 1, NULL, 2, '2021-04-18 03:32:59', '2021-04-18 03:32:59', NULL),
(4, 2, 3, 1, '234', 'fgdfg', 'daily', '2021-05-22', 1, NULL, 2, '2021-05-09 06:11:01', '2021-05-09 06:11:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `name`, `business_id`, `code`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Cha', 2, NULL, NULL, '2021-04-18 02:38:38', '2021-04-18 02:38:38'),
(2, 'Clod drinks', 2, NULL, NULL, '2021-04-18 02:41:46', '2021-04-18 02:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileable_id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `type`, `fileable_type`, `fileable_id`, `business_id`, `created_at`, `updated_at`) VALUES
(1, '4077470af04988e.jpg', 'image', 'App\\Models\\Products', 12, 2, '2021-04-06 05:44:05', '2021-04-06 05:44:05'),
(5, 'd9cb4084f613861.png', 'image', 'App\\Models\\Products', 16, 2, '2021-04-06 07:45:50', '2021-04-06 07:45:50'),
(10, 'e9e649b7070422f.png', 'image', 'App\\Models\\Products', 43, 2, '2021-04-06 09:07:18', '2021-04-06 09:07:18'),
(11, 'f98f51b35600da7.png', 'image', 'App\\Models\\Products', 44, 2, '2021-04-06 09:14:17', '2021-04-06 09:14:17'),
(12, '9e6e08fe398e683.png', 'image', 'App\\Models\\Products', 46, 2, '2021-04-13 23:15:33', '2021-04-13 23:15:33'),
(13, 'c690d24ba78e561.gif', 'file', 'App\\Models\\Business', 2, 2, '2021-05-08 03:23:49', '2021-05-08 03:23:49'),
(15, 'b73e82548d529f0.pdf', 'file', 'App\\Models\\Expense', 4, 2, '2021-05-09 06:11:01', '2021-05-09 06:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `location_product_stocks`
--

CREATE TABLE `location_product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_variation_id` int(10) UNSIGNED NOT NULL COMMENT 'id from product_variations table',
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `qty_available` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location_product_stocks`
--

INSERT INTO `location_product_stocks` (`id`, `product_id`, `product_variation_id`, `business_id`, `location_id`, `qty_available`, `created_at`, `updated_at`) VALUES
(18, 6, 5, 2, 1, '26.00', '2021-04-20 01:09:33', '2021-05-25 01:19:43'),
(19, 4, 3, 2, 1, '26.00', '2021-04-20 01:09:33', '2021-05-25 01:19:43'),
(20, 11, 6, 2, 1, '-1.00', '2021-04-30 10:31:15', '2021-05-24 01:37:47'),
(21, 35, 21, 2, 1, '3.00', '2021-04-30 10:34:11', '2021-05-27 01:07:32'),
(22, 6, 5, 2, 2, '0.00', '2021-04-30 10:35:58', '2021-05-25 00:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_07_05_071953_create_currencies_table', 1),
(4, '2017_07_05_073658_create_business_table', 1),
(5, '2017_07_10_122822_create_business_locations_table', 1),
(6, '2017_07_22_075923_add_business_id_users_table', 1),
(7, '2017_07_23_113209_create_brands_table', 1),
(8, '2017_07_26_122313_create_units_table', 1),
(9, '2017_07_27_075706_create_contacts_table', 1),
(10, '2017_07_27_104124_create_expense_categories_table', 1),
(11, '2017_08_04_071038_create_categories_table', 1),
(13, '2017_08_10_061145_create_variations_table', 1),
(15, '2017_08_19_054827_create_transactions_table', 1),
(16, '2017_10_15_064638_create_transaction_payments_table', 1),
(17, '2017_11_21_064540_create_barcodes_table', 1),
(18, '2017_12_25_163227_create_variation_location_details_table', 1),
(19, '2018_01_04_115627_create_sessions_table', 1),
(20, '2018_02_08_111027_add_expiry_period_and_expiry_period_type_columns_to_products_table', 1),
(21, '2018_02_20_165505_add_is_direct_sale_column_to_transactions_table', 1),
(22, '2018_03_26_165350_create_customer_groups_table', 1),
(23, '2018_03_27_122720_customer_group_related_changes_in_tables', 1),
(24, '2018_05_02_104439_add_date_format_and_time_format_to_business', 1),
(25, '2018_05_02_111939_add_sell_return_to_transaction_payments', 1),
(26, '2018_05_18_191956_add_sell_return_to_transaction_table', 1),
(27, '2018_05_24_132620_add_ref_no_column_to_transaction_payments_table', 1),
(28, '2018_05_24_161026_add_location_id_column_to_business_location_table', 1),
(29, '2018_06_07_182258_add_image_field_to_products_table', 1),
(30, '2018_06_15_173636_add_email_column_to_contacts_table', 1),
(31, '2018_08_08_110755_add_new_payment_methods_to_transaction_payments_table', 1),
(32, '2018_08_14_104036_add_opening_balance_type_to_transactions_table', 1),
(33, '2018_09_04_155900_create_accounts_table', 1),
(34, '2018_09_10_152703_create_account_transactions_table', 1),
(35, '2018_09_10_173656_add_account_id_column_to_transaction_payments_table', 1),
(36, '2018_09_22_110504_add_sms_and_email_settings_columns_to_business_table', 1),
(37, '2018_10_09_153105_add_business_id_to_transaction_payments_table', 1),
(38, '2018_11_26_114135_add_is_suspend_column_to_transactions_table', 1),
(39, '2018_12_24_154933_create_notifications_table', 1),
(40, '2019_01_28_111647_add_order_addresses_column_to_transactions_table', 1),
(41, '2019_02_19_103118_create_discounts_table', 1),
(42, '2019_03_15_132925_create_media_table', 1),
(43, '2021_03_14_050409_create_expenses_table', 1),
(44, '2021_03_15_064125_create_opening_stock_qties_table', 1),
(45, '2021_03_18_091107_create_purchases_table', 1),
(47, '2021_03_18_105726_create_purchase_payments_table', 1),
(50, '2021_03_24_091717_create_sale_purchase_returns_table', 1),
(51, '2021_03_29_100409_create_permission_tables', 1),
(52, '2017_08_08_115903_create_products_table', 2),
(54, '2017_08_10_061146_create_product_variations_table', 3),
(55, '2021_04_05_094556_create_location_product_stocks_table', 3),
(56, '2021_04_05_113228_create_files_table', 4),
(57, '2021_03_18_105705_create_purchase_items_table', 5),
(59, '2021_04_12_184345_create_payments_table', 7),
(60, '2021_03_24_065635_create_sells_table', 8),
(62, '2021_04_15_065233_create_stock_transfers_table', 9),
(63, '2021_04_15_074800_create_stock_transfer_items_table', 9),
(65, '2021_04_19_082528_create_sell_purchase_returns_table', 10),
(67, '2021_05_05_111008_create_business_location_user_table', 11),
(68, '2021_05_10_115111_create_quotations_table', 12),
(69, '2021_05_11_045048_create_quotation_items_table', 12),
(70, '2021_03_24_070645_create_sell_items_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opening_stock_qties`
--

CREATE TABLE `opening_stock_qties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `business_location_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opening_stock_qties`
--

INSERT INTO `opening_stock_qties` (`id`, `business_id`, `business_location_id`, `product_id`, `quantity`, `price`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 4, 14, NULL, NULL, '2021-04-05 06:35:16', '2021-04-23 10:47:36'),
(4, 2, 1, 35, 23, NULL, NULL, '2021-04-06 08:45:06', '2021-04-06 08:45:06'),
(5, 2, 2, 35, 45, NULL, NULL, '2021-04-06 08:45:06', '2021-04-06 08:45:06'),
(6, 2, 1, 39, 23, NULL, NULL, '2021-04-06 08:59:06', '2021-04-06 08:59:06'),
(7, 2, 2, 39, 45, NULL, NULL, '2021-04-06 08:59:06', '2021-04-06 08:59:06'),
(9, 2, 1, 43, 23, NULL, NULL, '2021-04-06 09:07:18', '2021-04-06 09:07:18'),
(10, 2, 2, 43, 45, NULL, NULL, '2021-04-06 09:07:18', '2021-04-06 09:07:18'),
(11, 2, 1, 44, 56, NULL, NULL, '2021-04-06 09:14:18', '2021-04-06 09:14:18'),
(12, 2, 2, 44, 89, NULL, NULL, '2021-04-06 09:14:18', '2021-04-06 09:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paymentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentable_id` bigint(20) UNSIGNED NOT NULL,
  `payment_amount` decimal(20,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `paymentable_type`, `paymentable_id`, `payment_amount`, `payment_method`, `payment_date`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Purchase', 10, '500.00', NULL, '1970-01-01', '2021-04-12 14:12:21', '2021-04-12 14:12:21'),
(2, 'App\\Models\\Purchase', 11, '344.00', 'Cash', '1970-01-01', '2021-04-12 22:58:10', '2021-04-12 22:58:10'),
(3, 'App\\Models\\Purchase', 12, '500.00', 'Cash', '1970-01-01', '2021-04-12 23:10:06', '2021-04-12 23:10:06'),
(4, 'App\\Models\\Sell', 2, '500.00', 'Cash', '2021-04-13', '2021-04-13 00:04:00', '2021-04-13 00:04:00'),
(5, 'App\\Models\\Purchase', 12, '450.00', 'Cash', '2021-04-14', '2021-04-14 00:34:00', '2021-04-14 00:34:00'),
(6, 'App\\Models\\Sell', 2, '750.00', 'Cash', '2021-04-14', '2021-04-14 00:43:00', '2021-04-14 00:43:00'),
(7, 'App\\Models\\Sell', 2, '24.40', 'Cash', '2021-04-14', '2021-04-14 00:53:00', '2021-04-14 00:53:00'),
(8, 'App\\Models\\Purchase', 12, '10.00', 'Cash', '2021-04-19', '2021-04-19 01:41:00', '2021-04-19 01:41:00'),
(9, 'App\\Models\\Purchase', 14, '1200.00', 'Cash', '2021-04-20', '2021-04-20 00:32:00', '2021-04-20 00:32:00'),
(10, 'App\\Models\\Purchase', 15, '34.00', 'Cash', '2021-04-20', '2021-04-20 01:04:00', '2021-04-20 01:04:00'),
(11, 'App\\Models\\Purchase', 16, '5000.00', NULL, '2021-04-20', '2021-04-20 01:09:00', '2021-04-20 01:09:00'),
(12, 'App\\Models\\Sell', 3, '234.00', 'Cash', '2021-04-20', '2021-04-20 03:22:00', '2021-04-20 03:22:00'),
(13, 'App\\Models\\Purchase', 17, '4444.00', 'Cash', '2021-04-30', '2021-04-30 10:31:00', '2021-04-30 10:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user.view', 'api', '2021-05-05 04:13:59', NULL),
(2, 'user.add', 'api', '2021-05-05 04:13:59', NULL),
(3, 'user.update', 'api', '2021-05-05 04:13:59', NULL),
(4, 'user.delete', 'api', '2021-05-05 04:13:59', NULL),
(5, 'user.role', 'api', '2021-05-05 04:13:59', NULL),
(6, 'supplier.view', 'api', '2021-05-05 04:13:59', NULL),
(7, 'supplier.add', 'api', '2021-05-05 04:13:59', NULL),
(8, 'supplier.update', 'api', '2021-05-05 04:13:59', NULL),
(9, 'supplier.delete', 'api', '2021-05-05 04:13:59', NULL),
(10, 'customer.view', 'api', '2021-05-05 04:13:59', NULL),
(11, 'customer.add', 'api', '2021-05-05 04:13:59', NULL),
(12, 'customer.update', 'api', '2021-05-05 04:13:59', NULL),
(13, 'customer.delete', 'api', '2021-05-05 04:13:59', NULL),
(14, 'customer_group.view', 'api', '2021-05-05 04:13:59', NULL),
(15, 'product.view', 'api', '2021-05-05 04:13:59', NULL),
(16, 'product.add', 'api', '2021-05-05 04:13:59', NULL),
(17, 'product.update', 'api', '2021-05-05 04:13:59', NULL),
(18, 'product.delete', 'api', '2021-05-05 04:13:59', NULL),
(19, 'purchase.view', 'api', '2021-05-05 04:13:59', NULL),
(20, 'purchase.add', 'api', '2021-05-05 04:13:59', NULL),
(21, 'purchase.update', 'api', '2021-05-05 04:13:59', NULL),
(22, 'purchase.delete', 'api', '2021-05-05 04:13:59', NULL),
(23, 'purchase_payment.view', 'api', '2021-05-05 04:13:59', NULL),
(24, 'purchase_payment.add', 'api', '2021-05-05 04:13:59', NULL),
(25, 'purchase_payment.return', 'api', '2021-05-05 04:13:59', NULL),
(26, 'sell.view', 'api', '2021-05-05 04:13:59', NULL),
(27, 'sell.add', 'api', '2021-05-05 04:13:59', NULL),
(28, 'sell.update', 'api', '2021-05-05 04:13:59', NULL),
(29, 'sell.delete', 'api', '2021-05-05 04:13:59', NULL),
(30, 'sell_payment.view', 'api', '2021-05-05 04:13:59', NULL),
(31, 'sell_payment.add', 'api', '2021-05-05 04:13:59', NULL),
(32, 'sell_payment.return', 'api', '2021-05-05 04:13:59', NULL),
(33, 'purchase_n_sell_report.view', 'api', '2021-05-05 04:13:59', NULL),
(34, 'contacts_report.view', 'api', '2021-05-05 04:13:59', NULL),
(35, 'stock_report.view', 'api', '2021-05-05 04:13:59', NULL),
(36, 'tax_report.view', 'api', '2021-05-05 04:13:59', NULL),
(37, 'trending_product_report.view', 'api', '2021-05-05 04:13:59', NULL),
(38, 'register_report.view', 'api', '2021-05-05 04:13:59', NULL),
(39, 'sales_representative.view', 'api', '2021-05-05 04:13:59', NULL),
(40, 'expense_report.view', 'api', '2021-05-05 04:13:59', NULL),
(41, 'brand.view', 'api', '2021-05-05 04:13:59', NULL),
(42, 'brand.add', 'api', '2021-05-05 04:13:59', NULL),
(43, 'brand.update', 'api', '2021-05-05 04:13:59', NULL),
(44, 'brand.delete', 'api', '2021-05-05 04:13:59', NULL),
(45, 'unit.view', 'api', '2021-05-05 04:13:59', NULL),
(46, 'unit.add', 'api', '2021-05-05 04:13:59', NULL),
(47, 'unit.update', 'api', '2021-05-05 04:13:59', NULL),
(48, 'unit.delete', 'api', '2021-05-05 04:13:59', NULL),
(49, 'category.view', 'api', '2021-05-05 04:13:59', NULL),
(50, 'category.add', 'api', '2021-05-05 04:13:59', NULL),
(51, 'category.update', 'api', '2021-05-05 04:13:59', NULL),
(52, 'category.delete', 'api', '2021-05-05 04:13:59', NULL),
(53, 'variation.view', 'api', '2021-05-05 04:13:59', NULL),
(54, 'variation.add', 'api', '2021-05-05 04:13:59', NULL),
(55, 'variation.update', 'api', '2021-05-05 04:13:59', NULL),
(56, 'variation.delete', 'api', '2021-05-05 04:13:59', NULL),
(57, 'tax_rate.view', 'api', '2021-05-05 04:13:59', NULL),
(58, 'tax_rate.add', 'api', '2021-05-05 04:13:59', NULL),
(59, 'tax_rate.update', 'api', '2021-05-05 04:13:59', NULL),
(60, 'tax_rate.delete', 'api', '2021-05-05 04:13:59', NULL),
(61, 'stock_transfer.view', 'api', '2021-05-05 04:13:59', NULL),
(62, 'stock_transfer.add', 'api', '2021-05-05 04:13:59', NULL),
(63, 'stock_transfer.update', 'api', '2021-05-05 04:13:59', NULL),
(64, 'expense.add', 'api', '2021-05-05 04:13:59', NULL),
(65, 'expense.update', 'api', '2021-05-05 04:13:59', NULL),
(66, 'expense.view', 'api', '2021-05-05 04:13:59', NULL),
(67, 'expense.delete', 'api', '2021-05-05 04:13:59', NULL),
(68, 'settings.business', 'api', '2021-05-05 04:13:59', NULL),
(69, 'settings.locations', 'api', '2021-05-05 04:13:59', NULL),
(70, 'purchase_return.add', 'api', '2021-05-05 04:13:59', NULL),
(71, 'purchase_return.view', '', NULL, NULL),
(72, 'sell_return.view', 'api', '2021-05-05 04:13:59', NULL),
(73, 'sell_return.add', 'api', '2021-05-05 04:13:59', NULL),
(74, 'expense_category.view', 'api', NULL, NULL),
(75, 'expense_category.add', 'api', NULL, NULL),
(76, 'expense_category.update', 'api', NULL, NULL),
(77, 'expense_category.delete', 'api', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('single','variable') COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_type` enum('inclusive','exclusive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable_stock` tinyint(1) NOT NULL DEFAULT 0,
  `alert_quantity` int(11) NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_type` enum('C39','C128','EAN13','EAN8','UPCA','UPCE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `business_id`, `type`, `unit_id`, `brand_id`, `category_id`, `sub_category_id`, `tax_type`, `enable_stock`, `alert_quantity`, `sku`, `product_description`, `weight`, `barcode_type`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'jjrr', 2, 'single', 1, 16, 1, NULL, 'inclusive', 1, 10, 'fcb24', 'updated note', '50', 'C39', 2, NULL, '2021-04-05 06:35:16', '2021-04-23 10:47:35', NULL),
(6, 'xyzAbc', 2, 'single', 1, NULL, 1, NULL, 'inclusive', 1, 10, '4aac085a984dcec', 'updated note', '50', 'C39', 2, NULL, '2021-04-05 07:11:17', '2021-04-05 07:11:17', NULL),
(11, 'xyzAbc', 2, 'variable', 1, NULL, 1, NULL, 'exclusive', 1, 10, 'e02bc4cfdda52f6', 'updated note', '50', 'C39', 2, NULL, '2021-04-05 07:27:36', '2021-04-05 07:27:36', NULL),
(12, 'jkhujklhgg', 2, 'single', 1, 1, 1, NULL, 'inclusive', 0, 56666, '34444', NULL, NULL, 'C128', 2, NULL, '2021-04-06 05:44:05', '2021-04-06 05:44:05', NULL),
(16, 'new one', 2, '', 1, 1, 1, NULL, 'inclusive', 0, 45, '382c92d290c807c', NULL, NULL, 'EAN8', 2, NULL, '2021-04-06 07:45:49', '2021-04-06 07:45:49', NULL),
(35, 'jdjdj', 2, 'single', 1, 1, 1, NULL, 'inclusive', 0, 23, 'cb90382a74b64ee', NULL, NULL, 'C128', 2, NULL, '2021-04-06 08:45:05', '2021-04-06 08:45:05', NULL),
(39, 'kfkfk', 2, 'single', 1, 1, 1, NULL, 'inclusive', 0, 34, 'd9765dbdd130529', NULL, NULL, 'EAN13', 2, NULL, '2021-04-06 08:59:06', '2021-04-06 08:59:06', NULL),
(43, 'fdgdf', 2, 'single', 1, 1, 1, NULL, 'inclusive', 0, 44, 'e44973c77fc5013', NULL, NULL, 'EAN13', 2, NULL, '2021-04-06 09:07:18', '2021-04-06 09:07:18', NULL),
(44, 'bnnbnnb', 2, 'single', 1, 1, 1, NULL, 'inclusive', 0, 67, 'bf00298aabdfbd4', NULL, NULL, 'EAN13', 2, NULL, '2021-04-06 09:14:17', '2021-04-06 09:14:17', NULL),
(45, 'Item 2', 2, 'single', 1, 15, 2, NULL, 'inclusive', 0, 23, 'ggggg', NULL, NULL, 'EAN13', 2, NULL, '2021-04-10 05:01:19', '2021-04-10 05:01:19', NULL),
(46, 'new one', 2, 'single', 1, 16, 2, NULL, 'inclusive', 0, 45, 'c40b7d37251224f', NULL, NULL, 'C128', 2, NULL, '2021-04-13 23:15:33', '2021-04-13 23:15:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sub_sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_price` decimal(20,2) NOT NULL,
  `sell_price` decimal(20,2) NOT NULL,
  `tax` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `name`, `product_id`, `sub_sku`, `variation_id`, `purchase_price`, `sell_price`, `tax`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'jjrr', 4, 'fcb24', NULL, '600.00', '680.00', 2, '2021-04-05 06:35:16', '2021-04-23 10:47:36', NULL),
(5, 'xyzAbc', 6, '4aac085a984dcec', NULL, '500.00', '550.00', 2, '2021-04-05 07:11:17', '2021-04-05 07:11:17', NULL),
(6, 'acv', 11, 'e02bc4cfdda52f6-1', NULL, '520.00', '540.00', 2, '2021-04-05 07:27:36', '2021-04-05 07:27:36', NULL),
(7, 'acb', 11, 'e02bc4cfdda52f6-2', NULL, '520.00', '540.00', 2, '2021-04-05 07:27:36', '2021-04-05 07:27:36', NULL),
(8, 'jkhujklhgg', 12, '34444', NULL, '252.00', '300.00', 2, '2021-04-06 05:44:05', '2021-04-06 05:44:05', NULL),
(21, 'jdjdj', 35, 'cb90382a74b64ee', NULL, '223.00', '2222.00', 2, '2021-04-06 08:45:06', '2021-04-06 08:45:06', NULL),
(25, 'kfkfk', 39, 'd9765dbdd130529', NULL, '234.00', '555.00', 3, '2021-04-06 08:59:06', '2021-04-06 08:59:06', NULL),
(29, 'fdgdf', 43, 'e44973c77fc5013', NULL, '44.00', '66.00', 4, '2021-04-06 09:07:18', '2021-04-06 09:07:18', NULL),
(30, 'bnnbnnb', 44, 'bf00298aabdfbd4', NULL, '678.00', '6789.00', 8, '2021-04-06 09:14:18', '2021-04-06 09:14:18', NULL),
(31, 'Item 2', 45, 'ggggg', NULL, '234.00', '456.00', 2, '2021-04-10 05:01:19', '2021-04-10 05:01:19', NULL),
(32, 'new one', 46, 'c40b7d37251224f', NULL, '520.00', '236.00', 2, '2021-04-13 23:15:33', '2021-04-13 23:15:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_location_id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_status` enum('received','pending','ordered','draft','final') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `total_purchase_quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal_cost` decimal(20,2) DEFAULT NULL,
  `purchase_discount` decimal(20,2) DEFAULT 0.00,
  `purchase_tax` decimal(20,2) DEFAULT NULL,
  `total_cost` decimal(20,2) DEFAULT NULL,
  `shipping_charge` decimal(20,2) DEFAULT NULL,
  `shipping_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('paid','due','partial') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `business_location_id`, `contact_id`, `purchase_status`, `purchase_date`, `total_purchase_quantity`, `subtotal_cost`, `purchase_discount`, `purchase_tax`, `total_cost`, `shipping_charge`, `shipping_details`, `payment_status`, `note`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(16, 1, 1, 'received', '2021-04-20', '0', '250800.00', '344.00', '2.00', '255472.00', '233.00', NULL, NULL, NULL, 2, 2, '2021-04-20 01:09:33', '2021-05-25 01:19:43', NULL),
(17, 1, 1, 'final', '2021-04-30', '23', '170399.20', '200.00', '5.00', '178719.16', '0.00', NULL, NULL, NULL, 2, 2, '2021-04-30 10:31:15', '2021-05-23 23:34:56', NULL),
(18, 1, 1, 'received', '2021-04-30', '6', '80280.00', '20.00', '1.00', '81062.80', NULL, NULL, NULL, NULL, 2, 2, '2021-04-30 10:34:11', '2021-04-30 10:34:11', NULL),
(19, 2, 1, 'received', '2021-04-30', '5', '75000.00', NULL, NULL, '75000.00', NULL, NULL, NULL, NULL, 2, 2, '2021-04-30 10:35:58', '2021-04-30 10:35:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_variation_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(11) DEFAULT NULL,
  `purchase_quantity` decimal(20,2) DEFAULT NULL,
  `returned_quantity` decimal(20,2) DEFAULT NULL,
  `purchase_price` decimal(20,2) DEFAULT NULL,
  `discount` decimal(20,2) DEFAULT NULL,
  `tax` decimal(20,2) DEFAULT NULL,
  `total_price` decimal(20,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `product_variation_id`, `unit_id`, `purchase_quantity`, `returned_quantity`, `purchase_price`, `discount`, `tax`, `total_price`, `created_at`, `updated_at`) VALUES
(21, 16, 6, 5, 1, '30.00', '15.00', '500.00', NULL, NULL, '150000.00', '2021-04-20 01:09:33', '2021-05-25 01:19:43'),
(22, 16, 4, 3, 1, '40.00', '12.00', '600.00', NULL, NULL, '100800.00', '2021-04-20 01:09:33', '2021-05-23 23:20:34'),
(23, 17, 11, 6, 1, '5.00', NULL, '480.00', NULL, NULL, '158200.00', '2021-04-30 10:31:15', '2021-05-23 23:34:56'),
(24, 18, 35, 21, 1, '6.00', NULL, '223.00', NULL, NULL, '80280.00', '2021-04-30 10:34:11', '2021-04-30 10:34:11'),
(25, 19, 6, 5, 3, '5.00', NULL, '250.00', '0.00', '50.00', '75000.00', '2021-04-30 10:35:58', '2021-04-30 10:35:58'),
(29, 17, 11, 7, 1, '23.00', NULL, '520.00', '0.00', '46.00', '12199.20', '2021-05-23 23:34:56', '2021-05-23 23:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_location_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','sent','completed') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quotation_date` date DEFAULT NULL,
  `subtotal_cost` decimal(20,2) DEFAULT NULL,
  `discount` decimal(20,2) DEFAULT NULL,
  `tax` decimal(20,2) DEFAULT NULL,
  `total_cost` decimal(20,2) DEFAULT NULL,
  `shipping_cost` decimal(20,2) DEFAULT NULL,
  `shipping_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `business_location_id`, `customer_id`, `supplier_id`, `status`, `quotation_date`, `subtotal_cost`, `discount`, `tax`, `total_cost`, `shipping_cost`, `shipping_details`, `note`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 1, 2, 1, 'pending', '1970-01-01', '18662.40', '455.00', '3.00', '18812.27', '45.00', NULL, 'fsdfdsfs', 2, 2, '2021-05-24 00:01:49', '2021-05-24 00:29:23', NULL),
(10, 1, 2, 1, 'sent', '2021-05-25', '3000.00', '50.00', '2.00', '3010.00', NULL, NULL, NULL, 2, 2, '2021-05-25 01:38:44', '2021-05-25 01:38:44', NULL),
(11, 2, 2, 1, 'pending', '2021-05-25', '2500.00', NULL, '3.00', '2575.00', NULL, NULL, 'nice', 2, 2, '2021-05-25 03:21:21', '2021-05-25 03:21:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

CREATE TABLE `quotation_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(20,2) DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `unit_price` decimal(20,2) DEFAULT NULL,
  `discount` decimal(20,2) DEFAULT NULL,
  `tax` decimal(20,2) DEFAULT NULL,
  `total_price` decimal(20,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotation_items`
--

INSERT INTO `quotation_items` (`id`, `quotation_id`, `product_id`, `variation_id`, `quantity`, `unit_id`, `unit_price`, `discount`, `tax`, `total_price`, `created_at`, `updated_at`) VALUES
(6, 9, 11, 6, '6.00', 1, '520.00', '0.00', '12.00', '3182.40', '2021-05-24 00:01:49', '2021-05-24 00:27:29'),
(7, 9, 4, 3, '23.00', 1, '600.00', '0.00', '46.00', '14076.00', '2021-05-24 00:01:49', '2021-05-24 00:26:47'),
(12, 9, 39, 25, '6.00', 1, '234.00', '0.00', '0.00', '1404.00', '2021-05-24 00:29:23', '2021-05-24 00:29:23'),
(13, 10, 6, 5, '6.00', 1, '500.00', '0.00', '0.00', '3000.00', '2021-05-25 01:38:44', '2021-05-25 01:38:44'),
(14, 11, 6, 5, '5.00', 1, '500.00', '0.00', '0.00', '2500.00', '2021-05-25 03:21:21', '2021-05-25 03:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `business_id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 2, 'Admin', 'api', '2021-04-24 00:58:03', '2021-04-24 00:58:03'),
(2, 2, 'Accountant', 'api', '2021-04-26 01:14:56', '2021-04-26 01:14:56'),
(3, 2, 'Emloyee', 'api', '2021-04-26 01:15:09', '2021-04-26 01:15:09');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(26, 3),
(27, 1),
(27, 3),
(28, 1),
(28, 3),
(29, 1),
(29, 3),
(30, 1),
(30, 3),
(31, 1),
(31, 3),
(32, 1),
(32, 3),
(33, 1),
(34, 1),
(35, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale_purchase_returns`
--

CREATE TABLE `sale_purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED DEFAULT NULL,
  `business_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(20,2) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sells`
--

CREATE TABLE `sells` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `business_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_cost` decimal(20,2) DEFAULT NULL,
  `sell_status` enum('completed','pending','final') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_sell_quantity` decimal(20,2) DEFAULT NULL,
  `subtotal_cost` decimal(20,2) DEFAULT NULL,
  `sell_tax` decimal(20,2) DEFAULT NULL,
  `sell_discount` decimal(20,2) DEFAULT 0.00,
  `total_cost` decimal(20,2) DEFAULT NULL,
  `payment_status` enum('paid','due','partial','pending') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sell_date` date DEFAULT NULL,
  `sell_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sells`
--

INSERT INTO `sells` (`id`, `ref_no`, `contact_id`, `business_location_id`, `shipping_cost`, `sell_status`, `total_sell_quantity`, `subtotal_cost`, `sell_tax`, `sell_discount`, `total_cost`, `payment_status`, `sell_date`, `sell_note`, `staff_note`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, NULL, 2, 1, '45.00', 'final', '21.00', '11798.13', '2.00', '45.00', '12034.09', NULL, '2021-06-14', 'yjujj', NULL, 2, 2, '2021-05-24 01:37:47', '2021-05-24 04:35:38', NULL),
(12, NULL, 2, 2, NULL, 'final', '5.00', '2750.00', NULL, NULL, '2750.00', NULL, '2021-05-25', NULL, NULL, 2, 2, '2021-05-25 00:43:17', '2021-05-25 00:43:17', NULL),
(13, NULL, 2, 1, NULL, 'final', '3.00', '1650.00', NULL, NULL, '1650.00', NULL, '2021-05-25', NULL, NULL, 2, 2, '2021-05-25 00:44:28', '2021-05-25 00:44:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sell_items`
--

CREATE TABLE `sell_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sell_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `sell_quantity` decimal(20,2) DEFAULT NULL,
  `returned_quantity` decimal(20,2) DEFAULT NULL,
  `discount` decimal(20,2) DEFAULT NULL,
  `total_price` decimal(20,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sell_items`
--

INSERT INTO `sell_items` (`id`, `sell_id`, `product_id`, `variation_id`, `unit_id`, `sell_quantity`, `returned_quantity`, `discount`, `total_price`, `created_at`, `updated_at`) VALUES
(3, 10, 11, 6, 1, '9.00', NULL, '0.00', '5056.34', '2021-05-24 01:37:47', '2021-05-24 04:35:38'),
(5, 12, 6, 5, 1, '5.00', NULL, '0.00', '2750.00', '2021-05-25 00:43:17', '2021-05-25 00:43:17'),
(6, 13, 6, 5, 1, '3.00', NULL, '0.00', '1650.00', '2021-05-25 00:44:28', '2021-05-25 00:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `sell_purchase_returns`
--

CREATE TABLE `sell_purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED DEFAULT NULL,
  `business_location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_id` bigint(20) DEFAULT NULL,
  `returnable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returnable_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `return_quantity` decimal(20,2) DEFAULT NULL,
  `total_amount` decimal(20,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sell_purchase_returns`
--

INSERT INTO `sell_purchase_returns` (`id`, `business_id`, `business_location_id`, `contact_id`, `returnable_type`, `returnable_id`, `product_id`, `variation_id`, `return_quantity`, `total_amount`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(22, 2, 1, NULL, 'App\\Models\\Purchase', 16, 4, 3, '10.00', '25200.00', 2, NULL, '2021-04-20 01:10:21', '2021-04-20 01:10:21'),
(23, 2, 1, NULL, 'App\\Models\\Purchase', 16, 6, 5, '5.00', '15000.00', 2, NULL, '2021-04-20 01:10:57', '2021-04-20 01:10:57'),
(24, 2, 1, NULL, 'App\\Models\\Purchase', 16, 4, 3, '2.00', '5040.00', 2, NULL, '2021-04-20 01:11:23', '2021-04-20 01:11:23'),
(25, 2, 1, 2, 'App\\Models\\Sell', 3, 6, 5, '1.00', '583.00', 2, NULL, '2021-04-20 04:24:12', '2021-04-20 04:24:12'),
(26, 2, 1, 2, 'App\\Models\\Sell', 3, 4, 3, '1.00', '761.60', 2, NULL, '2021-04-20 04:28:28', '2021-04-20 04:28:28'),
(27, 2, 1, 1, 'App\\Models\\Purchase', 16, 6, 5, '10.00', '30000.00', 2, NULL, '2021-05-04 02:30:24', '2021-05-04 02:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `from_location` bigint(20) UNSIGNED NOT NULL,
  `to_location` bigint(20) UNSIGNED NOT NULL,
  `ref_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfers`
--

INSERT INTO `stock_transfers` (`id`, `business_id`, `from_location`, `to_location`, `ref_no`, `status`, `shipping_cost`, `note`, `total`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 2, 1, 2, '345678', 'Complete', '200', 'hello', NULL, 2, 2, '2021-05-25 06:03:28', '2021-04-15 04:24:57', '2021-05-25 06:03:28'),
(7, 2, 1, 2, '3555', 'Complete', '23', NULL, '692', 2, 2, NULL, '2021-04-16 03:37:05', '2021-04-16 03:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_items`
--

CREATE TABLE `stock_transfer_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(20,2) NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `unit_price` decimal(20,2) NOT NULL,
  `subtotal` decimal(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfer_items`
--

INSERT INTO `stock_transfer_items` (`id`, `stock_transfer_id`, `product_id`, `variation_id`, `quantity`, `unit_id`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES
(4, 4, 44, 30, '5.00', 1, '678.00', '3390.00', '2021-04-15 04:24:57', '2021-04-15 04:24:57'),
(7, 7, 35, 21, '5.00', 1, '223.00', '669.00', '2021-04-16 03:37:05', '2021-05-27 01:07:32');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('purchase','sell','expense','stock_adjustment','sell_transfer','purchase_transfer','opening_stock','sell_return','opening_balance') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('received','pending','ordered','draft','final') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` enum('paid','due','partial') COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_group_id` int(11) DEFAULT NULL COMMENT 'used to add customer group while selling',
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` datetime NOT NULL,
  `total_before_tax` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Total before the purchase/invoice tax, this includeds the indivisual product tax',
  `tax_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` enum('fixed','percentage') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_charges` decimal(8,2) NOT NULL DEFAULT 0.00,
  `additional_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_direct_sale` tinyint(1) NOT NULL DEFAULT 0,
  `is_suspend` tinyint(1) NOT NULL DEFAULT 0,
  `expense_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `final_total` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `order_addresses` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_payments`
--

CREATE TABLE `transaction_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_return` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Used during sales to return the change',
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `method` enum('cash','card','cheque','bank_transfer','custom_pay_1','custom_pay_2','custom_pay_3','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_transaction_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` enum('visa','master') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_month` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_security` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_ref_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `operator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` decimal(20,2) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `business_id`, `name`, `short_name`, `parent_id`, `operator`, `value`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'KG', 'kg', 0, NULL, NULL, NULL, '2021-04-05 06:23:52', '2021-04-05 06:23:52'),
(2, 2, 'Ltr', 'Ltr', 0, NULL, NULL, NULL, '2021-04-13 08:22:13', '2021-04-13 08:22:13'),
(3, 2, 'Mon', 'mon', 1, NULL, '40.00', NULL, '2021-04-26 23:02:41', '2021-04-26 23:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `surname`, `first_name`, `last_name`, `username`, `email`, `password`, `language`, `remember_token`, `business_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'MR', 'Imtiaz', 'ahmed', 'admin', 'admin@gmail.com', '$2y$10$P6x6mV/B9hIv7YHXyOxLae/gNsjXIZ02g/sIR6VoZLCWzXSqBZMPG', 'en', NULL, 1, NULL, NULL, '2021-04-04 23:16:01'),
(2, '', 'imtiaz', 'ahmed', 'imtiaz', 'imtiaz@gmail.com', '$2y$10$UZvzEYNrqMRvktitd00sieNJqTQDZRHkXKek7TNRajOpDWvNTsHhy', 'en', NULL, 2, NULL, '2021-04-05 00:08:47', '2021-04-05 00:08:47'),
(3, 'mr', 'azmin', 'khan', 'erty', 'azmin@gmail.com', '$2y$10$wakwQncuLs5lSIJkiccSZe0xFcOpw7jCfg7h41Qwq/T9uohKd6uYO', 'en', NULL, 2, NULL, '2021-04-26 01:17:05', '2021-04-26 01:17:05'),
(4, 'Miss', 'Layla', 'khatun', 'Layla', 'layla@gm.com', '$2y$10$DNuNsRFxOEbMlqANRWLkNerf/D0hMaCu2hbJtYASPhlzJTSdrH.vG', 'en', NULL, 2, NULL, '2021-04-26 01:18:14', '2021-04-26 01:18:14'),
(5, 'mr', 'abcd', 'xyz', 'raj_01', 'raj@gmail.com', '$2y$10$SRRqGUxR1GKqHo0HdDhNiO5A2YL4rxgq5Xtjt9r8l1eCA4h/kusFC', 'en', NULL, 2, NULL, '2021-05-05 23:06:16', '2021-05-05 23:06:16');

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variation_location_details`
--

CREATE TABLE `variation_location_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_variation_id` int(10) UNSIGNED NOT NULL COMMENT 'id from product_variations table',
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `qty_available` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_business_id_foreign` (`business_id`);

--
-- Indexes for table `account_transactions`
--
ALTER TABLE `account_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barcodes`
--
ALTER TABLE `barcodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barcodes_business_id_foreign` (`business_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_business_id_foreign` (`business_id`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_owner_id_foreign` (`owner_id`),
  ADD KEY `business_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `business_locations`
--
ALTER TABLE `business_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_locations_business_id_index` (`business_id`);

--
-- Indexes for table `business_location_user`
--
ALTER TABLE `business_location_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_location_user_business_location_id_foreign` (`business_location_id`),
  ADD KEY `business_location_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_business_id_foreign` (`business_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_business_id_foreign` (`business_id`),
  ADD KEY `contacts_created_by_foreign` (`created_by`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_groups_business_id_foreign` (`business_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_business_id_foreign` (`business_id`),
  ADD KEY `expenses_created_by_foreign` (`created_by`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_categories_business_id_foreign` (`business_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_fileable_type_fileable_id_index` (`fileable_type`,`fileable_id`),
  ADD KEY `files_business_id_foreign` (`business_id`);

--
-- Indexes for table `location_product_stocks`
--
ALTER TABLE `location_product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_product_stocks_business_id_foreign` (`business_id`),
  ADD KEY `location_product_stocks_product_id_index` (`product_id`),
  ADD KEY `location_product_stocks_location_id_index` (`location_id`),
  ADD KEY `location_product_stocks_product_variation_id_index` (`product_variation_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `opening_stock_qties`
--
ALTER TABLE `opening_stock_qties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opening_stock_qties_business_id_foreign` (`business_id`),
  ADD KEY `opening_stock_qties_business_location_id_foreign` (`business_location_id`),
  ADD KEY `opening_stock_qties_product_id_foreign` (`product_id`),
  ADD KEY `opening_stock_qties_created_by_foreign` (`created_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_paymentable_type_paymentable_id_index` (`paymentable_type`,`paymentable_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `products_updated_by_foreign` (`updated_by`),
  ADD KEY `products_name_index` (`name`),
  ADD KEY `products_business_id_index` (`business_id`),
  ADD KEY `products_unit_id_index` (`unit_id`),
  ADD KEY `products_created_by_index` (`created_by`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variations_name_index` (`name`),
  ADD KEY `product_variations_product_id_index` (`product_id`),
  ADD KEY `product_variations_variation_id_foreign` (`variation_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_business_location_id_foreign` (`business_location_id`),
  ADD KEY `purchases_contact_id_foreign` (`contact_id`),
  ADD KEY `purchases_created_by_foreign` (`created_by`),
  ADD KEY `purchases_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_items_product_id_foreign` (`product_id`),
  ADD KEY `purchase_items_product_variation_id_foreign` (`product_variation_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_business_location_id_foreign` (`business_location_id`),
  ADD KEY `quotations_customer_id_foreign` (`customer_id`),
  ADD KEY `quotations_supplier_id_foreign` (`supplier_id`),
  ADD KEY `quotations_created_by_foreign` (`created_by`),
  ADD KEY `quotations_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_items_quotation_id_foreign` (`quotation_id`),
  ADD KEY `quotation_items_product_id_foreign` (`product_id`),
  ADD KEY `quotation_items_variation_id_foreign` (`variation_id`),
  ADD KEY `quotation_items_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `roles_business_id_foreign` (`business_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sale_purchase_returns`
--
ALTER TABLE `sale_purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_purchase_returns_business_id_foreign` (`business_id`),
  ADD KEY `sale_purchase_returns_business_location_id_foreign` (`business_location_id`),
  ADD KEY `sale_purchase_returns_purchase_id_foreign` (`purchase_id`),
  ADD KEY `sale_purchase_returns_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_purchase_returns_product_id_foreign` (`product_id`),
  ADD KEY `sale_purchase_returns_created_by_foreign` (`created_by`),
  ADD KEY `sale_purchase_returns_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sells`
--
ALTER TABLE `sells`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sells_ref_no_unique` (`ref_no`),
  ADD KEY `sells_contact_id_foreign` (`contact_id`),
  ADD KEY `sells_business_location_id_foreign` (`business_location_id`),
  ADD KEY `sells_created_by_foreign` (`created_by`),
  ADD KEY `sells_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sell_items`
--
ALTER TABLE `sell_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sell_items_sell_id_foreign` (`sell_id`),
  ADD KEY `sell_items_product_id_foreign` (`product_id`),
  ADD KEY `sell_items_variation_id_foreign` (`variation_id`),
  ADD KEY `sell_items_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `sell_purchase_returns`
--
ALTER TABLE `sell_purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sell_purchase_returns_business_id_foreign` (`business_id`),
  ADD KEY `sell_purchase_returns_business_location_id_foreign` (`business_location_id`),
  ADD KEY `sell_purchase_returns_returnable_type_returnable_id_index` (`returnable_type`,`returnable_id`),
  ADD KEY `sell_purchase_returns_product_id_foreign` (`product_id`),
  ADD KEY `sell_purchase_returns_variation_id_foreign` (`variation_id`),
  ADD KEY `sell_purchase_returns_created_by_foreign` (`created_by`),
  ADD KEY `sell_purchase_returns_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfers_business_id_foreign` (`business_id`),
  ADD KEY `stock_transfers_from_location_foreign` (`from_location`),
  ADD KEY `stock_transfers_to_location_foreign` (`to_location`),
  ADD KEY `stock_transfers_created_by_foreign` (`created_by`),
  ADD KEY `stock_transfers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `stock_transfer_items`
--
ALTER TABLE `stock_transfer_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfer_items_stock_transfer_id_foreign` (`stock_transfer_id`),
  ADD KEY `stock_transfer_items_product_id_foreign` (`product_id`),
  ADD KEY `stock_transfer_items_variation_id_foreign` (`variation_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_business_id_index` (`business_id`),
  ADD KEY `transactions_location_id_index` (`location_id`),
  ADD KEY `transactions_type_index` (`type`),
  ADD KEY `transactions_contact_id_index` (`contact_id`),
  ADD KEY `transactions_transaction_date_index` (`transaction_date`),
  ADD KEY `transactions_expense_category_id_index` (`expense_category_id`),
  ADD KEY `transactions_created_by_index` (`created_by`);

--
-- Indexes for table `transaction_payments`
--
ALTER TABLE `transaction_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_payments_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_payments_created_by_index` (`created_by`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_business_id_foreign` (`business_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_business_id_foreign` (`business_id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variations_business_id_foreign` (`business_id`);

--
-- Indexes for table `variation_location_details`
--
ALTER TABLE `variation_location_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variation_location_details_location_id_foreign` (`location_id`),
  ADD KEY `variation_location_details_product_id_index` (`product_id`),
  ADD KEY `variation_location_details_product_variation_id_index` (`product_variation_id`),
  ADD KEY `variation_location_details_variation_id_index` (`variation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_transactions`
--
ALTER TABLE `account_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barcodes`
--
ALTER TABLE `barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `business_locations`
--
ALTER TABLE `business_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `business_location_user`
--
ALTER TABLE `business_location_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `location_product_stocks`
--
ALTER TABLE `location_product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `opening_stock_qties`
--
ALTER TABLE `opening_stock_qties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_purchase_returns`
--
ALTER TABLE `sale_purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sells`
--
ALTER TABLE `sells`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sell_items`
--
ALTER TABLE `sell_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sell_purchase_returns`
--
ALTER TABLE `sell_purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stock_transfer_items`
--
ALTER TABLE `stock_transfer_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_payments`
--
ALTER TABLE `transaction_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variation_location_details`
--
ALTER TABLE `variation_location_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barcodes`
--
ALTER TABLE `barcodes`
  ADD CONSTRAINT `barcodes_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business`
--
ALTER TABLE `business`
  ADD CONSTRAINT `business_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `business_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_locations`
--
ALTER TABLE `business_locations`
  ADD CONSTRAINT `business_locations_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_location_user`
--
ALTER TABLE `business_location_user`
  ADD CONSTRAINT `business_location_user_business_location_id_foreign` FOREIGN KEY (`business_location_id`) REFERENCES `business_locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_location_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contacts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD CONSTRAINT `customer_groups_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD CONSTRAINT `expense_categories_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `location_product_stocks`
--
ALTER TABLE `location_product_stocks`
  ADD CONSTRAINT `location_product_stocks_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `location_product_stocks_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `business_locations` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `opening_stock_qties`
--
ALTER TABLE `opening_stock_qties`
  ADD CONSTRAINT `opening_stock_qties_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opening_stock_qties_business_location_id_foreign` FOREIGN KEY (`business_location_id`) REFERENCES `business_locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opening_stock_qties_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `opening_stock_qties_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_business_location_id_foreign` FOREIGN KEY (`business_location_id`) REFERENCES `business_locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_items_product_variation_id_foreign` FOREIGN KEY (`product_variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_business_location_id_foreign` FOREIGN KEY (`business_location_id`) REFERENCES `business_locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD CONSTRAINT `quotation_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotation_items_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotation_items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotation_items_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_purchase_returns`
--
ALTER TABLE `sale_purchase_returns`
  ADD CONSTRAINT `sale_purchase_returns_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_purchase_returns_business_location_id_foreign` FOREIGN KEY (`business_location_id`) REFERENCES `business_locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_purchase_returns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_purchase_returns_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_purchase_returns_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_purchase_returns_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_purchase_returns_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sells`
--
ALTER TABLE `sells`
  ADD CONSTRAINT `sells_business_location_id_foreign` FOREIGN KEY (`business_location_id`) REFERENCES `business_locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sells_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sells_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sells_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sell_items`
--
ALTER TABLE `sell_items`
  ADD CONSTRAINT `sell_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sell_items_sell_id_foreign` FOREIGN KEY (`sell_id`) REFERENCES `sells` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sell_items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sell_items_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sell_purchase_returns`
--
ALTER TABLE `sell_purchase_returns`
  ADD CONSTRAINT `sell_purchase_returns_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sell_purchase_returns_business_location_id_foreign` FOREIGN KEY (`business_location_id`) REFERENCES `business_locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sell_purchase_returns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sell_purchase_returns_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sell_purchase_returns_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sell_purchase_returns_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD CONSTRAINT `stock_transfers_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transfers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transfers_from_location_foreign` FOREIGN KEY (`from_location`) REFERENCES `business_locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transfers_to_location_foreign` FOREIGN KEY (`to_location`) REFERENCES `business_locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transfers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transfer_items`
--
ALTER TABLE `stock_transfer_items`
  ADD CONSTRAINT `stock_transfer_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transfer_items_stock_transfer_id_foreign` FOREIGN KEY (`stock_transfer_id`) REFERENCES `stock_transfers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transfer_items_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `business_locations` (`id`);

--
-- Constraints for table `transaction_payments`
--
ALTER TABLE `transaction_payments`
  ADD CONSTRAINT `transaction_payments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variations`
--
ALTER TABLE `variations`
  ADD CONSTRAINT `variations_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variation_location_details`
--
ALTER TABLE `variation_location_details`
  ADD CONSTRAINT `variation_location_details_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `business_locations` (`id`),
  ADD CONSTRAINT `variation_location_details_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
