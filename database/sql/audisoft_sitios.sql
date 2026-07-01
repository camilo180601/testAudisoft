-- =====================================================================
--  Prueba técnica Audisoft — Script de creación de la base de datos
--  Motor: MySQL 8.x
--
--  Este script crea la base de datos, las tablas y unos datos de
--  ejemplo. Es equivalente a ejecutar las migraciones + seeder de
--  Laravel:  php artisan migrate --seed
--
--  Uso:  mysql -u root -p < database/sql/audisoft_sitios.sql
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `audisoft_sitios`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `audisoft_sitios`;

-- Se eliminan en orden inverso por la llave foránea (sites -> categories).
DROP TABLE IF EXISTS `sites`;
DROP TABLE IF EXISTS `categories`;

-- ---------------------------------------------------------------------
--  Categorías: únicamente se requiere el nombre (único).
-- ---------------------------------------------------------------------
CREATE TABLE `categories` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
--  Sitios: nombre, dirección (URL) y categoría (obligatoria).
--  La FK usa ON DELETE RESTRICT: la BD impide borrar una categoría
--  que esté en uso por algún sitio.
-- ---------------------------------------------------------------------
CREATE TABLE `sites` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `url`         VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `category_id` BIGINT UNSIGNED NOT NULL,
    `created_at`  TIMESTAMP NULL DEFAULT NULL,
    `updated_at`  TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `sites_category_id_index` (`category_id`),
    CONSTRAINT `sites_category_id_foreign`
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
--  Datos de ejemplo
-- ---------------------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
    (1, 'Libros',       NOW(), NOW()),
    (2, 'Ropa',         NOW(), NOW()),
    (3, 'Zapatos',      NOW(), NOW()),
    (4, 'Electrónicos', NOW(), NOW()),
    (5, 'Música',       NOW(), NOW()),
    (6, 'Comida',       NOW(), NOW());

INSERT INTO `sites` (`id`, `name`, `url`, `category_id`, `created_at`, `updated_at`) VALUES
    (1, 'Librería Nacional', 'https://librerianacional.com/', 1, NOW(), NOW()),
    (2, 'Zara',              'https://www.zara.com/co/',      2, NOW(), NOW()),
    (3, 'Bosi',              'https://www.bosi.com.co/',      3, NOW(), NOW());
