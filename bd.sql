-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.15-log - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para bd_app_inventario
CREATE DATABASE IF NOT EXISTS `bd_app_inventario` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `bd_app_inventario`;

-- Volcando estructura para tabla bd_app_inventario.business
CREATE TABLE IF NOT EXISTS `business` (
  `id_business` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `document_type` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `document_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `bd` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_business`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.business: ~2 rows (aproximadamente)
INSERT INTO `business` (`id_business`, `document_type`, `document_number`, `name`, `bd`, `state`, `created_at`, `updated_at`) VALUES
	(1, '6', '20601249431', 'OPERADORES DUTY FREE SAC', 'operadores', 1, '2021-06-22 23:00:38', '2021-09-12 15:53:21'),
	(2, '6', '20601249511', 'INVERSIONES DPG SAC', 'inversiones', 1, '2021-08-18 19:42:47', '2021-08-17 19:42:47');

-- Volcando estructura para tabla bd_app_inventario.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla bd_app_inventario.categories: ~1 rows (aproximadamente)
INSERT INTO `categories` (`id_category`, `name`, `state`, `created_at`, `updated_at`) VALUES
	(1, 'test', 1, '2023-06-07 01:35:21', '2023-06-07 01:35:21');

-- Volcando estructura para tabla bd_app_inventario.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `document_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.clients: ~24 rows (aproximadamente)
INSERT INTO `clients` (`id_client`, `document_type`, `document_number`, `name`, `email`, `phone`, `state`, `created_at`, `updated_at`) VALUES
	(1, '1', '00000000', 'CLEINTES VARIOS', '', '', 1, '2022-08-24 01:35:46', '2022-08-24 01:35:46'),
	(2, '1', '', 'HILDA CONDORI', '', '', 1, '2022-08-25 21:22:10', '2022-08-25 21:22:10'),
	(3, '1', '', 'CELIA ANQUISE', '', '', 1, '2022-08-25 22:15:49', '2022-08-25 22:15:49'),
	(4, '1', '', 'BENITO PAUCAR', '', '', 1, '2022-08-25 22:16:35', '2022-08-25 22:16:35'),
	(5, '1', '', 'GUILLERMINA CRUZ', '', '', 1, '2022-08-25 22:17:41', '2022-08-25 22:17:41'),
	(6, '1', '', 'EMERITA MAMANI', '', '', 1, '2022-08-25 22:23:11', '2022-08-25 22:23:11'),
	(7, '1', '', 'ELSA CRUZ', '', '', 1, '2022-08-25 22:25:01', '2022-08-25 22:25:01'),
	(8, '1', '', 'ALEX GARCIA', '', '', 1, '2022-08-25 22:26:26', '2022-08-25 22:26:26'),
	(9, '1', '', 'CARLOS CRUZ', '', '', 1, '2022-08-25 22:27:43', '2022-08-25 22:27:43'),
	(10, '1', '', 'VERONICA ESCARCENA', '', '', 1, '2022-08-25 22:28:37', '2022-08-25 22:28:37'),
	(11, '1', '', 'CECILIA MAQUERA', '', '', 1, '2022-08-25 22:33:28', '2022-08-25 22:33:28'),
	(12, '1', '', 'ACUMULADO JULIO 2022', '', '', 1, '2022-08-26 22:29:18', '2022-08-26 22:29:18'),
	(13, '0', '', 'USAR', '', '', 1, '2022-09-26 21:12:00', '2022-09-26 21:14:59'),
	(14, '1', '', 'JORGE CHAMBILLA', '', '', 1, '2022-09-26 21:19:52', '2022-09-26 21:38:23'),
	(15, '1', '', 'APOLIAR POLLOQUERI', '', '', 1, '2022-09-26 21:24:53', '2022-09-26 21:24:53'),
	(16, '1', '', 'LUCENIA ', '', '', 1, '2022-09-26 21:31:29', '2022-09-26 21:31:29'),
	(17, '1', '', 'GILDA CENTENO', '', '', 1, '2022-10-06 14:32:51', '2022-10-06 14:32:51'),
	(18, '1', '', 'ANA CANO', '', '', 1, '2022-10-21 21:23:00', '2022-10-21 21:23:00'),
	(19, '1', '', 'JUDIT MACEDO', '', '', 1, '2022-11-02 16:47:57', '2022-11-02 16:47:57'),
	(20, '1', '', 'ROSA MARIA SALCEDO', '', '', 1, '2022-11-18 15:57:54', '2022-11-18 15:57:54'),
	(21, '1', '', 'MABEL SIÑA', '', '', 1, '2022-11-21 16:27:11', '2022-11-21 16:27:11'),
	(22, '1', '', 'ELIZABETH CHAMBILLA', '', '', 1, '2022-12-15 17:44:27', '2022-12-15 17:44:27'),
	(23, '1', '', 'PARA CUADRE DE DINERO', '', '', 1, '2022-12-17 23:03:35', '2022-12-17 23:03:35'),
	(24, '1', '', 'SRA. FANNY', '', '', 1, '2023-03-23 21:37:11', '2023-03-23 21:37:11');

-- Volcando estructura para tabla bd_app_inventario.correlatives
CREATE TABLE IF NOT EXISTS `correlatives` (
  `id_correlative` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `num` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_correlative`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.correlatives: ~8 rows (aproximadamente)
INSERT INTO `correlatives` (`id_correlative`, `module`, `number`, `num`, `state`, `created_at`, `updated_at`) VALUES
	(6, 'ManagementExpense', '00001829', 1829, 1, '2022-07-26 05:23:40', '2023-06-01 13:59:57'),
	(7, 'ManagementIncome', '00001027', 1027, 1, '2022-07-26 05:23:40', '2023-06-03 15:29:59'),
	(8, 'ManagementUtility', '00001001', 1001, 1, '2022-07-26 05:23:40', '2022-07-30 23:16:01'),
	(9, 'Income', '00001033', 1033, 1, '2022-07-26 05:23:40', '2023-05-04 14:21:49'),
	(10, 'Expense', '00001136', 1136, 1, '2022-07-26 05:23:40', '2023-05-04 14:35:06'),
	(11, 'DailySettlementExpense', '00001141', 1141, 1, '2022-07-26 05:23:40', '2022-11-03 13:26:06'),
	(12, 'DailySettlementIncome', '00001022', 1022, 1, '2022-07-26 05:23:40', '2023-05-04 14:18:36'),
	(13, 'AccountReceivableExpense', '00001058', 1058, 1, '0000-00-00 00:00:00', '2023-05-29 16:41:41');

-- Volcando estructura para tabla bd_app_inventario.kardex_movement
CREATE TABLE IF NOT EXISTS `kardex_movement` (
  `id_kardex` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) DEFAULT NULL,
  `id_module` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `broadcast_date` date DEFAULT NULL,
  `type_operation` varchar(10) DEFAULT NULL,
  `type_invoice` varchar(10) DEFAULT NULL,
  `serie` varchar(10) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `movement_type` varchar(50) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kardex`),
  KEY `id_product` (`id_product`),
  KEY `id_module` (`id_module`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_app_inventario.kardex_movement: ~0 rows (aproximadamente)
INSERT INTO `kardex_movement` (`id_kardex`, `module`, `id_module`, `id_product`, `broadcast_date`, `type_operation`, `type_invoice`, `serie`, `number`, `quantity`, `unit_price`, `total_price`, `movement_type`, `state`, `created_at`, `updated_at`) VALUES
	(1, 'Purchase', 1, 3, '2023-06-08', '02', '01', 'f002', '22', 100.00, 10.00, 1000.00, 'Input', 1, '2023-06-08 23:39:57', '2023-06-08 23:39:57'),
	(7, 'Purchase', 3, 3, '2023-06-08', '02', '01', 'f001', '32423', 20.00, 10.00, 200.00, 'Input', 1, '2023-06-09 00:02:37', '2023-06-09 00:02:37'),
	(8, 'Purchase', 3, 2, '2023-06-08', '02', '01', 'f001', '32423', 50.00, 10.00, 500.00, 'Input', 1, '2023-06-09 00:02:37', '2023-06-09 00:02:37'),
	(11, 'Sale', 2, 3, '2023-06-08', '01', '03', 'B001', '00000004', 20.00, 10.00, 200.00, 'Output', 1, '2023-06-09 00:04:13', '2023-06-09 00:04:13'),
	(12, 'Purchase', 4, 3, '2023-06-06', '02', '01', 'f003', '232432', 10.00, 0.00, 0.00, 'Input', 1, '2023-06-09 01:07:47', '2023-06-09 01:07:47'),
	(13, 'Purchase', 4, 2, '2023-06-06', '02', '01', 'f003', '232432', 10.00, 0.00, 0.00, 'Input', 1, '2023-06-09 01:07:47', '2023-06-09 01:07:47'),
	(14, 'Sale', 3, 2, '2023-06-08', '01', '03', 'B001', '00000005', 5.00, 10.00, 50.00, 'Output', 1, '2023-06-09 01:08:15', '2023-06-09 01:08:15');

-- Volcando estructura para tabla bd_app_inventario.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.migrations: ~10 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(3, '2022_07_26_012913_create_management_incomes_table', 1),
	(4, '2022_07_26_013332_create_management_monthly_expenses_table', 2),
	(5, '2022_07_26_013343_create_management_monthly_incomes_table', 2),
	(6, '2022_07_26_220742_create_management_utilities_table', 3),
	(7, '2022_07_29_161019_create_management_utilities_detail_table', 4),
	(8, '2022_08_01_223450_create_daily_settlement_expenses_table', 4),
	(9, '2022_08_03_200822_create_clients_table', 5),
	(10, '2022_08_03_213914_create_accounts_receivable_table', 6),
	(11, '2022_08_07_143134_create_accounts_receivable_payment_table', 7),
	(12, '2022_08_09_033515_create_accounts_receivable_expenses_table', 8);

-- Volcando estructura para tabla bd_app_inventario.privileges
CREATE TABLE IF NOT EXISTS `privileges` (
  `id_privilege` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_privilege`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.privileges: ~5 rows (aproximadamente)
INSERT INTO `privileges` (`id_privilege`, `name`, `role`, `state`, `created_at`, `updated_at`) VALUES
	(1, 'Listar', 'List', 1, '2022-08-18 12:49:31', '2022-08-18 12:49:31'),
	(2, 'Agregar', 'Add', 1, '2022-08-18 12:49:41', '2022-08-18 12:49:42'),
	(3, 'Editar', 'Edit', 1, '2022-08-18 12:49:53', '2022-08-18 12:49:54'),
	(4, 'Eliminar', 'Delete', 1, '2022-08-18 12:50:06', '2022-08-18 12:50:07'),
	(5, 'Ver', 'View', 1, '2022-08-18 12:50:13', '2022-08-18 12:50:14');

-- Volcando estructura para tabla bd_app_inventario.privileges_zones
CREATE TABLE IF NOT EXISTS `privileges_zones` (
  `id_privilege_zone` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user_type` bigint(20) unsigned NOT NULL,
  `id_zone` bigint(20) unsigned NOT NULL,
  `id_privilege` bigint(20) unsigned NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_privilege_zone`),
  KEY `privileges_zones_id_user_type_foreign` (`id_user_type`),
  KEY `privileges_zones_id_zone_foreign` (`id_zone`),
  KEY `privileges_zones_id_privilege_foreign` (`id_privilege`),
  CONSTRAINT `privileges_zones_id_privilege_foreign` FOREIGN KEY (`id_privilege`) REFERENCES `privileges` (`id_privilege`),
  CONSTRAINT `privileges_zones_id_user_type_foreign` FOREIGN KEY (`id_user_type`) REFERENCES `user_type` (`id_user_type`),
  CONSTRAINT `privileges_zones_id_zone_foreign` FOREIGN KEY (`id_zone`) REFERENCES `zones` (`id_zone`)
) ENGINE=InnoDB AUTO_INCREMENT=708 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.privileges_zones: ~239 rows (aproximadamente)
INSERT INTO `privileges_zones` (`id_privilege_zone`, `id_user_type`, `id_zone`, `id_privilege`, `state`, `created_at`, `updated_at`) VALUES
	(406, 2, 4, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(407, 2, 4, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(408, 2, 5, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(409, 2, 5, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(410, 2, 7, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(411, 2, 7, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(412, 2, 6, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(413, 2, 6, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(414, 2, 9, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(415, 2, 9, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(416, 2, 8, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(417, 2, 8, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(418, 2, 2, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(419, 2, 2, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(420, 2, 3, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(421, 2, 3, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(422, 2, 19, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(423, 2, 19, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(424, 2, 15, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(425, 2, 15, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(426, 2, 20, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(427, 2, 20, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(428, 2, 16, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(429, 2, 16, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(430, 2, 18, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(431, 2, 18, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(432, 2, 14, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(433, 2, 14, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(434, 2, 21, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(435, 2, 21, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(436, 2, 17, 1, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(437, 2, 17, 5, 1, '2022-09-08 21:14:16', '2022-09-08 21:14:16'),
	(438, 1, 4, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(439, 1, 4, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(440, 1, 4, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(441, 1, 4, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(442, 1, 4, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(443, 1, 5, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(444, 1, 5, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(445, 1, 5, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(446, 1, 5, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(447, 1, 5, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(448, 1, 7, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(449, 1, 7, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(450, 1, 7, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(451, 1, 7, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(452, 1, 7, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(453, 1, 6, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(454, 1, 6, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(455, 1, 6, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(456, 1, 6, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(457, 1, 6, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(458, 1, 9, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(459, 1, 9, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(460, 1, 9, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(461, 1, 9, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(462, 1, 9, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(463, 1, 8, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(464, 1, 8, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(465, 1, 8, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(466, 1, 8, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(467, 1, 8, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(468, 1, 1, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(469, 1, 1, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(470, 1, 1, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(471, 1, 1, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(472, 1, 1, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(473, 1, 2, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(474, 1, 2, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(475, 1, 2, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(476, 1, 2, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(477, 1, 2, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(478, 1, 3, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(479, 1, 3, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(480, 1, 3, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(481, 1, 3, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(482, 1, 3, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(483, 1, 13, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(484, 1, 13, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(485, 1, 13, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(486, 1, 13, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(487, 1, 13, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(488, 1, 12, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(489, 1, 12, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(490, 1, 12, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(491, 1, 12, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(492, 1, 12, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(493, 1, 22, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(494, 1, 22, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(495, 1, 22, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(496, 1, 22, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(497, 1, 22, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(498, 1, 11, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(499, 1, 11, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(500, 1, 11, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(501, 1, 11, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(502, 1, 11, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(503, 1, 10, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(504, 1, 10, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(505, 1, 10, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(506, 1, 10, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(507, 1, 10, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(508, 1, 19, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(509, 1, 19, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(510, 1, 19, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(511, 1, 19, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(512, 1, 19, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(513, 1, 15, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(514, 1, 15, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(515, 1, 15, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(516, 1, 15, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(517, 1, 15, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(518, 1, 20, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(519, 1, 20, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(520, 1, 20, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(521, 1, 20, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(522, 1, 20, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(523, 1, 16, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(524, 1, 16, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(525, 1, 16, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(526, 1, 16, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(527, 1, 16, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(528, 1, 18, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(529, 1, 18, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(530, 1, 18, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(531, 1, 18, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(532, 1, 18, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(533, 1, 14, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(534, 1, 14, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(535, 1, 14, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(536, 1, 14, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(537, 1, 14, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(538, 1, 21, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(539, 1, 21, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(540, 1, 21, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(541, 1, 21, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(542, 1, 21, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(543, 1, 17, 1, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(544, 1, 17, 2, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(545, 1, 17, 3, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(546, 1, 17, 4, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(547, 1, 17, 5, 1, '2022-12-07 23:40:44', '2022-12-07 23:40:44'),
	(658, 3, 17, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(659, 3, 17, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(660, 3, 17, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(661, 3, 17, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(662, 3, 17, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(663, 3, 13, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(664, 3, 13, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(665, 3, 13, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(666, 3, 13, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(667, 3, 13, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(668, 3, 14, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(669, 3, 14, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(670, 3, 14, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(671, 3, 14, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(672, 3, 14, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(673, 3, 1, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(674, 3, 1, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(675, 3, 1, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(676, 3, 1, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(677, 3, 1, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(678, 3, 19, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(679, 3, 19, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(680, 3, 19, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(681, 3, 19, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(682, 3, 19, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(683, 3, 11, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(684, 3, 11, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(685, 3, 11, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(686, 3, 11, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(687, 3, 11, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(688, 3, 10, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(689, 3, 10, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(690, 3, 10, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(691, 3, 10, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(692, 3, 10, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(693, 3, 16, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(694, 3, 16, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(695, 3, 16, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(696, 3, 16, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(697, 3, 16, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(698, 3, 15, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(699, 3, 15, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(700, 3, 15, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(701, 3, 15, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(702, 3, 15, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(703, 3, 18, 1, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(704, 3, 18, 2, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(705, 3, 18, 3, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(706, 3, 18, 4, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23'),
	(707, 3, 18, 5, 1, '2023-06-09 01:19:23', '2023-06-09 01:19:23');

-- Volcando estructura para tabla bd_app_inventario.products
CREATE TABLE IF NOT EXISTS `products` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(10) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `igv` varchar(3) DEFAULT NULL,
  `unit_measure` varchar(8) DEFAULT NULL,
  `stock` decimal(10,2) DEFAULT '0.00',
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_product`),
  KEY `id_category` (`id_category`),
  CONSTRAINT `FK__categories` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla bd_app_inventario.products: ~2 rows (aproximadamente)
INSERT INTO `products` (`id_product`, `id_category`, `code`, `name`, `barcode`, `igv`, `unit_measure`, `stock`, `purchase_price`, `sale_price`, `state`, `created_at`, `updated_at`) VALUES
	(2, 1, 'qe', 'leche', '234234', '10', '1', 55.00, 20.00, 23.00, 1, '2023-06-07 02:18:01', '2023-06-09 01:08:15'),
	(3, 1, '45345', 'arroz', 'sdfsdf', '10', '2', 110.00, 10.00, 12.00, 1, '2023-06-07 02:24:46', '2023-06-09 01:07:47');

-- Volcando estructura para tabla bd_app_inventario.providers
CREATE TABLE IF NOT EXISTS `providers` (
  `id_provider` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `document_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_provider`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.providers: ~2 rows (aproximadamente)
INSERT INTO `providers` (`id_provider`, `document_type`, `document_number`, `name`, `email`, `phone`, `state`, `created_at`, `updated_at`) VALUES
	(1, '1', '45353453', 'test', '', '', 9, '2023-06-03 22:20:43', '2023-06-03 22:25:20'),
	(2, '1', '45454545', 'test', '', '', 1, '2023-06-03 22:25:29', '2023-06-03 22:25:29');

-- Volcando estructura para tabla bd_app_inventario.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `id_purchase` int(11) NOT NULL AUTO_INCREMENT,
  `id_provider` bigint(20) NOT NULL,
  `type_invoice` varchar(5) DEFAULT NULL,
  `serie` varchar(10) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `broadcast_date` date DEFAULT NULL,
  `coin` varchar(5) DEFAULT NULL,
  `type_operation` varchar(10) DEFAULT NULL,
  `observation` varchar(500) DEFAULT NULL,
  `taxed_operation` decimal(10,2) DEFAULT NULL,
  `exonerated_operation` decimal(10,2) DEFAULT NULL,
  `unaffected_operation` decimal(10,2) DEFAULT NULL,
  `igv` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_purchase`),
  KEY `id_provider` (`id_provider`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_app_inventario.purchases: ~0 rows (aproximadamente)
INSERT INTO `purchases` (`id_purchase`, `id_provider`, `type_invoice`, `serie`, `number`, `broadcast_date`, `coin`, `type_operation`, `observation`, `taxed_operation`, `exonerated_operation`, `unaffected_operation`, `igv`, `total`, `state`, `created_at`, `updated_at`) VALUES
	(1, 2, '01', 'f002', '22', '2023-06-08', 'PEN', '02', '', 847.46, 0.00, 0.00, 152.54, 1000.00, 1, '2023-06-08 23:39:57', '2023-06-08 23:39:57'),
	(2, 2, '01', 'f005', '33', '2023-06-08', 'PEN', '02', '', 169.49, 0.00, 0.00, 30.51, 200.00, 9, '2023-06-08 23:40:23', '2023-06-09 00:02:04'),
	(3, 2, '01', 'f001', '32423', '2023-06-08', 'PEN', '02', '', 593.22, 0.00, 0.00, 106.78, 700.00, 1, '2023-06-09 00:02:37', '2023-06-09 00:02:37'),
	(4, 2, '01', 'f003', '232432', '2023-06-06', 'PEN', '02', '', 0.00, 0.00, 0.00, 0.00, 0.00, 1, '2023-06-09 01:07:47', '2023-06-09 01:07:47');

-- Volcando estructura para tabla bd_app_inventario.purchases_detail
CREATE TABLE IF NOT EXISTS `purchases_detail` (
  `id_purchase_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_purchase` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_purchase_detail`),
  KEY `id_purchase` (`id_purchase`),
  KEY `id_product` (`id_product`),
  CONSTRAINT `FK__purchases` FOREIGN KEY (`id_purchase`) REFERENCES `purchases` (`id_purchase`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_purchases_detail_products` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_app_inventario.purchases_detail: ~0 rows (aproximadamente)
INSERT INTO `purchases_detail` (`id_purchase_detail`, `id_purchase`, `id_product`, `quantity`, `unit_price`, `total_price`, `state`, `created_at`, `updated_at`) VALUES
	(1, 1, 3, 100.00, 10.00, 1000.00, 1, '2023-06-08 23:39:57', '2023-06-08 23:39:57'),
	(6, 2, 3, 20.00, 10.00, 200.00, 1, '2023-06-09 00:01:32', '2023-06-09 00:01:32'),
	(7, 3, 3, 20.00, 10.00, 200.00, 1, '2023-06-09 00:02:37', '2023-06-09 00:02:37'),
	(8, 3, 2, 50.00, 10.00, 500.00, 1, '2023-06-09 00:02:37', '2023-06-09 00:02:37'),
	(9, 4, 3, 10.00, 0.00, 0.00, 1, '2023-06-09 01:07:47', '2023-06-09 01:07:47'),
	(10, 4, 2, 10.00, 0.00, 0.00, 1, '2023-06-09 01:07:47', '2023-06-09 01:07:47');

-- Volcando estructura para tabla bd_app_inventario.sales
CREATE TABLE IF NOT EXISTS `sales` (
  `id_sale` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_serie` int(11) DEFAULT NULL,
  `type_invoice` varchar(3) DEFAULT NULL,
  `serie` varchar(5) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `broadcast_date` date DEFAULT NULL,
  `coin` varchar(3) DEFAULT NULL,
  `type_operation` varchar(3) DEFAULT NULL,
  `observation` varchar(50) DEFAULT NULL,
  `taxed_operation` decimal(10,2) DEFAULT NULL,
  `exonerated_operation` decimal(10,2) DEFAULT NULL,
  `unaffected_operation` decimal(10,2) DEFAULT NULL,
  `igv` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_sale`),
  KEY `id_client` (`id_client`),
  KEY `id_user` (`id_user`),
  KEY `id_serie` (`id_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_app_inventario.sales: ~0 rows (aproximadamente)
INSERT INTO `sales` (`id_sale`, `id_client`, `id_user`, `id_serie`, `type_invoice`, `serie`, `number`, `broadcast_date`, `coin`, `type_operation`, `observation`, `taxed_operation`, `exonerated_operation`, `unaffected_operation`, `igv`, `total`, `state`, `created_at`, `updated_at`) VALUES
	(1, 3, 8, 2, '03', 'B001', '00000003', '2023-06-08', 'PEN', '01', '', 169.49, 0.00, 0.00, 30.51, 200.00, 9, '2023-06-09 00:03:10', '2023-06-09 00:03:51'),
	(2, 2, 8, 2, '03', 'B001', '00000004', '2023-06-08', 'PEN', '01', '', 169.49, 0.00, 0.00, 30.51, 200.00, 1, '2023-06-09 00:04:13', '2023-06-09 00:04:13'),
	(3, 2, 8, 2, '03', 'B001', '00000005', '2023-06-08', 'PEN', '01', '', 42.37, 0.00, 0.00, 7.63, 50.00, 1, '2023-06-09 01:08:15', '2023-06-09 01:08:15');

-- Volcando estructura para tabla bd_app_inventario.sales_detail
CREATE TABLE IF NOT EXISTS `sales_detail` (
  `id_sale_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_sale` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_sale_detail`),
  KEY `id_sale` (`id_sale`),
  KEY `id_product` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_app_inventario.sales_detail: ~0 rows (aproximadamente)
INSERT INTO `sales_detail` (`id_sale_detail`, `id_sale`, `id_product`, `quantity`, `unit_price`, `total_price`, `state`, `created_at`, `updated_at`) VALUES
	(2, 1, 3, 20.00, 10.00, 200.00, 1, '2023-06-09 00:03:33', '2023-06-09 00:03:33'),
	(3, 2, 3, 20.00, 10.00, 200.00, 1, '2023-06-09 00:04:13', '2023-06-09 00:04:13'),
	(4, 3, 2, 5.00, 10.00, 50.00, 1, '2023-06-09 01:08:15', '2023-06-09 01:08:15');

-- Volcando estructura para tabla bd_app_inventario.series
CREATE TABLE IF NOT EXISTS `series` (
  `id_serie` int(11) NOT NULL AUTO_INCREMENT,
  `type_invoice` varchar(5) DEFAULT NULL,
  `serie` varchar(10) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla bd_app_inventario.series: ~3 rows (aproximadamente)
INSERT INTO `series` (`id_serie`, `type_invoice`, `serie`, `number`, `num`, `state`, `created_at`, `updated_at`) VALUES
	(1, 'NV', '0001', '00000001', 1, 1, '2023-06-08 04:14:21', '2023-06-08 04:14:22'),
	(2, '03', 'B001', '00000006', 6, 1, '2023-06-08 04:14:21', '2023-06-09 01:08:15'),
	(3, '01', 'F001', '00000001', 1, 1, '2023-06-08 04:14:21', '2023-06-08 04:14:22');

-- Volcando estructura para tabla bd_app_inventario.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user_type` bigint(20) unsigned NOT NULL DEFAULT '0',
  `establishment` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` int(11) NOT NULL,
  `api_token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`),
  KEY `id_user_type` (`id_user_type`),
  CONSTRAINT `FK_users_user_type` FOREIGN KEY (`id_user_type`) REFERENCES `user_type` (`id_user_type`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.users: ~12 rows (aproximadamente)
INSERT INTO `users` (`id_user`, `id_user_type`, `establishment`, `name`, `last_name`, `user`, `email`, `password`, `phone`, `state`, `api_token`, `remember_token`, `created_at`, `updated_at`) VALUES
	(8, 1, '[]', 'admin', '', 'admin', 'admin@gmail.com', '$2y$10$KiBQiYHBP5C9AB5qTkW/2O6.8PrxkvRoqWxuNjo3v9Ex2SGuJUPL2', '', 1, 'Cnf0pqRx7rZbWty1DvyC7dyYHpx2i4DjH3sqoZ7GzDC1L1hBK8IpOgSbBfGK', NULL, '2021-08-19 21:17:22', '2023-06-09 01:46:12');

-- Volcando estructura para tabla bd_app_inventario.user_type
CREATE TABLE IF NOT EXISTS `user_type` (
  `id_user_type` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.user_type: ~3 rows (aproximadamente)
INSERT INTO `user_type` (`id_user_type`, `name`, `state`, `created_at`, `updated_at`) VALUES
	(1, 'Administrador', 1, '2022-08-23 07:52:19', '2022-08-23 10:51:38'),
	(2, 'Caja', 1, '2022-08-23 08:44:50', '2022-09-08 21:14:16');

-- Volcando estructura para tabla bd_app_inventario.zones
CREATE TABLE IF NOT EXISTS `zones` (
  `id_zone` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_zone`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla bd_app_inventario.zones: ~22 rows (aproximadamente)
INSERT INTO `zones` (`id_zone`, `name`, `module`, `group`, `state`, `created_at`, `updated_at`) VALUES
	(1, 'Inicio', 'Home', 'Inicio', 1, '2022-08-18 12:51:23', '2022-08-18 12:51:24'),
	(10, 'Usuario', 'User', 'Mantenimiento', 1, '2022-08-18 13:10:54', '2022-08-18 13:10:54'),
	(11, 'Tipo de Usuario', 'UserType', 'Mantenimiento', 1, '2022-08-18 13:10:54', '2022-08-18 13:10:54'),
	(13, 'Cliente', 'Client', 'Entidad', 1, '2022-08-18 13:10:54', '2022-08-18 13:10:54'),
	(14, 'Proveedor', 'Provider', 'Entidad', 1, '2022-08-18 13:13:14', '2022-08-18 13:13:15'),
	(15, 'Productos', 'Product', 'Productos', 1, '2022-08-18 13:13:14', '2022-08-18 13:13:15'),
	(16, 'Categoria', 'Category', 'Productos', 1, '2022-08-18 13:13:14', '2022-08-18 13:13:15'),
	(17, 'Compra', 'Purchase', 'Compra', 1, '2022-08-18 13:13:14', '2022-08-18 13:13:15'),
	(18, 'Venta', 'Sale', 'Venta', 1, '2022-08-18 13:13:14', '2022-08-18 13:13:15'),
	(19, 'Kardex', 'Kardex', 'Kardex', 1, '2022-08-18 13:13:14', '2022-08-18 13:13:15');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
