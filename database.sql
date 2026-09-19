-- ============================================================
-- Database   : codepoze_spk_naive-bayes
-- Project    : produk-ml_metode_naivebayes (CodeIgniter 3)
-- Driver     : mysqli | charset utf8 / utf8_general_ci
-- Generated  : dari analisis models, controllers, helpers
-- ============================================================

CREATE DATABASE IF NOT EXISTS `codepoze_spk_naive-bayes`
    DEFAULT CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE `codepoze_spk_naive-bayes`;

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- Tabel: tb_users
-- Dipakai  : Auth.php (login/register), Profil.php, M_users.php,
--            my_auth_helper.php (get_users_detail via kolom `id`)
-- Catatan  : `id` = auto increment (session), `id_users` = id acak
--            8 digit dari helper acak_id() (dipakai sbg relasi)
-- ============================================================
DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_users`   VARCHAR(20)  NOT NULL,
    `nama`       VARCHAR(100) NOT NULL,
    `email`      VARCHAR(100) DEFAULT NULL,
    `username`   VARCHAR(50)  NOT NULL,
    `password`   VARCHAR(255) NOT NULL,
    `roles`      ENUM('admin','distribusi','supplier','users') NOT NULL DEFAULT 'users',
    `foto`       VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_id_users` (`id_users`),
    UNIQUE KEY `uq_users_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ============================================================
-- Tabel: tb_pelanggan
-- Dipakai  : Auth.php process_save (register user -> pelanggan)
-- ============================================================
DROP TABLE IF EXISTS `tb_pelanggan`;
CREATE TABLE `tb_pelanggan` (
    `id_pelanggan` VARCHAR(20) NOT NULL,
    `id_users`     VARCHAR(20) NOT NULL,
    `created_at`   TIMESTAMP   NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   TIMESTAMP   NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_pelanggan`),
    KEY `fk_pelanggan_users` (`id_users`),
    CONSTRAINT `fk_pelanggan_users`
        FOREIGN KEY (`id_users`) REFERENCES `tb_users` (`id_users`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ============================================================
-- Tabel: tb_supplier
-- Dipakai  : M_users.php getRoleUsersSupplier
-- ============================================================
DROP TABLE IF EXISTS `tb_supplier`;
CREATE TABLE `tb_supplier` (
    `id_supplier`  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_users`     VARCHAR(20)  NOT NULL,
    `kd_supplier`  VARCHAR(20)  DEFAULT NULL,
    `kd_pos`       VARCHAR(10)  DEFAULT NULL,
    `npwp`         VARCHAR(30)  DEFAULT NULL,
    `fax`          VARCHAR(30)  DEFAULT NULL,
    `telepon`      VARCHAR(20)  DEFAULT NULL,
    `alamat`       TEXT         DEFAULT NULL,
    `created_at`   TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_supplier`),
    KEY `fk_supplier_users` (`id_users`),
    CONSTRAINT `fk_supplier_users`
        FOREIGN KEY (`id_users`) REFERENCES `tb_users` (`id_users`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ============================================================
-- Tabel: tb_distribusi
-- Dipakai  : M_users.php getRoleUsersDsitribusi
-- ============================================================
DROP TABLE IF EXISTS `tb_distribusi`;
CREATE TABLE `tb_distribusi` (
    `id_distribusi` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_users`      VARCHAR(20)  NOT NULL,
    `kd_distribusi` VARCHAR(20)  DEFAULT NULL,
    `kd_pos`        VARCHAR(10)  DEFAULT NULL,
    `npwp`          VARCHAR(30)  DEFAULT NULL,
    `fax`           VARCHAR(30)  DEFAULT NULL,
    `telepon`       VARCHAR(20)  DEFAULT NULL,
    `alamat`        TEXT         DEFAULT NULL,
    `created_at`    TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_distribusi`),
    KEY `fk_distribusi_users` (`id_users`),
    CONSTRAINT `fk_distribusi_users`
        FOREIGN KEY (`id_users`) REFERENCES `tb_users` (`id_users`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ============================================================
-- Tabel: tb_classification
-- Dipakai  : Classification.php, M_classification.php
--            (kelas/label hasil klasifikasi Naive Bayes)
-- ============================================================
DROP TABLE IF EXISTS `tb_classification`;
CREATE TABLE `tb_classification` (
    `id_classification` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama`              VARCHAR(100) NOT NULL,
    `deskripsi`         TEXT         DEFAULT NULL,
    `created_at`        TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_classification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ============================================================
-- Tabel: tb_criteria
-- Dipakai  : Criteria.php, M_criteria.php (atribut/pertanyaan)
-- ============================================================
DROP TABLE IF EXISTS `tb_criteria`;
CREATE TABLE `tb_criteria` (
    `id_criteria` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama`        VARCHAR(150) NOT NULL,
    `created_at`  TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_criteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ============================================================
-- Tabel: tb_criteria_sub
-- Dipakai  : Criteria_sub.php, M_criteria_sub.php
--            (opsi jawaban per kriteria + bobot `nilai`)
-- ============================================================
DROP TABLE IF EXISTS `tb_criteria_sub`;
CREATE TABLE `tb_criteria_sub` (
    `id_criteria_sub` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_criteria`     INT UNSIGNED NOT NULL,
    `nama`            VARCHAR(150) NOT NULL,
    `nilai`           INT          NOT NULL DEFAULT 0,
    `created_at`      TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_criteria_sub`),
    KEY `fk_criteria_sub_criteria` (`id_criteria`),
    CONSTRAINT `fk_criteria_sub_criteria`
        FOREIGN KEY (`id_criteria`) REFERENCES `tb_criteria` (`id_criteria`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ============================================================
-- Tabel: tb_datatraining
-- Dipakai  : Datatraining.php, M_datatraining.php,
--            MY_Controller.php _get_datatraining()
-- Catatan  : 1 sampel training = N baris (1 baris per kriteria),
--            dikelompokkan lewat kolom `count` + `id_classification`.
--            `kriteria_1` & `kriteria_2` = kolom legacy yang masih
--            di-SELECT di M_datatraining::get_all() — dipertahankan
--            agar query tersebut tidak error.
-- ============================================================
DROP TABLE IF EXISTS `tb_datatraining`;
CREATE TABLE `tb_datatraining` (
    `id_datatraining`  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_classification` INT UNSIGNED DEFAULT NULL,
    `id_criteria`      INT UNSIGNED DEFAULT NULL,
    `count`            INT          NOT NULL DEFAULT 0,
    `nilai`            INT          DEFAULT NULL,
    `kriteria_1`       VARCHAR(150) DEFAULT NULL,
    `kriteria_2`       VARCHAR(150) DEFAULT NULL,
    `created_at`       TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_datatraining`),
    KEY `fk_datatraining_classification` (`id_classification`),
    KEY `fk_datatraining_criteria` (`id_criteria`),
    KEY `idx_datatraining_count` (`count`),
    CONSTRAINT `fk_datatraining_classification`
        FOREIGN KEY (`id_classification`) REFERENCES `tb_classification` (`id_classification`)
        ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT `fk_datatraining_criteria`
        FOREIGN KEY (`id_criteria`) REFERENCES `tb_criteria` (`id_criteria`)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ============================================================
-- Tabel: tb_consultation
-- Dipakai  : Consultation.php, M_consultation.php, Report.php
--            `consultation` = JSON {id_criteria: nilai}
-- ============================================================
DROP TABLE IF EXISTS `tb_consultation`;
CREATE TABLE `tb_consultation` (
    `id_consultation` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `consultation`    TEXT         DEFAULT NULL,
    `created_at`      TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_consultation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- SEED DATA
-- ============================================================

-- User admin default
-- username: admin | password: admin123
INSERT INTO `tb_users` (`id_users`, `nama`, `email`, `username`, `password`, `roles`)
VALUES ('12345678', 'Administrator', 'admin@localhost', 'admin',
        '$2y$10$Mnc1nAFzdc1CW1KBYKrx6upKRCKZflVlHtQK4nP2s8T6Bf3dJeipK', 'admin');

-- Contoh kelas klasifikasi (silakan sesuaikan)
INSERT INTO `tb_classification` (`nama`, `deskripsi`) VALUES
('Layak',  'Produk layak untuk diproduksi / dilanjutkan'),
('Tidak Layak', 'Produk tidak layak untuk diproduksi / dilanjutkan');
