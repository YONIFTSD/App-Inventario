CREATE TABLE `categories` (
	`id_category` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NULL DEFAULT NULL,
	`state` INT NULL,
	`created_at` TIMESTAMP NULL,
	`updated_at` TIMESTAMP NULL,
	PRIMARY KEY (`id_category`)
)
COLLATE='utf8mb4_general_ci';

CREATE TABLE `products` (
	`id_product` INT NOT NULL AUTO_INCREMENT,
	`id_category` INT(10) NULL,
	`code` VARCHAR(10) NULL DEFAULT NULL,
	`name` VARCHAR(100) NULL DEFAULT NULL,
	`barcode` VARCHAR(50) NULL DEFAULT NULL,
	`igv` VARCHAR(3) NULL DEFAULT NULL,
	`unit_measured` VARCHAR(8) NULL DEFAULT NULL,
	`purchase_price` DECIMAL(10,2) NULL DEFAULT NULL,
	`sale_price` DECIMAL(10,2) NULL DEFAULT NULL,
	`state` INT NULL,
	`created_at` TIMESTAMP NULL,
	`updated_at` TIMESTAMP NULL,
	INDEX `id_category` (`id_category`),
	PRIMARY KEY (`id_product`),
	CONSTRAINT `FK__categories` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON UPDATE RESTRICT ON DELETE RESTRICT
)
COLLATE='utf8mb4_general_ci';
