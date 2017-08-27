CREATE SCHEMA IF NOT EXISTS `portal`;

USE `portal`;

CREATE TABLE IF NOT EXISTS `portal`.`tbl_regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_code` varchar(15) NOT NULL,
  `region_name` varchar(80) NOT NULL,
  `parent_code` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_region_code` (`region_code`)
) ENGINE=InnoDB AUTO_INCREMENT=90149 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `portal`.`membership` (
  `id` VARCHAR (36) NOT NULL,
  `email` VARCHAR (100) NOT NULL,
  `password` VARCHAR (255) NOT NULL,
  `gambar` VARCHAR (255) NULL,
  `nama_lengkap` VARCHAR (255) NOT NULL,
  `nama_panggilan` VARCHAR (36) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `hp` INTEGER (13) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `portal`.`membership-socmed` (
  `id` VARCHAR (36) NOT NULL,
  `userid` VARCHAR (36) NOT NULL,
  `type` VARCHAR (100) NOT NULL,
  `username` VARCHAR (255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `portal`.`membership-current-alamat` (
  `id` VARCHAR (36) NOT NULL,
  `userid` VARCHAR (36) NOT NULL,
  `region_code` VARCHAR (15) NOT NULL,
  `alamat` TEXT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `portal`.`kerjaan` (
  `id` VARCHAR (36) NOT NULL,
  `userid` VARCHAR (36) NOT NULL,
  `company_name` VARCHAR (255) NOT NULL,
  `kategori` VARCHAR (140) NOT NULL,
  `titel` VARCHAR (140) NOT NULL,
  `remote` BOOLEAN NOT NULL,
  `region_code` VARCHAR (15) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `expiry` TIMESTAMP NOT NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `portal`.`kerjaan-subscriber` (
  `id` VARCHAR (36) NOT NULL,
  `userid` VARCHAR (36) NOT NULL,
  `kerjaanid` VARCHAR (36) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `portal`.`berita` (
  `id` VARCHAR (36) NOT NULL,
  `userid` VARCHAR (36) NOT NULL,
  `titel` VARCHAR (140) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `kategori` VARCHAR (140) NOT NULL,
  `attachment` VARCHAR (255) NOT NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB CHARSET=utf8;
