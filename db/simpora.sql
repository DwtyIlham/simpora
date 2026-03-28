/*
 Navicat Premium Dump SQL

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50739 (5.7.39)
 Source Host           : localhost:3306
 Source Schema         : simpora

 Target Server Type    : MySQL
 Target Server Version : 50739 (5.7.39)
 File Encoding         : 65001

 Date: 27/03/2026 06:45:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_setting
-- ----------------------------
DROP TABLE IF EXISTS `admin_setting`;
CREATE TABLE `admin_setting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_setting
-- ----------------------------
INSERT INTO `admin_setting` VALUES (1, 'Masa Sanggah', '0', '2026-03-27 05:25:55', '2026-03-27 06:30:04');

-- ----------------------------
-- Table structure for atlet
-- ----------------------------
DROP TABLE IF EXISTS `atlet`;
CREATE TABLE `atlet`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabor_id` int(11) NOT NULL,
  `tingkat_pendidikan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tingkat_pendidikan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ig` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_kk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_akte` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_ktp_kia_kk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_ijazah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_nisn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_suket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nisn`(`nisn`) USING BTREE,
  UNIQUE INDEX `nik`(`nik`) USING BTREE,
  INDEX `fk_sekolah_id`(`sekolah_id`) USING BTREE,
  CONSTRAINT `fk_sekolah_id` FOREIGN KEY (`sekolah_id`) REFERENCES `sekolah` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of atlet
-- ----------------------------
INSERT INTO `atlet` VALUES ('0d92689f-4c5f-4b6f-8055-e528292e782b', '0018B555-2DF5-E011-88AB-41D0C9C75D87', 'Siswa 1', '1111111110', 8, NULL, NULL, '1111111111111110', 'L', 'Gorong-gorong', '2026-01-28', NULL, NULL, 'Niagara', '1769585973_4b6c4cbd0193f0db8c72.png', '1769585973_07de7e5e8604944420b6.jpg', '1769585973_c78e5cde39526fe9e504.png', '1769585974_29d7e016f4d2efbe314f.png', '1769585974_3aeb1ccc44aa68e30fd1.jpg', '1769585973_c3ebd32c4084170536cb.png', NULL, '2026-01-28 14:39:36', NULL);
INSERT INTO `atlet` VALUES ('3f5fef25-42b7-45dc-9b69-2ffa39f3e77e', '60F87B1D-3A25-E111-A199-AB7ED113023E', 'FULAN', '1231232131', 3, NULL, NULL, '3330303030303030', 'L', 'KASUR', '2022-02-12', NULL, NULL, 'Blambangan', '1764429284_d394ac2d0555dadbfca8.jpg', '1764429284_540ed0979ef0371d2f38.jpg', '1764429284_5758f6c245b2053ee4b6.jpg', '1764429284_774c61bf116b60986a4d.jpeg', NULL, '1764429284_b323be34af85232c7043.jpg', NULL, '2025-11-29 22:14:44', NULL);
INSERT INTO `atlet` VALUES ('58b0e393-1fe3-41ee-ba9c-8cae726aabe5', '000BBB55-2DF5-E011-87A9-47CF1D434172', 'Agus Update', '1111111112', 6, NULL, NULL, '1111111111111112', 'L', 'Kasur', '2011-11-11', NULL, NULL, 'Goa', '1768483464_333ae225028b7aa3b11a.png', '1768448552_ef54177a128a76898033.jpg', '1768448552_a410546b89033b78ea93.png', '1768448552_e2e79efa8f7925515143.png', '1768448552_16d6e22a99fcff2cf788.jpg', '1768448552_668af8b7158390530f7e.png', NULL, '2026-01-15 10:42:35', '2026-01-15 20:24:24');
INSERT INTO `atlet` VALUES ('67791096-4ed1-4aca-bbe8-96a931047910', '206CAB5B-EDB9-E111-BADA-7539C92D9F6D', 'Siswa Uji Coba', '0192830129', 17, NULL, NULL, '3330303030303039', 'P', 'Banjarnegara', '2012-12-12', NULL, NULL, 'Petambakan', '1772699673_4402dee4390354fd1214.jpg', '1772699673_5ff5fbbbc5bd6c5e50ce.jpg', '1772699673_ed7bf6eb54c5387d1c54.png', '1772699673_000c9b329c2655cedc50.jpeg', '1772699673_d9dc153a45363c290b0b.jpg', '1772699673_ae1a1137c7df519a4abc.png', NULL, '2026-03-05 15:34:35', NULL);
INSERT INTO `atlet` VALUES ('8c53a8fc-9a59-4a5d-bcb5-00c13215f915', '00237D5A-2DF5-E011-AA29-4F6C9C3A3940', 'Abdul Jabar', '1111111111', 10, NULL, NULL, '1111111111111111', 'L', 'uni emirat arab', '2010-10-10', NULL, NULL, 'kauman', '1768296260_e645e2cfe607eb841859.jpg', '1768296260_790d197fc3fab5a43d48.jpg', '1768296260_912ab4b08e88a7d60fa7.png', '1768296260_a8d0627ac22ab3236e00.png', '1768296260_5e100d6315e9de3c6756.jpg', '1768296260_842eb73797db261efff9.png', NULL, '2026-01-13 16:24:20', NULL);
INSERT INTO `atlet` VALUES ('8d481cd1-eaf7-4545-98d3-2d80f878dc69', '206CAB5B-EDB9-E111-BADA-7539C92D9F6D', 'Siswa Uji Coba', '5555555123', 7, NULL, NULL, '3331303030303031', 'L', 'Banjarnegara', '2012-12-12', NULL, NULL, 'Petambakan', '1774542520_5884bd3cddf2d4a93523.png', NULL, '1774542520_0af8faeb96c2b11f1fbe.png', '1774542520_2d16af001bff9f57e76c.png', NULL, '1774542520_46c5221d34fb350a4e05.png', '1774542520_5a17f3965cec9b35ff56.png', '2026-03-26 23:28:40', NULL);
INSERT INTO `atlet` VALUES ('b00e54af-c8d4-4001-8896-af4a32ea06f7', '0018B555-2DF5-E011-88AB-41D0C9C75D87', 'Siswa 2', '1111111113', 5, NULL, NULL, '1111111111111113', 'P', 'Dungeon', '2001-12-12', NULL, NULL, 'Karang Terumbu', '1770099972_5f17338576565b05c4b4.jpg', '1770099395_17f084c8371db0af5d2f.jpg', '1769776000_5bc1c6911f6d4576b7e6.png', '1769776000_afed07f580cf5a286b32.png', NULL, '1769776000_5c16058a71d922eee8d9.png', NULL, '2026-01-30 19:26:42', '2026-02-03 13:26:12');
INSERT INTO `atlet` VALUES ('d98c0eef-fde6-4caf-bb30-f4d1894ab308', 'A06F5AD1-05B6-E111-BDCF-712A786325C6', 'Nandya Mahardika Putri', '0192830128', 23, NULL, NULL, '3330303030303031', 'P', 'Banjarnegara', '1212-12-12', NULL, NULL, 'Blitar ', '1764318244_d8da5895eabc9bf38df2.jpg', '1764308485_dcb4e6316d5bdff88ef0.webp', '1764309092_a9a3bafd6cde9e00b741.jpg', '1764169900_c027bf69f5cb08dfb02f.jpeg', '1764169900_8c5fc8ebf3a6c9334ed2.jpg', '1764169900_a4a527e50d51aa698455.jpg', NULL, '2025-11-26 22:11:41', '2025-11-28 15:24:04');
INSERT INTO `atlet` VALUES ('dc68265c-9f83-4203-a669-878fee5e39cc', '0018B555-2DF5-E011-88AB-41D0C9C75D87', 'Gonzales', '1111111119', 10, NULL, NULL, '3333333333333339', 'L', 'Kasur', '2012-02-03', NULL, NULL, 'Bawang', '1770092774_4cc51c69091f2ccb1f1b.png', '1770092774_792bcfdb5564f62911ce.jpg', '1770092774_a0e2c917043919ed1ccb.png', '1770092774_c236c76670f669a5d26b.png', '1770092774_7b67e9a5eff068c3ee85.jpg', '1770092774_b93b161ec57bc3fea5fb.png', NULL, '2026-02-03 11:26:14', NULL);

-- ----------------------------
-- Table structure for atlet_validasi
-- ----------------------------
DROP TABLE IF EXISTS `atlet_validasi`;
CREATE TABLE `atlet_validasi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `atlet_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kk_status` enum('pending','valid','invalid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `kk_catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `akte_status` enum('pending','valid','invalid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `akte_catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `foto_status` enum('pending','valid','invalid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `foto_catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `ijazah_status` enum('pending','valid','invalid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `ijazah_catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `ktp_kia_kk_status` enum('pending','valid','invalid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `ktp_kia_kk_catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `nisn_status` enum('pending','valid','invalid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `nisn_catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `suket_status` enum('pending','valid','invalid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `suket_catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status_final` enum('pending','valid','invalid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'pending',
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `atlet_id`(`atlet_id`) USING BTREE,
  CONSTRAINT `atlet_validasi_ibfk_1` FOREIGN KEY (`atlet_id`) REFERENCES `atlet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of atlet_validasi
-- ----------------------------
INSERT INTO `atlet_validasi` VALUES (6, 'd98c0eef-fde6-4caf-bb30-f4d1894ab308', 'valid', 'kk ok', 'valid', 'akte ok', 'valid', 'foto ok', 'valid', 'ijazah ok', 'valid', 'ktp ok', 'valid', 'nisn ok', 'pending', NULL, 'valid', '2025-11-26 22:11:41', '2025-11-30 21:23:02');
INSERT INTO `atlet_validasi` VALUES (9, '3f5fef25-42b7-45dc-9b69-2ffa39f3e77e', 'valid', 'kk fulan ok', 'valid', NULL, 'valid', NULL, 'pending', NULL, 'valid', NULL, 'valid', NULL, 'pending', NULL, 'valid', '2025-11-29 22:14:44', '2025-12-26 15:33:21');
INSERT INTO `atlet_validasi` VALUES (13, '8c53a8fc-9a59-4a5d-bcb5-00c13215f915', 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'pending', NULL, 'valid', '2026-01-13 16:24:20', '2026-01-13 16:24:42');
INSERT INTO `atlet_validasi` VALUES (14, '58b0e393-1fe3-41ee-ba9c-8cae726aabe5', 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'pending', NULL, 'valid', '2026-01-15 10:42:35', '2026-01-15 20:25:21');
INSERT INTO `atlet_validasi` VALUES (15, '0d92689f-4c5f-4b6f-8055-e528292e782b', 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'pending', NULL, 'valid', '2026-01-28 14:39:36', '2026-01-28 14:43:39');
INSERT INTO `atlet_validasi` VALUES (16, 'b00e54af-c8d4-4001-8896-af4a32ea06f7', 'valid', 'tidak ditemukan nama siswa', 'valid', NULL, 'valid', 'foto tidak sesuai jenis kelamin', 'pending', NULL, 'valid', NULL, 'valid', NULL, 'pending', NULL, 'valid', '2026-01-30 19:26:42', '2026-02-03 13:27:00');
INSERT INTO `atlet_validasi` VALUES (17, 'dc68265c-9f83-4203-a669-878fee5e39cc', 'invalid', 'nama tidak ditemukan', 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'valid', NULL, 'pending', NULL, 'invalid', '2026-02-03 11:26:14', '2026-02-04 14:31:10');
INSERT INTO `atlet_validasi` VALUES (18, '67791096-4ed1-4aca-bbe8-96a931047910', 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', '2026-03-05 15:34:35', '2026-03-05 15:34:35');
INSERT INTO `atlet_validasi` VALUES (19, '8d481cd1-eaf7-4545-98d3-2d80f878dc69', 'pending', NULL, 'pending', NULL, 'pending', NULL, 'pending', NULL, 'invalid', NULL, 'pending', NULL, 'invalid', '', 'pending', '2026-03-26 23:28:40', '2026-03-26 23:46:06');

-- ----------------------------
-- Table structure for cabor
-- ----------------------------
DROP TABLE IF EXISTS `cabor`;
CREATE TABLE `cabor`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cabor
-- ----------------------------
INSERT INTO `cabor` VALUES (1, 'ATLETIK');
INSERT INTO `cabor` VALUES (2, 'BOLA BASKET');
INSERT INTO `cabor` VALUES (3, 'BOLA VOLI INDOOR');
INSERT INTO `cabor` VALUES (4, 'BOLA VOLI PANTAI');
INSERT INTO `cabor` VALUES (5, 'BULUTANGKIS');
INSERT INTO `cabor` VALUES (6, 'CATUR');
INSERT INTO `cabor` VALUES (7, 'KARATE');
INSERT INTO `cabor` VALUES (8, 'PANAHAN');
INSERT INTO `cabor` VALUES (9, 'PENCAK SILAT');
INSERT INTO `cabor` VALUES (10, 'PETANQUE');
INSERT INTO `cabor` VALUES (11, 'RENANG');
INSERT INTO `cabor` VALUES (12, 'SEPAK TAKRAW');
INSERT INTO `cabor` VALUES (13, 'SEPAK BOLA');
INSERT INTO `cabor` VALUES (14, 'TENIS LAPANGAN');
INSERT INTO `cabor` VALUES (15, 'TENIS MEJA');
INSERT INTO `cabor` VALUES (16, 'WUSHU');

-- ----------------------------
-- Table structure for cabor_set
-- ----------------------------
DROP TABLE IF EXISTS `cabor_set`;
CREATE TABLE `cabor_set`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kompetisi_id` int(11) NOT NULL,
  `cabor_id` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk2_kompetisi_id`(`kompetisi_id`) USING BTREE,
  INDEX `fk2_cabor_id`(`cabor_id`) USING BTREE,
  CONSTRAINT `fk2_cabor_id` FOREIGN KEY (`cabor_id`) REFERENCES `cabor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk2_kompetisi_id` FOREIGN KEY (`kompetisi_id`) REFERENCES `kompetisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cabor_set
-- ----------------------------

-- ----------------------------
-- Table structure for kompetisi
-- ----------------------------
DROP TABLE IF EXISTS `kompetisi`;
CREATE TABLE `kompetisi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `tgl_start` date NULL DEFAULT NULL,
  `tgl_end` date NULL DEFAULT NULL,
  `tgl_reg_end` date NULL DEFAULT NULL,
  `tingkat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lokasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kompetisi
-- ----------------------------
INSERT INTO `kompetisi` VALUES (1, 'POPDA 2026', 'PEKAN OLAHRAGA PELAJAR DAERAH TAHUN 2026', '2026-03-23', '2026-03-28', '2026-02-28', 'kabupaten', 'Banjarnegara', '2025-11-25 23:39:10', '2025-11-26 01:22:21');

-- ----------------------------
-- Table structure for nomor_cabor
-- ----------------------------
DROP TABLE IF EXISTS `nomor_cabor`;
CREATE TABLE `nomor_cabor`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cabor_id` int(11) NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jenjang` enum('SD','SMP','SMA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kategori` enum('Putra','Putri','Campuran') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `detail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_cabor_id_nocab`(`cabor_id`) USING BTREE,
  CONSTRAINT `fk_cabor_id_nocab` FOREIGN KEY (`cabor_id`) REFERENCES `cabor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 231 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of nomor_cabor
-- ----------------------------
INSERT INTO `nomor_cabor` VALUES (1, 1, '60m Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (2, 1, '1.000m Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (3, 1, 'Lompat Jauh Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (4, 1, 'Tolak Peluru Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (5, 1, 'Trilomba (60m, Lompat Jauh, Tolak Peluru) Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (6, 1, '80m Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (7, 1, '400m Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (8, 1, '1.500m Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (9, 1, 'Estafet 4x100m Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (10, 1, 'Tolak Peluru Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (11, 1, 'Lompat Jauh Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (12, 1, '100m Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (13, 1, '800m Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (14, 1, '3.000m Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (15, 1, '3.000m Jalan Cepat Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (16, 1, 'Estafet 4x100m Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (17, 1, 'Tolak Peluru Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (18, 1, 'Lompat Jauh Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (19, 1, 'Lompat Tinggi Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (20, 1, 'Lempar Lembing Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (21, 1, '60m Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (22, 1, '1.000m Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (23, 1, 'Lompat Jauh Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (24, 1, 'Tolak Peluru Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (25, 1, 'Trilomba (60m, Lompat Jauh, Tolak Peluru)  Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (26, 1, '80m Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (27, 1, '400m Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (28, 1, '1.500m Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (29, 1, 'Estafet 4x100m Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (30, 1, 'Tolak Peluru Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (31, 1, 'Lompat Jauh Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (32, 1, '100m Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (33, 1, '800m Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (34, 1, '3.000m Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (35, 1, '3.000m Jalan Cepat Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (36, 1, 'Estafet 4x100m Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (37, 1, 'Tolak Peluru Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (38, 1, 'Lompat Jauh Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (39, 1, 'Lompat Tinggi Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (40, 1, 'Lempar Lembing Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (41, 2, 'Beregu 5x5 Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (42, 2, 'Beregu 5x5 Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (43, 2, 'Beregu 5x5 Putri Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (44, 2, 'Beregu 5x5 Putri Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (45, 3, 'Beregu Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (46, 3, 'Beregu Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (47, 3, 'Beregu Putra Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (48, 3, 'Beregu Putri Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (49, 3, 'Beregu Putri Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (50, 3, 'Beregu Putri Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (51, 4, 'Beregu Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (52, 4, 'Beregu Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (53, 4, 'Beregu Putri Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (54, 4, 'Beregu Putri Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (55, 5, 'Tunggal Putra Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (56, 5, 'Tunggal Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (57, 5, 'Tunggal Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (58, 5, 'Tunggal Putri Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (59, 5, 'Tunggal Putri Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (60, 5, 'Tunggal Putri Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (61, 6, 'Catur Cepat Perorangan Putra Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (62, 6, 'Catur Cepat Perorangan Tunggal Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (63, 6, 'Catur Cepat Perorangan Tunggal Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (64, 6, 'Catur Cepat Perorangan Tunggal Putri Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (65, 6, 'Catur Cepat Perorangan Tunggal Putri Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (66, 6, 'Catur Cepat Perorangan Tunggal Putri Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (67, 7, 'Kata Perorangan Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (68, 7, 'Kumite - 40 Kg Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (69, 7, 'Kumite - 45 Kg Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (70, 7, 'Kumite + 45 Kg Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (71, 7, 'Kata Perorangan Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (72, 7, 'Kumite - 50 Kg Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (73, 7, 'Kumite - 55 Kg Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (74, 7, 'Kumite + 55 Kg Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (75, 7, 'Kata Perorangan Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (76, 7, 'Kumite - 60 Kg Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (77, 7, 'Kumite - 68 Kg Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (78, 7, 'Kumite + 68 Kg Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (79, 7, 'Kata Perorangan Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (80, 7, 'Kumite - 35 Kg Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (81, 7, 'Kumite - 40 Kg Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (82, 7, 'Kumite + 40 Kg Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (83, 7, 'Kata Perorangan Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (84, 7, 'Kumite - 45 Kg Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (85, 7, 'Kumite - 50 Kg Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (86, 7, 'Kumite + 50 Kg Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (87, 7, 'Kata Perorangan Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (88, 7, 'Kumite - 53 Kg Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (89, 7, 'Kumite - 59 Kg Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (90, 7, 'Kumite + 59 Kg Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (91, 8, 'Recurve Total Sesi Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (92, 8, 'Recurve Eliminasi Individu Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (93, 8, 'Compound Total Sesi Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (94, 8, 'Compound Eliminasi Individu Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (95, 8, 'Nasional Total Sesi Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (96, 8, 'Nasional Eliminasi Individu Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (97, 8, 'Recurve Total Sesi Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (98, 8, 'Recurve Eliminasi Individu Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (99, 8, 'Compound Total Sesi Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (100, 8, 'Compound Eliminasi Individu Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (101, 8, 'Nasional Total Sesi Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (102, 8, 'Nasional Eliminasi Individu Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (103, 8, 'Recurve Total Sesi Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (104, 8, 'Recurve Eliminasi Individu Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (105, 8, 'Compound Total Sesi Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (106, 8, 'Compound Eliminasi Individu Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (107, 8, 'Nasional Total Sesi Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (108, 8, 'Nasional Eliminasi Individu Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (109, 8, 'Recurve Total Sesi Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (110, 8, 'Recurve Eliminasi Individu Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (111, 8, 'Compound Total Sesi Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (112, 8, 'Compound Eliminasi Individu Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (113, 8, 'Nasional Total Sesi Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (114, 8, 'Nasional Eliminasi Individu Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (115, 8, 'Recurve Total Sesi Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (116, 8, 'Recurve Eliminasi Individu Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (117, 8, 'Compound Total Sesi Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (118, 8, 'Compound Eliminasi Individu Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (119, 8, 'Nasional Total Sesi Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (120, 8, 'Nasional Eliminasi Individu Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (121, 8, 'Recurve Total Sesi Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (122, 8, 'Recurve Eliminasi Individu Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (123, 8, 'Compound Total Sesi Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (124, 8, 'Compound Eliminasi Individu Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (125, 8, 'Nasional Total Sesi Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (126, 8, 'Nasional Eliminasi Individu Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (127, 9, 'Jurus Tunggal Putra Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (128, 9, 'Kelas E Putra 42 - 45 Kg Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (129, 9, 'Kelas G Putra 48 - 51 Kg Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (130, 9, 'Kelas I Putra 54 - 57 Kg Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (131, 9, 'Kelas K Putra 60 - 63 Kg Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (132, 9, 'Jurus Tunggal Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (133, 9, 'Kelas A Putra 39 - 43 Kg Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (134, 9, 'Kelas D Putra 51 - 55 Kg Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (135, 9, 'Kelas G Putra 63 - 67 Kg Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (136, 9, 'Jurus Tunggal Putri Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (137, 9, 'Kelas D Putri 39 - 42 Kg Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (138, 9, 'Kelas F Putri 45 - 48 Kg Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (139, 9, 'Kelas H Putri 51 - 54 Kg Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (140, 9, 'Kelas J Putri 57 - 60 Kg Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (141, 9, 'Jurus Tunggal Putri Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (142, 9, 'Kelas B Putri 43 - 47 Kg Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (143, 9, 'Kelas D Putri 51 - 55 Kg Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (144, 9, 'Kelas F Putri 59 - 63 Kg Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (145, 10, 'Tunggal Putra Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (146, 10, 'Tunggal Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (147, 10, 'Tunggal Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (148, 10, 'Tunggal Putri Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (149, 10, 'Tunggal Putri Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (150, 10, 'Tunggal Putri Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (151, 11, '50m Gaya Bebas Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (152, 11, '100m Gaya Bebas Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (153, 11, '200m Gaya Bebas Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (154, 11, '100m Gaya Dada Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (155, 11, '100m Gaya Punggung Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (156, 11, '100m Gaya Kupu-kupu Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (157, 11, '200m Gaya Ganti Usia Dini Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (158, 11, '50m Gaya Bebas Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (159, 11, '100m Gaya Bebas Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (160, 11, '200m Gaya Bebas Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (161, 11, '100m Gaya Dada Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (162, 11, '100m Gaya Punggung Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (163, 11, '100m Gaya Kupu-kupu Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (164, 11, '200m Gaya Ganti Perorangan Pra Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (165, 11, '50m Gaya Bebas Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (166, 11, '100m Gaya Bebas Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (167, 11, '200m Gaya Bebas Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (168, 11, '100m Gaya Dada Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (169, 11, '100m Gaya Punggung Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (170, 11, '100m Gaya Kupu-kupu Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (171, 11, '200m Gaya Ganti Perorangan Remaja Putra', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (172, 11, '50m Gaya Bebas SD Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (173, 11, '100m Gaya Bebas SD Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (174, 11, '200m Gaya Bebas SD Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (175, 11, '100m Gaya Dada Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (176, 11, '100m Gaya Punggung Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (177, 11, '100m Gaya Kupu-kupu Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (178, 11, '200m Gaya Ganti Usia Dini Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (179, 11, '50m Gaya Bebas Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (180, 11, '100m Gaya Bebas Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (181, 11, '200m Gaya Bebas Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (182, 11, '100m Gaya Dada Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (183, 11, '100m Gaya Punggung Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (184, 11, '100m Gaya Kupu-kupu Pra Remaja Putri ', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (185, 11, '200m Gaya Ganti Perorangan Pra Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (186, 11, '50m Gaya Bebas Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (187, 11, '100m Gaya Bebas Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (188, 11, '200m Gaya Bebas Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (189, 11, '100m Gaya Dada Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (190, 11, '100m Gaya Punggung Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (191, 11, '100m Gaya Kupu-kupu Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (192, 11, '200m Gaya Ganti Perorangan Remaja Putri', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (193, 12, 'Inter Regu Putra Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (194, 12, 'Inter Regu Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (195, 12, 'Inter Regu Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (196, 12, 'Inter Regu Putri Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (197, 12, 'Inter Regu Putra SMP', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (198, 12, 'Inter Regu Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (199, 13, 'Beregu Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (200, 13, 'Beregu Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (201, 13, 'Beregu Putri Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (202, 14, 'Tunggal Putra Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (203, 14, 'Tunggal Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (204, 14, 'Tunggal Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (205, 14, 'Tunggal Putri Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (206, 14, 'Tunggal Putri Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (207, 14, 'Tunggal Putri Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (208, 15, 'Tunggal Putra Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (209, 15, 'Tunggal Putra Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (210, 15, 'Tunggal Putra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (211, 15, 'Tunggal Putri Usia Dini', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (212, 15, 'Tunggal Putri Pra Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (213, 15, 'Tunggal Putri Remaja', NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (214, 16, '36 Kg (Under 36 kg)', NULL, 'Putri', 'Pra Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (215, 16, '39 Kg (36,1 - 39,0 kg)', NULL, 'Putri', 'Pra Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (216, 16, '39 Kg (36,1 – 39,0 Kg)', NULL, 'Putra', 'Pra Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (217, 16, '42 Kg (39,1 -42,0 Kg)', NULL, 'Putra', 'Pra Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (218, 16, '42 Kg (Under 42 Kg)', NULL, 'Putri', 'Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (219, 16, '45 Kg (42,1 Kg -45,0 Kg)', NULL, 'Putri', 'Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (220, 16, '48 Kg (45,1 Kg -48,0 Kg)', NULL, 'Putri', 'Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (221, 16, '42 Kg (Under 42 Kg)', NULL, 'Putra', 'Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (222, 16, '45 Kg (42,1 Kg -45,0 Kg)', NULL, 'Putra', 'Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (223, 16, '48 Kg (45,1 Kg -48,0 Kg)', NULL, 'Putra', 'Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (224, 16, '52 Kg (48,1 Kg - 52,0 Kg)', NULL, 'Putra', 'Junior', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (225, 16, '45 Kg (42,1 - 45,0 Kg)', NULL, 'Putri', 'Youth', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (226, 16, '48 Kg (45, 1 -48,0 Kg)', NULL, 'Putri', 'Youth', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (227, 16, '52 Kg (48,1- 52,0 Kg)', NULL, 'Putri', 'Youth', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (228, 16, '56 Kg (52,1 - 56,0 Kg)', NULL, 'Putri', 'Youth', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (229, 16, '48 Kg (45, 1 -48,0 Kg)', NULL, 'Putra', 'Youth', '1', NULL, NULL);
INSERT INTO `nomor_cabor` VALUES (230, 16, '52 Kg (48,1- 52,0 Kg)', NULL, 'Putra', 'Youth', '1', NULL, NULL);

-- ----------------------------
-- Table structure for peserta
-- ----------------------------
DROP TABLE IF EXISTS `peserta`;
CREATE TABLE `peserta`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `atlet_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kompetisi_id` int(11) NULL DEFAULT NULL,
  `cabor_id` int(11) NULL DEFAULT NULL,
  `nomor_cabor_id` int(11) NULL DEFAULT NULL,
  `nomor_cabor_id_2` int(11) NULL DEFAULT NULL,
  `prestasi` int(11) NULL DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_kompetisi_id`(`kompetisi_id`) USING BTREE,
  INDEX `fk_cabor_id`(`cabor_id`) USING BTREE,
  INDEX `fk_atlet_id`(`atlet_id`) USING BTREE,
  INDEX `fk_nomor_cabor_id`(`nomor_cabor_id`) USING BTREE,
  CONSTRAINT `fk_atlet_id` FOREIGN KEY (`atlet_id`) REFERENCES `atlet` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_cabor_id` FOREIGN KEY (`cabor_id`) REFERENCES `cabor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kompetisi_id` FOREIGN KEY (`kompetisi_id`) REFERENCES `kompetisi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nomor_cabor_id` FOREIGN KEY (`nomor_cabor_id`) REFERENCES `nomor_cabor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of peserta
-- ----------------------------
INSERT INTO `peserta` VALUES ('15', '3f5fef25-42b7-45dc-9b69-2ffa39f3e77e', 1, 3, 1, NULL, 2, '2025-12-26 15:50:38', '2026-01-13 12:05:18');
INSERT INTO `peserta` VALUES ('16', 'd98c0eef-fde6-4caf-bb30-f4d1894ab308', 1, 23, 158, NULL, 1, '2025-12-26 15:50:51', '2026-01-13 12:05:12');
INSERT INTO `peserta` VALUES ('2d428448-c7ac-4b43-a57e-9906c3cd6c20', '58b0e393-1fe3-41ee-ba9c-8cae726aabe5', 1, 5, 37, NULL, NULL, '2026-01-15 20:41:25', NULL);
INSERT INTO `peserta` VALUES ('74c90909-ac41-4d8c-8776-7441a6f88915', '8c53a8fc-9a59-4a5d-bcb5-00c13215f915', 1, 10, 67, NULL, NULL, '2026-01-13 16:35:44', NULL);
INSERT INTO `peserta` VALUES ('aa3c21f2-3433-4dd5-a207-1bfa4a66766e', '0d92689f-4c5f-4b6f-8055-e528292e782b', 1, 3, 1, 502, 1, '2026-01-28 19:10:39', '2026-02-04 17:20:50');
INSERT INTO `peserta` VALUES ('d37bd98a-6107-4259-9d5d-8aba11e83cab', 'b00e54af-c8d4-4001-8896-af4a32ea06f7', 1, 5, 37, 37, NULL, '2026-01-30 19:28:50', '2026-01-30 19:54:28');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'admin');
INSERT INTO `roles` VALUES (2, 'sekolah');
INSERT INTO `roles` VALUES (3, 'atlet');

-- ----------------------------
-- Table structure for sekolah
-- ----------------------------
DROP TABLE IF EXISTS `sekolah`;
CREATE TABLE `sekolah`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npsn` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status_sekolah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kecamatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bentuk_pendidikan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sekolah
-- ----------------------------
INSERT INTO `sekolah` VALUES ('000BBB55-2DF5-E011-87A9-47CF1D434172', '20304231', 'SD MUHAMMADIYAH DANARAJA', 'SWASTA', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('0016C955-2DF5-E011-A24B-1DAA493F5183', '20304432', 'SD NEGERI 1 SAWANGAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('0018B555-2DF5-E011-88AB-41D0C9C75D87', '20304104', 'SD NEGERI 4 BERTA', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('001AC655-2DF5-E011-8E36-3D0A109128D2', '20303729', 'SD NEGERI 2 SIKUMPUL', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('001CC355-2DF5-E011-BFC0-5139EEFAB197', '20304591', 'SD NEGERI 1 BANJARMANGU', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('001FB355-2DF5-E011-BE84-1DFABCBDC935', '20304544', 'SD NEGERI 1 DERIK', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('001FD155-2DF5-E011-BA4B-7773032FE34C', '20303881', 'SD NEGERI 2 PEJAWARAN', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('00237D5A-2DF5-E011-AA29-4F6C9C3A3940', '20337881', 'SMP ISLAM SATRIA', 'SWASTA', 'Kec. Madukara', 'SMP');
INSERT INTO `sekolah` VALUES ('0027C755-2DF5-E011-8BFB-71E700C9FCE2', '20303753', 'SD NEGERI 2 SITUWANGI', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('003BBF55-2DF5-E011-9FB6-37470761DEFD', '20304458', 'SD NEGERI 1 PAGEDONGAN', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('003CBC55-2DF5-E011-BC35-ABDA13750D62', '20304416', 'SD NEGERI 1 PUCANG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('0050C355-2DF5-E011-85C3-2B6FA0FC426F', '20304464', 'SD NEGERI 1 PASEH', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('0051F6BB-ECB9-E111-B4E4-85305D39C347', '20303976', 'SD NEGERI SIJERUK', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('005ABB55-2DF5-E011-A06D-EF88A88746CD', '20304080', 'SD NEGERI 4 MERTASARI', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('005DD355-2DF5-E011-B39B-B51B996E023D', '20341001', 'SD NEGERI 1 DAWUHAN', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('005FD555-2DF5-E011-B15A-C57E7E567249', '20304652', 'SD NEGERI 1 KASINOMAN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('00617088-8DE3-E211-B3BF-5744B729B0C4', '69760755', 'SMP PLUS RIYADUL MUSTAQIM MANDIRAJA', 'SWASTA', 'Kec. Mandiraja', 'SMP');
INSERT INTO `sekolah` VALUES ('0062205A-2DF5-E011-93A6-97013CD35A85', '20304013', 'SMP NEGERI 5 BANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('0064B655-2DF5-E011-AF8B-818EC86A38C7', '20304073', 'SD NEGERI 4 SIRKANDI', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('00673C59-2DF5-E011-93CD-DD39F293956D', '20304248', 'SD MUHAMMADIYAH 4 BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('0068BE55-2DF5-E011-9046-C1DBE89833E2', '20304164', 'SD NEGERI 07 KRANDEGAN', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('0070B755-2DF5-E011-81CE-95C040D77CD9', '20338244', 'SD NEGERI 1 SIMBANG', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('0072C955-2DF5-E011-A60F-27F11D8F7418', '20303732', 'SD NEGERI 2 SIDARATA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('007FB255-2DF5-E011-97E8-5189F85045EF', '20303872', 'SD NEGERI 2 GUMELEM KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('0084CE55-2DF5-E011-9E83-39563F23A6DD', '20304455', 'SD NEGERI 1 PAGENTAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('0088C555-2DF5-E011-8CE0-01C463256159', '20303990', 'SD NEGERI 1 TAPEN', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('008AA4D8-4FF8-4951-9F3F-AE70EAF7CBFD', '60710843', 'MIS COKROAMINOTO BANDINGAN', 'SWASTA', 'Kec. Sigaluh', 'MI');
INSERT INTO `sekolah` VALUES ('008BB755-2DF5-E011-B378-B9F973ED2C39', '20338247', 'SD NEGERI 2 GLEMPANG', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('008D194C-07B6-E111-B09D-9D86F7992E8F', '20360825', 'SMP NEGERI 4 SATAP SUSUKAN', 'NEGERI', 'Kec. Susukan', 'SMP');
INSERT INTO `sekolah` VALUES ('0091D755-2DF5-E011-940A-2DB91921013B', '20303913', 'SD NEGERI 2 LAWEN', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('0093CA55-2DF5-E011-BD01-2BC5B0B41FCB', '20304649', 'SD NEGERI 1 KARANGGONDANG', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('009EB555-2DF5-E011-95DA-955786A324A1', '20303828', 'SD NEGERI 2 KALIMANDI', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('009ED755-2DF5-E011-9B45-1B69B71C5803', '20303724', 'SD NEGERI 3 BEJI', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('00A21F5A-2DF5-E011-8CD9-81AD7815D5A9', '20304025', 'SMP NEGERI 1 MANDIRAJA', 'NEGERI', 'Kec. Mandiraja', 'SMP');
INSERT INTO `sekolah` VALUES ('00A6D355-2DF5-E011-9026-23C0C188972C', '20304619', 'SD NEGERI 1 KUBANG', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('00A8E0CF-FAB5-E111-A831-01C97728C923', '20347832', 'SMP NEGERI 5 BAWANG', 'NEGERI', 'Kec. Bawang', 'SMP');
INSERT INTO `sekolah` VALUES ('00ACCE55-2DF5-E011-81CA-7FC7511B4CD3', '20304530', 'SD NEGERI TEGALJERUK', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('00B01F5A-2DF5-E011-9219-099944598298', '20304006', 'SMP NEGERI 2 MANDIRAJA', 'NEGERI', 'Kec. Mandiraja', 'SMP');
INSERT INTO `sekolah` VALUES ('00B2C255-2DF5-E011-BC28-D9FB8B56F784', '20338936', 'SD NEGERI 2 BANTARWARU', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('00B3C455-2DF5-E011-942F-717AFCA44067', '20304628', 'SD NEGERI 1 LEMAHJAYA', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('00B7D255-2DF5-E011-90CE-6D15DAB7785F', '20304086', 'SD NEGERI 3 SUMBEREJO', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('00B9205A-2DF5-E011-98C3-6398575FD7B7', '20304023', 'SMP NEGERI 2 MADUKARA', 'NEGERI', 'Kec. Madukara', 'SMP');
INSERT INTO `sekolah` VALUES ('00BFC255-2DF5-E011-B222-17069D68E156', '20338938', 'SD NEGERI DAWUHAN', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('00C5BE55-2DF5-E011-BBC5-2D74A2E522BC', '20304585', 'SD NEGERI 1 AMPELSARI', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('00C7C855-2DF5-E011-A71B-4FCECD211676', '20303837', 'SD NEGERI 2 KECEPIT', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('00C9215A-2DF5-E011-86E9-97DF27469ED0', '20304030', 'SMP NEGERI 1 BATUR', 'NEGERI', 'Kec. Batur', 'SMP');
INSERT INTO `sekolah` VALUES ('00CCBF55-2DF5-E011-AC60-13F1216C27F5', '20303708', 'SD NEGERI 2 TWELAGIRI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('00CDB755-2DF5-E011-9DE5-41CE19C989B6', '20338235', 'SD NEGERI 1 JALATUNDA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('00D2BE55-2DF5-E011-8610-29B8AF27DEC3', '20304429', 'SD NEGERI 1 SEMARANG', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('00D7215A-2DF5-E011-9ACF-EF57162BC19E', '20304042', 'SMP NEGERI 2 BATUR', 'NEGERI', 'Kec. Batur', 'SMP');
INSERT INTO `sekolah` VALUES ('00DED55C-3A25-E111-9548-4D5806F05BA8', '20304546', 'SD NEGERI 1 DARMAYASA', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('00DFB655-2DF5-E011-9195-EF6E8785AB7F', '20337879', 'SD NEGERI 2 MANDIRAJA WETAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('00DFD255-2DF5-E011-935E-630D8A46BC2C', '20303843', 'SD NEGERI 2 KARANGTENGAH', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('00E4205A-2DF5-E011-8BA7-2BDDA5FB7718', '20304046', 'SMP NEGERI 1 WANADADI', 'NEGERI', 'Kec. Wanadadi', 'SMP');
INSERT INTO `sekolah` VALUES ('00E8C455-2DF5-E011-AFC0-19CC526A3849', '20303910', 'SD NEGERI 2 LEMAHJAYA', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('00EAD055-2DF5-E011-B9C1-03D703C7EA8A', '20304526', 'SD NEGERI 1 TLAHAB', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('00EDD455-2DF5-E011-8E42-9D66CEA2823E', '20304559', 'SD NEGERI 1 GUNUNGLANGIT', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('00F71F5A-2DF5-E011-9E0C-9B8844E283D7', '20304019', 'SMP NEGERI 3 PURWANEGARA', 'NEGERI', 'Kec. Purwanegara', 'SMP');
INSERT INTO `sekolah` VALUES ('00F9B855-2DF5-E011-A5B8-E9661D4E9BDC', '20338268', 'SD NEGERI 6 SOMAWANGI', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('00F9BE55-2DF5-E011-8406-E570EB6DF950', '20303838', 'SD NEGERI 2 KEBUTUHDUWUR', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('00FB1BE0-F9D9-E111-BE89-4F6A3C35D907', '20340905', 'SD NEGERI 2 KARANGSARI PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('00FEBD55-2DF5-E011-A3F5-396877FA0BF7', '20303918', 'SD NEGERI 2 MANTRIANOM', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('01049601-39C8-4872-82AE-E54E45FF2ABB', '20304047', 'SMP NEGERI 1 SUSUKAN', 'NEGERI', 'Kec. Susukan', 'SMP');
INSERT INTO `sekolah` VALUES ('019F1A44-99DD-4C34-B8C5-456FD7DCCAD3', '60710867', 'MIS MA`ARIF TEGATEN', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('01F87A3A-26FC-4BBB-A15B-B06C59AA0929', '20303961', 'SMK HKTI 1 PURWAREJA KLAMPOK', 'SWASTA', 'Kec. Purwareja Klampok', 'SMK');
INSERT INTO `sekolah` VALUES ('025D735B-FC3F-4F5A-B9FF-43736DC2AAE3', '20363509', 'MTSS COKROAMINOTO LEBAKWANGI', 'SWASTA', 'Kec. Pagedongan', 'MTs');
INSERT INTO `sekolah` VALUES ('02E3F221-336D-4DA8-826E-C56D53231053', '60710861', 'MIS MA`ARIF JOMBLANG', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('04568C86-BA17-4516-A5A7-DA7622F1139B', '20363494', 'MTSS MUHAMMADIYAH BANJARMANGU', 'SWASTA', 'Kec. Banjarmangu', 'MTs');
INSERT INTO `sekolah` VALUES ('048CF4FF-A54D-41BF-9192-C108F9F4B4C0', '60710762', 'MIS MAARIF PAGEDONGAN TENGAH', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('05A356F8-A381-434C-AE94-72D1177EE01D', '60710743', 'MIS AL MA`ARIF 02 KERTAYASA', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('06DC3FC2-CA02-43EA-81DB-A235DC93A6EB', '60710780', 'MIS MUHAMMADIYAH KARANGSARI', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('06E9FD17-F34D-489C-B27A-43AF01B2F8D1', '60710855', 'MIS MUHAMMADIYAH LINGGASARI', 'SWASTA', 'Kec. Wanadadi', 'MI');
INSERT INTO `sekolah` VALUES ('07B1AE94-BFE4-4197-8A04-9440DB16190C', '60710729', 'MIS COKROAMINOTO REJASA', 'SWASTA', 'Kec. Madukara', 'MI');
INSERT INTO `sekolah` VALUES ('084CB3DE-ABEF-4DD4-9B2A-36872C6C361C', '60710694', 'MIS COKROAMINOTO KARANGTENGAH', 'SWASTA', 'Kec. Banjarnegara', 'MI');
INSERT INTO `sekolah` VALUES ('086F5044-C6E0-4CBC-A1A5-A2E86A1FD02D', '60710733', 'MIS AL MA`ARIF 01 KERTAYASA', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('092B93D0-87CB-422B-9050-B18B06EC5580', '60710872', 'MIS COKROAMINOTO CLIBIKAN', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('097524F9-EF29-41BD-90B6-9A2FBFC8D03A', '60710841', 'MIS MUHAMMADIYAH SAWAL', 'SWASTA', 'Kec. Sigaluh', 'MI');
INSERT INTO `sekolah` VALUES ('09DB472A-B865-4212-9DB6-D6892356B6D5', '60710784', 'MIS AL HIDAYAH PETUGURAN', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('0A04DD65-81FA-4649-81D6-60051207D53B', '60710719', 'MIS MUHAMMADIYAH SAWALAN', 'SWASTA', 'Kec. Kalibening', 'MI');
INSERT INTO `sekolah` VALUES ('0AC49562-2A2A-4A3B-A4CA-C5841FE21149', '70035964', 'SMP ISLAM PANGLEBURAN', 'SWASTA', 'Kec. Mandiraja', 'SMP');
INSERT INTO `sekolah` VALUES ('0B781BCE-7864-451E-B93F-102DD820052A', '20363524', 'MTSS AL MAARIF RAKIT', 'SWASTA', 'Kec. Rakit', 'MTs');
INSERT INTO `sekolah` VALUES ('0BA112E3-E9C3-468F-B302-5BD6268C97A8', '60710700', 'MIN 2 BANJARNEGARA', 'NEGERI', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('0C61F418-FBFA-43FD-88D6-E9889898ED10', '60726960', 'MIS MAARIF AL FALAH JOYOKUSUMO', 'SWASTA', 'Kec. Banjarnegara', 'MI');
INSERT INTO `sekolah` VALUES ('0D1E631F-0EF0-454D-AA69-75BC3C7E21B9', '60710845', 'MIS MA`ARIF PANAWAREN', 'SWASTA', 'Kec. Sigaluh', 'MI');
INSERT INTO `sekolah` VALUES ('0E3CF449-9118-42C2-A6E7-1EEEBD8DE5D1', '20363506', 'MTSS AL HIDAYAH PURWASABA', 'SWASTA', 'Kec. Mandiraja', 'MTs');
INSERT INTO `sekolah` VALUES ('0E935BBB-E820-482A-9365-2F8268A7633C', '20364905', 'MAS TERPADU ASADIYAH', 'SWASTA', 'Kec. Madukara', 'MA');
INSERT INTO `sekolah` VALUES ('0EA2C6E1-DB07-48C7-A11D-0FB14342A38B', '20277367', 'MAN 2 BANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'MA');
INSERT INTO `sekolah` VALUES ('0ECB76CB-CA36-411B-93D5-10952AA64265', '60710716', 'MIS MUHAMMADIYAH SAMPANG', 'SWASTA', 'Kec. Kalibening', 'MI');
INSERT INTO `sekolah` VALUES ('0F38C13F-2E47-4BEA-9AAA-E2DCCC272104', '70013779', 'MI TAHFIDZUL QUR`AN AL MANSHURAH', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('0F649C5D-0DCB-47F0-BD05-B16732847BAA', '60710706', 'MIS MUHAMMADIYAH BAWANG', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('0F714958-BFA7-4FED-9D3E-668F0180BF68', '60710718', 'MIS GUPPI KARANGMANGGIS', 'SWASTA', 'Kec. Kalibening', 'MI');
INSERT INTO `sekolah` VALUES ('0F9E679D-2FDC-4355-8A6B-8D86B30484B9', '60710713', 'MIS AL HUDA WANADRI', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('1001C055-2DF5-E011-BCC1-3D592E055E31', '20304483', 'SD NEGERI 10 KRANDEGAN', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('100ED755-2DF5-E011-AAB5-01EC7C75B023', '20303923', 'SD NEGERI 2 PANDANARUM', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('1014B755-2DF5-E011-B2A9-E3F395F701A0', '20338232', 'SD NEGERI 1 CANDIWULAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('1014C255-2DF5-E011-AD50-D33773660411', '20304533', 'SD NEGERI 1 TALUNAMBA', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('1025BB55-2DF5-E011-813C-EFB55D2FB1B9', '20303916', 'SD NEGERI 2 KUTAWULUH', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('1030C1F3-05B6-E111-8E67-A77356143266', '20344873', 'SMP NEGERI 6 SATAP PURWANEGARA', 'NEGERI', 'Kec. Purwanegara', 'SMP');
INSERT INTO `sekolah` VALUES ('105FB855-2DF5-E011-AD93-C919C546F037', '20338257', 'SD NEGERI 3 MANDIRAJA KULON', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('106DB855-2DF5-E011-B971-37DC2D483895', '20338252', 'SD NEGERI 2 SALAMERTA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('1071C455-2DF5-E011-83E2-C9AA3FB00408', '20303844', 'SD NEGERI 2 KALILUNJAR ', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('1075BB55-2DF5-E011-B831-EF24D78607D9', '20304077', 'SD NEGERI 4 PUCUNGBEDUG', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('107AD355-2DF5-E011-A1F7-B58047F1A191', '20304489', 'SD NEGERI 1 WANARAJA', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('10B2B955-2DF5-E011-8EFE-517725AFD4CA', '20304477', 'SD NEGERI 1 MERDEN', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('10C3D055-2DF5-E011-A7BD-D30F65DA4A70', '20304552', 'SD NEGERI 1 GROGOL', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('10C8B255-2DF5-E011-9A23-0B6F6DABE560', '20303835', 'SD NEGERI 2 KEMRANGGON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('10CAC555-2DF5-E011-AE9B-4B9F24FA3BFC', '20303812', 'SD NEGERI 3 KANDANGWANGI', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('10D1B855-2DF5-E011-B092-5F14309292C1', '20338264', 'SD NEGERI 4 KEBANARAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('10D8C655-2DF5-E011-901D-49A04AEEAEF3', '20303711', 'SD NEGERI 3 BADAMITA', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('10DDD055-2DF5-E011-9263-55D134B80A91', '20304124', 'SD NEGERI 1 BITING', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('10DFBE55-2DF5-E011-A669-3F9A3B92BBBB', '20304508', 'SD NEGERI 1 SOKAYASA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('10E3BF21-FBB5-E111-B2CA-99DC354A5BBE', '20351010', 'SMP NEGERI 2 KALIBENING', 'NEGERI', 'Kec. Kalibening', 'SMP');
INSERT INTO `sekolah` VALUES ('10E5D155-2DF5-E011-84BB-8B3891B8DBC6', '20304603', 'SD NEGERI 1 BATUR', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('10F5B755-2DF5-E011-9ED0-8BD1AEABADBF', '20338270', 'SD NEGERI BANJENGAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('10F9D255-2DF5-E011-8E11-AD43681B4469', '20303850', 'SD NEGERI 2 DIENGKULON', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('10FCCA55-2DF5-E011-9686-DFAE36B2FD50', '20304116', 'SD NEGERI JLEGONG', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('10FFD155-2DF5-E011-8159-31DAE03E4F87', '20303712', 'SD NEGERI 3 BATUR', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('1174A0F6-5824-49D8-929A-0037B0487182', '60710840', 'MIS COKROAMINOTO 02 BADAMITA', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('1278A003-CA72-4B04-B785-88F56F913AE4', '70024931', 'MA RAUDLOTUT THOLIBIN PURWANEGARA', 'SWASTA', 'Kec. Purwanegara', 'MA');
INSERT INTO `sekolah` VALUES ('13985C43-A219-4A37-A9DD-27768A3D5C0B', '20363522', 'MTSN 4 BANJARNEGARA', 'NEGERI', 'Kec. Rakit', 'MTs');
INSERT INTO `sekolah` VALUES ('144127AD-8323-455F-9677-2A3F28344124', '60710827', 'MIS NU 03 SITUWANGI', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('1559565F-17ED-4713-9575-7CE972EFE204', '60710712', 'MIS COKROAMINOTO 02 MAJALENGKA', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('16498B61-A1CC-4156-AEE7-594BFDEABEF4', '60710844', 'MIS COKROAMINOTO SAWAL', 'SWASTA', 'Kec. Sigaluh', 'MI');
INSERT INTO `sekolah` VALUES ('176CD5F3-0C5D-40FB-B9D8-4AF96334B926', '60710778', 'MIS COKROAMINOTO SARWODADI', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('199B5D1A-2C12-43BD-B39E-CED7F57F7430', '69993993', 'MA COKROAMINOTO SOKANANDI', 'SWASTA', 'Kec. Banjarnegara', 'MA');
INSERT INTO `sekolah` VALUES ('19BC3030-A91A-4CE6-A2B2-67DA6F47968A', '20364908', 'MAS AL HIDAYAH 1 PURWAREJA KLAMPOK', 'SWASTA', 'Kec. Purwareja Klampok', 'MA');
INSERT INTO `sekolah` VALUES ('19FF5C73-428C-4A6A-9D79-62081F3469B7', '20303981', 'SMA NEGERI 1 PURWAREJA KLAMPOK', 'NEGERI', 'Kec. Purwareja Klampok', 'SMA');
INSERT INTO `sekolah` VALUES ('1B688A64-7946-4DB2-A39D-FC44CD617BA5', '20363500', 'MTSS TANBIHUL GHOFILIN', 'SWASTA', 'Kec. Bawang', 'MTs');
INSERT INTO `sekolah` VALUES ('1C3C9D63-F2FC-4C34-9923-2F1DE896F9A0', '60710692', 'MIS AL FATAH PARAKANCANGGAH', 'SWASTA', 'Kec. Banjarnegara', 'MI');
INSERT INTO `sekolah` VALUES ('1C9A7117-AE0B-45E1-A27B-29447333F278', '20303947', 'SMK AL FATAH BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMK');
INSERT INTO `sekolah` VALUES ('1D3B8E21-5871-4FAA-9DA6-D3F8E135A52C', '20363499', 'MTSS MUHAMMADIYAH BAWANG', 'SWASTA', 'Kec. Bawang', 'MTs');
INSERT INTO `sekolah` VALUES ('1FA20934-E00B-4451-9617-F64BB8698BF8', '70024929', 'MI Tahfidzul Qur`an Muhammadiyah Sumberejo', 'SWASTA', 'Kec. Batur', 'MI');
INSERT INTO `sekolah` VALUES ('20026823-03B6-E111-B67B-99F490077F62', '20347652', 'SMP NEGERI 4 SATU ATAP PAGENTAN', 'NEGERI', 'Kec. Pagentan', 'SMP');
INSERT INTO `sekolah` VALUES ('2009BA53-2DF5-E011-8624-FDF4E0B26C61', '20304115', 'SD NEGERI 1 KALILUNJAR', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('200BBE55-2DF5-E011-A73B-3302213F6506', '20303849', 'SD NEGERI 2 DUREN', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('2017CB55-2DF5-E011-84A7-19C709A75BB5', '20303752', 'SD NEGERI 2 SLATRI', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('2018BB55-2DF5-E011-A931-850133BF3C4B', '20304082', 'SD NEGERI 4 GUMIWANG', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('2019D255-2DF5-E011-BF6E-932DB9907214', '20304171', 'SD NEGERI 5 BATUR', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('2027C655-2DF5-E011-B357-D58B442ECD6B', '20304422', 'SD NEGERI 1 RAKIT', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('202ABA55-2DF5-E011-AD6A-21C1E6BAD5B9', '20304415', 'SD NEGERI 1 PUCUNGBEDUG', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('203020A3-05B6-E111-A684-396D9FE40C25', '20304122', 'SD NEGERI BLITAR', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('2031205A-2DF5-E011-8AD5-29F038DA5357', '20304007', 'SMP NEGERI 3 BAWANG', 'NEGERI', 'Kec. Bawang', 'SMP');
INSERT INTO `sekolah` VALUES ('2034BD55-2DF5-E011-874B-7172FC1A99EA', '20303702', 'SD NEGERI 2 WINONG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('203DCF55-2DF5-E011-85FB-39032007F11C', '20304641', 'SD NEGERI 1 KALITLAGA', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('2049BC55-2DF5-E011-9E6B-F7BB152B7FC0', '20304538', 'SD NEGERI 1 GEMURUH', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('204DC155-2DF5-E011-84C2-AB3175C30045', '20304614', 'SD NEGERI 1 KEMIRI', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('204FCF55-2DF5-E011-9983-831192FC9977', '20304573', 'SD NEGERI 1 GUMINGSIR', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('2050C855-2DF5-E011-9379-4BAF9B049879', '20304465', 'SD NEGERI 1 PETUGURAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('2052BA55-2DF5-E011-B8A6-B757A89DD77C', '20304554', 'SD NEGERI 1 KALIAJIR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('2053BD55-2DF5-E011-8BBB-F1DD0A103ED8', '20340961', 'SD NEGERI 2 MAJALENGKA', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('2055215A-2DF5-E011-80E4-552092A157B5', '20304021', 'SMP NEGERI 3 PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SMP');
INSERT INTO `sekolah` VALUES ('2059CE55-2DF5-E011-9E68-EBD6D77CF75C', '20303699', 'SD NEGERI 3 AMBAL', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('205BC755-2DF5-E011-8527-67D819C87199', '20304091', 'SD NEGERI 03 SITUWANGI', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('2068BB55-2DF5-E011-89AA-EDDE65CD309B', '20304170', 'SD NEGERI 6 MERDEN', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('2068D2B6-F8F4-42B3-91E8-184EBE318732', '60710727', 'MIN 3 BANJARNEGARA', 'NEGERI', 'Kec. Madukara', 'MI');
INSERT INTO `sekolah` VALUES ('206B1B59-2DF5-E011-81F8-B1E03920039A', '20304250', 'SD MUHAMMADIYAH 1 BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('206CAB5B-EDB9-E111-BADA-7539C92D9F6D', '20304598', 'SD NEGERI 1 BERTA', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('206CD555-2DF5-E011-86FC-2D86D8721BCD', '20303977', 'SD NEGERI SIRUKEM', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('206FD455-2DF5-E011-82D6-97865AB2BBF5', '20303742', 'SD NEGERI 2 TEMPURAN', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('2075C155-2DF5-E011-B977-57F5CD551DDA', '20303924', 'SD NEGERI 2 PANAWAREN', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('2079C355-2DF5-E011-A842-5349915A0412', '20304610', 'SD NEGERI 1 KESENET', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('207DBF55-2DF5-E011-8B37-CD1D51D3DBB9', '20304527', 'SD NEGERI 1 TLAGAWERA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('2082C155-2DF5-E011-B002-11E9B4CEA059', '20303815', 'SD Negeri 2 Sawal', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('2082F9AF-4E57-42F5-8CDD-EFA285B88CA5', '20277368', 'MAS AL FATAH BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'MA');
INSERT INTO `sekolah` VALUES ('2084D755-2DF5-E011-824B-1B1035FFCDC4', '20304125', 'SD NEGERI 2 BEJI', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('2086C655-2DF5-E011-A0CE-336561F20972', '20304532', 'SD NEGERI 1 TANJUNGANOM', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('2094B455-2DF5-E011-8E3C-1FCDBA7EA479', '20304165', 'SD NEGERI 7 GUMELEM WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('2098B755-2DF5-E011-A337-8F7EFBA78B08', '20338243', 'SD NEGERI 1 SALAMERTA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('209AD455-2DF5-E011-B236-C11CB028A3C8', '20304135', 'SD NEGERI 1 LEGOKSAYEM', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('20A1C055-2DF5-E011-963C-11C129117458', '20304594', 'SD NEGERI 1 BOJANEGARA', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('20A9B355-2DF5-E011-A984-8D8CAF992EC9', '20303785', 'SD NEGERI 3 KEMRANGGON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('20A9D055-2DF5-E011-BC16-0D3827EFDE2A', '20303830', 'SD NEGERI 2 KARANGSARI', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('20B0D155-2DF5-E011-A4C4-27D9DD25E1DB', '20304095', 'SD NEGERI 3 SIDENGOK', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('20B34304-885E-4B64-885D-3956115AB292', '70009097', 'MIS AL IRSYAD GUNUNGJATI', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('20B6B855-2DF5-E011-BCB4-AD898448D03A', '20338255', 'SD NEGERI 3 KEBANARAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('20B6D055-2DF5-E011-B8CE-27C850E63CFB', '20303965', 'SD NEGERI 1 SARWODADI', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('20BB215A-2DF5-E011-B0C7-3D5C91D09BA0', '20304004', 'SMP NEGERI 2 PEJAWARAN', 'NEGERI', 'Kec. Pejawaran', 'SMP');
INSERT INTO `sekolah` VALUES ('20BE3605-795B-416B-A6AC-B3C1D7FB1710', '60710793', 'MIS COKROAMINOTO 03 BONDOLHARJO', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('20BFB955-2DF5-E011-9C73-7B63C81EEAB2', '20303920', 'SD NEGERI 2 MERDEN', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('20BFD655-2DF5-E011-BD3B-7369577518D9', '20304093', 'SD NEGERI 3 SINDUAJI', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('20C6B355-2DF5-E011-B5C0-B9CE4321AB32', '20303836', 'SD NEGERI 2 KEDAWUNG', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('20C9BA55-2DF5-E011-A848-6BEA77E086C0', '20303786', 'SD NEGERI 3 KALIPELUS', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('20CCD655-2DF5-E011-9796-FB7FEB555702', '20303701', 'SD NEGERI 3 ASINAN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('20D3D455-2DF5-E011-BE00-8F31FA302F14', '20304537', 'SD NEGERI 1 KALIBENING', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('20D4C855-2DF5-E011-B136-D1494C0E693A', '20304548', 'SD NEGERI 1 DANAKERTA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('20D6BA55-2DF5-E011-9A31-1FF3EE143519', '20303794', 'SD NEGERI 3 GUMIWANG', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('20D7C555-2DF5-E011-AE0C-4FF744E17700', '20303919', 'SD NEGERI 2 MEDAYU', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('20D87C5A-2DF5-E011-92E8-67716A5553E4', '20303951', 'SMP MUHAMMADIYAH RAKIT', 'SWASTA', 'Kec. Rakit', 'SMP');
INSERT INTO `sekolah` VALUES ('20DBC955-2DF5-E011-A309-8F0E3402BE0B', '20304103', 'SD NEGERI 4 DANAKERTA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('20DEB855-2DF5-E011-91E4-E51D14CD1014', '20340833', 'SD NEGERI 5 SOMAWANGI', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('20E0D455-2DF5-E011-B44C-2FE5A263042B', '20304517', 'SD NEGERI 1 SIKUMPUL', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('20E8C955-2DF5-E011-B022-073FB04E17B9', '20304058', 'SD NEGERI 4 KARANGSARI', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('20F4BC55-2DF5-E011-84D5-67A2B414DB17', '20304427', 'SD NEGERI 1 SERANG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('20F4C255-2DF5-E011-BF0D-39E32FAA2C39', '20303894', 'SD NEGERI 2 RAKITAN', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('20F5C455-2DF5-E011-8A80-0FA7D8AA60BF', '20304626', 'SD NEGERI 1 LINGGASARI', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('22069D78-8181-4D64-825D-ADBD94756D1D', '20303985', 'SMA NEGERI 1 BAWANG', 'NEGERI', 'Kec. Bawang', 'SMA');
INSERT INTO `sekolah` VALUES ('22207F59-BDC8-485B-B79F-042825453AFF', '20350561', 'SMK MA`ARIF 01 KARANGKOBAR', 'SWASTA', 'Kec. Karangkobar', 'SMK');
INSERT INTO `sekolah` VALUES ('236D965E-81C8-4E91-9DAD-573D0B2663C7', '60710822', 'MIS MUHAMMADIYAH 01 PINGIT', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('24C645E3-5DD0-495C-B09C-D23192205022', '69983845', 'SD MUHAMMADIYAH BATUR', 'SWASTA', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('25269F5A-1635-460B-B040-66F1BC399469', '20303948', 'SMK COKROAMINOTO 1 BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMK');
INSERT INTO `sekolah` VALUES ('28563FBE-AE44-4DCB-A987-0D24C21E6C30', '60710863', 'MIS MUHAMMADIYAH LEGOKSAYEM', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('292E8C4E-3CBA-49D3-83D0-8A7DAC0A38FF', '70014011', 'MI PELITA INSANI', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('29DD2603-14FC-4370-8B36-47D556AF1A73', '20363505', 'MTSS MUHAMMADIYAH PETAMBAKAN', 'SWASTA', 'Kec. Madukara', 'MTs');
INSERT INTO `sekolah` VALUES ('2B1D8611-20B8-4AEC-A2D4-5EBB49121B46', '60710814', 'MIS MUHAMMADIYAH KALILANDAK', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('2D65AB55-6672-40C0-A77B-1D8F0CC266A1', '60726961', 'MIS MIFTAHUL MUBTADI`IN', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('2E1A86E2-A37C-4BDC-AAEA-13B5D8E2F5EE', '60710849', 'MIS AL HUDA DERMASARI', 'SWASTA', 'Kec. Susukan', 'MI');
INSERT INTO `sekolah` VALUES ('2E7628CA-041C-43AB-8BFC-40043951F4F5', '60710776', 'MIS MA`ARIF PEGUNDALAN', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('3001AA5A-2DF5-E011-8B04-957DA590D48A', '20303955', 'SMP COKROAMINOTO WANADADI', 'SWASTA', 'Kec. Wanadadi', 'SMP');
INSERT INTO `sekolah` VALUES ('3005CF55-2DF5-E011-9782-CFDB3D3D3991', '20340906', 'SD NEGERI 1 ARIBAYA', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('3006BF55-2DF5-E011-BA0C-531A184A97FD', '20303804', 'SD NEGERI 3 KEBUTUH DUWUR', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('3006D355-2DF5-E011-92A2-BBC7AA1CC9D5', '20303784', 'SD NEGERI 3 KEPAKISAN', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('3009CB55-2DF5-E011-BF14-C5E01E3CF65A', '20304475', 'SD NEGERI 1 PASURUHAN', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('3017D055-2DF5-E011-9C7D-4D2D5CEB30D8', '20303870', 'SD NEGERI 2 GUMINGSIR', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('3019D455-2DF5-E011-9B05-AD04B91196ED', '20303877', 'SD NEGERI 2 PESANTREN', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('3023CF55-2DF5-E011-B4BE-75ED468AF2ED', '20304632', 'SD NEGERI 1 LARANGAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('3031CB55-2DF5-E011-9724-33627DD403A2', '20303926', 'SD NEGERI 2 PAGERPELAH', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('3035B255-2DF5-E011-BAA3-8D689496676E', '20303746', 'SD NEGERI 2 SUSUKAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('3041B555-2DF5-E011-AEA8-09BC28AA06F6', '20303772', 'SD NEGERI 3 PURWAREJA', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('304D225A-2DF5-E011-8FE2-29C5BDBAA06F', '20341531', 'SMP NEGERI 2 SATU ATAP PAGEDONGAN', 'NEGERI', 'Kec. Pagedongan', 'SMP');
INSERT INTO `sekolah` VALUES ('304EC755-2DF5-E011-A523-E99534F65339', '20303814', 'SD NEGERI 3 GELANG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('3056C455-2DF5-E011-AA17-254C7DF9FEBF', '20303730', 'SD NEGERI 2 SIGEBLOG', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('305FBA55-2DF5-E011-B588-D3044F74D180', '20303862', 'SD NEGERI 2 KALIAJIR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('307581FF-AD9B-40F2-8215-6E8E17F063C1', '60710810', 'MIS ISLAMIYAH KALILANDAK', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('3075BE55-2DF5-E011-AE2C-B94C79E0FECC', '20304620', 'SD NEGERI 1 KUTABANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('30791B59-2DF5-E011-8666-D1117C96C100', '20304251', 'SD KRISTEN DEBORA', 'SWASTA', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('30799CC8-03B6-E111-8437-CF0200B996CE', '20351033', 'SMP NEGERI 4 SATAP PANDANARUM', 'NEGERI', 'Kec. Pandanarum', 'SMP');
INSERT INTO `sekolah` VALUES ('307EC455-2DF5-E011-AD99-DD2A0E87CA13', '20303767', 'SD NEGERI 3 KESENET', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('30871B59-2DF5-E011-9D2A-BF0094EFFD25', '20340876', 'SD ISLAM PLUS TUNAS BANGSA', 'SWASTA', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('3087BA55-2DF5-E011-98FD-8B16FA352A9B', '20304075', 'SD NEGERI 4 PURWONEGORO', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('3097BF55-2DF5-E011-A2C8-EFABB599FB79', '20304523', 'SD NEGERI 1 TWELAGIRI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('3098D655-2DF5-E011-8D5E-8D2422588ECA', '20303875', 'SD NEGERI 2 PINGITLOR', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('309DBE55-2DF5-E011-933B-8D7818753B20', '20304462', 'SD NEGERI 1 PARAKANCANGGAH', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('30A5CF55-2DF5-E011-B83F-2B2AF874C57B', '20303906', 'SD NEGERI 2 MAJASARI', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('30ABB555-2DF5-E011-87E7-D762D0933D2F', '20304647', 'SD NEGERI 1 KALILANDAK', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('30AFC055-2DF5-E011-801C-690DA15AE5AF', '20304418', 'SD NEGERI 1 PRIGI', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('30B9FDF8-05B6-E111-9718-3D15274AFCFE', '20303970', 'SD NEGERI 2 PENUSUPAN', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('30D0D055-2DF5-E011-8AA8-05C3C650BDE4', '20304551', 'SD NEGERI 1 GIRITIRTA', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('30D1BB55-2DF5-E011-8E50-E9801445C64D', '20304142', 'SD NEGERI 1 BANDINGAN', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('30FAB555-2DF5-E011-A1CA-A55E48E57EF7', '20304087', 'SD NEGERI 3 SIRKANDI', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('30FFBA53-FBB5-E111-B826-3B86475F5E08', '20344642', 'SMP NEGERI 5 SATU ATAP KALIBENING', 'NEGERI', 'Kec. Kalibening', 'SMP');
INSERT INTO `sekolah` VALUES ('3117D2E7-4841-44D7-905B-F61837EB0C17', '20277369', 'MAN 1 BANJARNEGARA', 'NEGERI', 'Kec. Bawang', 'MA');
INSERT INTO `sekolah` VALUES ('314BAD61-5C4B-4CCC-AEC3-D226B4A7B1C4', '60710820', 'MIS MUHAMMADIYAH KALITENGAH', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('31BF3E6F-DD29-48ED-B020-B1771A173FF6', '60710735', 'MIS AL MA `ARIF KEBAKALAN', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('32CD65CA-4848-468B-8496-99C48724DB86', '69980615', 'SMP ISLAM AL MUBAROK', 'SWASTA', 'Kec. Kalibening', 'SMP');
INSERT INTO `sekolah` VALUES ('33B15485-7FF9-4922-A2E7-5EFDB7CB699D', '60710688', 'MIS MUHAMMADIYAH SIPEDANG', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('349CBC8D-0EB5-4C33-8A56-4E990E60966F', '60710794', 'MI COKROAMINOTO 04 BONDOLHARJO', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('359BA0EF-A990-4303-BA63-C384D5DA2069', '60710740', 'MIS AL MA`ARIF PANGGISARI', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('36A9A046-DC4E-4F13-B561-0F7AFE013A1C', '70028669', 'SDIT AL-FATAH GUMELEM KULON', 'SWASTA', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('3971A1D9-9680-4BCE-B2D8-A0FF242D3DC6', '60710786', 'MIS GUPPI 01 JEMBANGAN', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('39D2D933-D278-4FD1-AD90-1E4E08DF5EF9', '60710853', 'MIS COKROAMINOTO 01 WANAKARSA', 'SWASTA', 'Kec. Wanadadi', 'MI');
INSERT INTO `sekolah` VALUES ('3ABA0A30-254E-4B2C-A45F-A8387764F14D', '20303979', 'SMA NEGERI 1 SIGALUH', 'NEGERI', 'Kec. Sigaluh', 'SMA');
INSERT INTO `sekolah` VALUES ('3AF8A3A2-697D-464E-8503-40DEFA4097F5', '20364907', 'MAS COKROAMINOTO PAGEDONGAN', 'SWASTA', 'Kec. Pagedongan', 'MA');
INSERT INTO `sekolah` VALUES ('3BC35A00-AF75-4BDE-A37B-E33AFE07113C', '60710710', 'MIS MUHAMMADIYAH WATUUURIP', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('3C48CA6B-3FE7-4FB6-91F1-0347DF57F445', '60710726', 'MIS GUPPI 02 DIWEK', 'SWASTA', 'Kec. Karangkobar', 'MI');
INSERT INTO `sekolah` VALUES ('3C636A94-769D-4CB3-A30D-A1E63A3885B1', '60710698', 'MIS MUHAMMADIYAH 03 BATUR', 'SWASTA', 'Kec. Batur', 'MI');
INSERT INTO `sekolah` VALUES ('3E48F293-B032-4CC9-BF8D-6A7F49E87625', '60710791', 'MIS COKROAMINOTO 01 BONDOLHARJO', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('3E886E7C-5DF6-40F5-B920-CB12658A4285', '60710847', 'MIS MIFTAHUNNAJAH PAKIKIRAN', 'SWASTA', 'Kec. Susukan', 'MI');
INSERT INTO `sekolah` VALUES ('3F70248E-FFBF-4080-89F1-F61D8DDAC099', '60710702', 'MIS MAARIF PUCANG', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('4000B455-2DF5-E011-A5EB-F96C00477697', '20303921', 'SD NEGERI 2 PANERUSAN WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('4001C355-2DF5-E011-95BF-6F3304499B1E', '20303756', 'SD NEGERI 3 PAKELEN', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('4002B355-2DF5-E011-90F9-C58B7D7576D5', '20340886', 'SD NEGERI 2 KARANGSALAM', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('4002BA55-2DF5-E011-9A50-1B29F7B4E5C1', '20303869', 'SD NEGERI 2 GUMIWANG', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('4003C555-2DF5-E011-A0A0-B5A41D115A94', '20304611', 'SD NEGERI 1 KEPAKISAN', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('4004D155-2DF5-E011-98F0-CBC037565C5C', '20303854', 'SD NEGERI 2 DARMAYASA', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('4007B655-2DF5-E011-ABC0-6104C26EF768', '20304146', 'SD NEGERI 5 PURWAREJA', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('400EC055-2DF5-E011-BD0D-A956EB840D80', '20303758', 'SD NEGERI 3 PAGEDONGAN', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('4011D155-2DF5-E011-A24F-BB04FDBC2DCD', '20304473', 'SD NEGERI 1 PEJAWARAN', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('4013B955-2DF5-E011-82E7-613A389F54E3', '20338261', 'SD NEGERI 4 GLEMPANG', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('4015CF55-2DF5-E011-82DC-21ADEADD6DB6', '20303991', 'SD NEGERI NAGASARI', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('4025D055-2DF5-E011-A307-27484A246277', '20303829', 'SD NEGERI 2 KARANGNANGKA', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('402BC555-2DF5-E011-AC9E-D546486A4D95', '20303817', 'SD NEGERI 2 KARANGKEMIRI', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('4030CF55-2DF5-E011-B6D7-11EA48DD5D3A', '20304420', 'SD NEGERI 1 PLUMBUNGAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('4033D055-2DF5-E011-90BC-7D4103B43F35', '20303808', 'SD NEGERI 3 KAREKAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('4034C655-2DF5-E011-8D7D-C9182F3EA8BC', '20304540', 'SD NEGERI 1 GELANG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('4044D455-2DF5-E011-8644-2F71439FB7BB', '20340903', 'SD NEGERI SUSUKAN. WANAYASA', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('4048BF55-2DF5-E011-8D70-61711FD3243A', '20304469', 'SD NEGERI 1 PESANGKALAN', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('4049C455-2DF5-E011-AEF5-B92274ED2E70', '20303792', 'SD NEGERI 3 JENGGAWUR', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('404AB355-2DF5-E011-8E9A-FD847D4A0D28', '20303969', 'SD NEGERI PIASA WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('404EB555-2DF5-E011-BBE0-973C91C5FFE2', '20304608', 'SD NEGERI 1 KLAMPOK', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('4056BC55-2DF5-E011-9C98-C570D0215475', '20304624', 'SD NEGERI 1 MAJALENGKA', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('4056C255-2DF5-E011-B342-8BC7A4992C72', '20304457', 'SD NEGERI PAGELAK', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('405DC355-2DF5-E011-BCE1-1159490CC15B', '20304557', 'SD NEGERI 1 JENGGAWUR', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('405ECA55-2DF5-E011-89F2-99111142B87C', '20304118', 'SD NEGERI GUMELAR', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('4060C555-2DF5-E011-B0C4-DFA82862C6BE', '20304638', 'SD NEGERI 1 KANDANGWANGI', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('4061B255-2DF5-E011-B982-893A3191ED63', '20303795', 'SD NEGERI 3 GUMELEM WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('4063C255-2DF5-E011-A38D-479225BEAECA', '20338910', 'SD NEGERI PENAWANGAN', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('4067CE55-2DF5-E011-A68E-45A929F033DF', '20303810', 'SD NEGERI 3 KARANGKOBAR', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('4068B455-2DF5-E011-9D69-AB1072A048B8', '20303768', 'SD NEGERI 3 PAKIKIRAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('406AC655-2DF5-E011-8E4C-BBB6F05C6C16', '20304159', 'SD NEGERI 1 ADIPASIR', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('4070C255-2DF5-E011-8D65-F75693D0DBC5', '20304114', 'SD NEGERI KARANGANYAR', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('4079D555-2DF5-E011-A369-7FC0758618BD', '20304643', 'SD NEGERI 1 KALISATKIDUL', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('407ED655-2DF5-E011-B4E0-2B3EC75F5E4C', '20303799', 'SD NEGERI 3 KALISATKIDUL', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('407FC955-2DF5-E011-B377-FDB471D423C6', '20303754', 'SD NEGERI 2 SAWANGAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('4088B855-2DF5-E011-8FF2-09FAD0D14736', '20340834', 'SD NEGERI 2 SIMBANG', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('408AB955-2DF5-E011-A4B3-CF4569C74F35', '20303855', 'SD NEGERI 2 DANARAJA', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('408ABF55-2DF5-E011-B053-DDB06B098764', '20303726', 'SD NEGERI 2 TLAGAWERA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('408CC955-2DF5-E011-AC76-A1DEF35E4FC5', '20304076', 'SD NEGERI 4 PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('408FC155-2DF5-E011-9488-3FC291AFB11A', '20304524', 'SD NEGERI 1 TUNGGORO', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('40929809-03B6-E111-A6D7-AF6737EAADC6', '20350557', 'SMP NEGERI 5 PAGENTAN', 'NEGERI', 'Kec. Pagentan', 'SMP');
INSERT INTO `sekolah` VALUES ('4095B855-2DF5-E011-8003-45BF44B50837', '20338265', 'SD NEGERI 4 PURWASABA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('4099B655-2DF5-E011-BF18-395EACB75CA7', '20304063', 'SD NEGERI 4 KALIMANDI', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('4099C955-2DF5-E011-9ECD-F535FFD0BD28', '20303715', 'SD NEGERI 3 DANAKERTA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('409FC855-2DF5-E011-887C-BFC704528E54', '20304656', 'SD NEGERI 1 KARANGSARI', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('40A2B855-2DF5-E011-A187-9108FA13BF87', '20338253', 'SD NEGERI 3 GLEMPANG', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('40AC48D6-DE49-40F1-A744-F3A3ACD28AF0', '20363530', 'MTSS MAARIF JATILAWANG', 'SWASTA', 'Kec. Wanayasa', 'MTs');
INSERT INTO `sekolah` VALUES ('40AD23D7-828A-4975-A5D8-5852538FF720', '69955966', 'MTsS MA`ARIF NU 01 SUSUKAN', 'SWASTA', 'Kec. Susukan', 'MTs');
INSERT INTO `sekolah` VALUES ('40ADCA55-2DF5-E011-B90E-09CFC50091EB', '20304453', 'SD NEGERI 1 PAGERPELAH', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('40AFBD55-2DF5-E011-A7E8-7148C0CA556F', '20303697', 'SD NEGERI 2 WIRAMASTRA', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('40B3B655-2DF5-E011-831A-8F2017F8F3CA', '20303759', 'SD NEGERI 3 PAGAK', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('40B8B555-2DF5-E011-BB67-1FD0FEA99303', '20303845', 'SD NEGERI 2 KALILANDAK', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('40BACA55-2DF5-E011-A5F1-8D1DC056B169', '20303911', 'SD NEGERI 2 LEKSANA', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('40BDD155-2DF5-E011-86A2-9F8D483BEA04', '20303860', 'SD NEGERI 2 GROGOL', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('40C5B555-2DF5-E011-8FCF-1925FF794D01', '20304616', 'SD NEGERI 1 KECITRAN', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('40C7205A-2DF5-E011-A6E0-CF99AA721A9D', '20304032', 'SMP NEGERI 1 BANJARMANGU', 'NEGERI', 'Kec. Banjarmangu', 'SMP');
INSERT INTO `sekolah` VALUES ('40C7CA55-2DF5-E011-B49D-678DED68608A', '20303822', 'SD NEGERI 2 KARANGKOBAR', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('40CC82CF-5684-4F3C-98B3-4AE9A776DA16', '20303946', 'SMA NEGERI 1 WANADADI', 'NEGERI', 'Kec. Wanadadi', 'SMA');
INSERT INTO `sekolah` VALUES ('40D1B655-2DF5-E011-B3F2-F9E523096B03', '20337878', 'SD NEGERI 1 MANDIRAJA WETAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('40D1D355-2DF5-E011-9AE6-D7CE289D026E', '20304592', 'SD NEGERI 1 BANTAR', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('40D4D555-2DF5-E011-8E7B-DFE0CE66919F', '20303868', 'SD NEGERI 2 GUNUNGLANGIT', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('40D556FA-FBB5-E111-87B9-25A7B15D2719', '20353750', 'SMP NEGERI 3 SATAP KARANGKOBAR', 'NEGERI', 'Kec. Karangkobar', 'SMP');
INSERT INTO `sekolah` VALUES ('40D9BF55-2DF5-E011-B816-DDDF8C4E22F9', '20303867', 'SD NEGERI 2 GUNUNGJATI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('40D9D655-2DF5-E011-A7F4-C70F94C25E64', '20304094', 'SD NEGERI 3 SIKUMPUL', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('40DAB755-2DF5-E011-A6BA-EF035228F163', '20338245', 'SD NEGERI 1 SOMAWANGI', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('40DEBB55-2DF5-E011-8516-63E7BD94BF68', '20304602', 'SD NEGERI 1 BAWANG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('40E1C855-2DF5-E011-8836-8DCB8E3F2D49', '20303856', 'SD NEGERI 2 DANAKERTA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('40E1D555-2DF5-E011-AE74-F3435DADD3A0', '20340909', 'SD NEGERI 2 KARANGANYAR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('40E4C055-2DF5-E011-ABE5-EF5A8E3E256C', '20304507', 'SD NEGERI WANACIPTA', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('40EBB855-2DF5-E011-8E4F-6FEC88287CC9', '20338254', 'SD NEGERI 3 JALATUNDA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('40ECB655-2DF5-E011-99EF-4D7AA0E6B1D5', '20338240', 'SD NEGERI 1 MANDIRAJA KULON', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('40EED555-2DF5-E011-AFDC-E1271163E8DE', '20303887', 'SD NEGERI 2 PLORENGAN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('40F1C055-2DF5-E011-9412-793B3B35A556', '20304553', 'SD NEGERI 1 KALIBENDA', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('40F8CE55-2DF5-E011-B3DC-4785F7C17C91', '20304141', 'SD NEGERI KAYUARES', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('40FBD555-2DF5-E011-B884-772077F07A65', '20303733', 'SD NEGERI 2 SIDAKANGEN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('40FCD355-2DF5-E011-AB93-4B7089BE3210', '20303927', 'SD NEGERI 2 PAGERGUNUNG', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('41D2D5B6-8800-4F61-B04F-3D90AC657F8A', '60710738', 'MIS AL MA`ARIF SALAMERTA', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('42F4C7AB-6AC4-4422-B0C8-C17215AEFA67', '60710789', 'MIS COKROAMINOTO 01 BADAKARYA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('42F97698-5814-46EF-A8CF-2B29052E6641', '60710787', 'MIS GUPPI 02 JEMBANGAN', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('44A457A0-181E-4D06-97BF-F23A38BD75B5', '60710813', 'MIS MUHAMMADIYAH PAGAK', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('47476F4E-0B3C-482A-B13C-ABD1D6997A0C', '60710772', 'MIS MUHAMMADIYAH PEKANDANGAN', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('474CBFB5-B905-4C47-A8CB-831AA0DDEECE', '60710875', 'MIS MA`ARIF SIRAWA', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('483CE101-AFAC-4310-8F96-F87FDCB7E14C', '60710757', 'MIS MUHAMMADIYAH WATUBELAH', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('48897F56-8DD8-4823-BCCF-E770AF43E864', '20363508', 'MTSS MUHAMMADIYAH MANDIRAJA', 'SWASTA', 'Kec. Mandiraja', 'MTs');
INSERT INTO `sekolah` VALUES ('4926E207-6906-4A31-A0C1-F0227B1AE2E9', '60710803', 'MIS COKROAMINOTO 02 TRIBUANA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('4AB11BB7-4ABD-434D-923F-20FCF315D953', '60710846', 'MIS MUHAMMADIYAH BOJANEGARA', 'SWASTA', 'Kec. Sigaluh', 'MI');
INSERT INTO `sekolah` VALUES ('4DA6C5F3-F16F-46BB-A3C7-67477CE71F0C', '60710753', 'MIS COKROAMINOTO SAYANGAN', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('4E616764-76BF-4F46-B536-42EE17984282', '70039733', 'SMK NEGERI 1 PAGENTAN', 'NEGERI', 'Kec. Pagentan', 'SMK');
INSERT INTO `sekolah` VALUES ('4EEE588C-B638-43A5-9653-77A1CDDABFA4', '69845929', 'SMK KESEHATAN BHAKTI HUSADA', 'SWASTA', 'Kec. Purwareja Klampok', 'SMK');
INSERT INTO `sekolah` VALUES ('4F241187-CDBE-447D-AA82-C991D2DAB90C', '20363502', 'MTSS MUHAMMADIYAH 02 KALIBENING', 'SWASTA', 'Kec. Kalibening', 'MTs');
INSERT INTO `sekolah` VALUES ('500EC355-2DF5-E011-A835-5FD04A2AEA22', '20304576', 'SD NEGERI 1 CENDANA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('501BC055-2DF5-E011-A93D-2B2134269E18', '20303703', 'SD NEGERI 2 WANGON', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('5021D355-2DF5-E011-BE5B-3B7082823694', '20304468', 'SD NEGERI 1 PESANTREN', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('502467D7-8DFC-E111-83E3-5FC46027E83D', '20303821', 'SD Negeri 2 Karanganyar', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('5024CB55-2DF5-E011-9DA3-978B18F503E5', '20304482', 'SD NEGERI 2 AMBAL', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('5030D355-2DF5-E011-9679-E3A7330B91CE', '20340960', 'SD NEGERI 1 JATILAWANG', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('503910BC-7E60-4845-98C3-E3CB44699864', '60710705', 'MIS COKROAMINOTO BANDINGAN', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('504466D7-8DFC-E111-91F3-07427A6E8102', '20304417', 'SD Negeri 1 Pringamba', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('5044CA55-2DF5-E011-930A-0792BE118103', '20304661', 'SD NEGERI 1 KARANGKOBAR', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('504D019B-07B6-E111-BB75-BD2149384AC9', '20338493', 'SMP NEGERI 4 WANAYASA', 'NEGERI', 'Kec. Wanayasa', 'SMP');
INSERT INTO `sekolah` VALUES ('504DD055-2DF5-E011-A9CD-850435C8A238', '20340907', 'SD NEGERI 2 KALITLAGA', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('5055B955-2DF5-E011-9D21-3582E1CB570F', '20304412', 'SD NEGERI 1 PURWONEGORO', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('5060BD55-2DF5-E011-97EB-BF8927489291', '20303706', 'SD NEGERI 2 WANADRI', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('5070B255-2DF5-E011-B3DC-55D06A4C4BC5', '20304575', 'SD NEGERI 1 GUMELEM KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('507F215A-2DF5-E011-864C-27F533017303', '20304005', 'SMP NEGERI 2 PAGENTAN', 'NEGERI', 'Kec. Pagentan', 'SMP');
INSERT INTO `sekolah` VALUES ('5081DF55-7EF2-E111-8C3E-C1593121FFF6', '20303902', 'SD NEGERI 2 PRINGAMBA', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('5086C355-2DF5-E011-B891-35CE59EBDDDE', '20303972', 'SD NEGERI PEKANDANGAN', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('5089CF55-2DF5-E011-9AF0-A34845F97E4E', '20303751', 'SD NEGERI 2 SOKARAJA', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('5093C655-2DF5-E011-B60F-9F6046DD297A', '20304581', 'SD NEGERI 1 BADAMITA', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('509CB255-2DF5-E011-A4B3-8D4F93ADE0E1', '20304663', 'SD NEGERI 1 KARANGJATI', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('50A5D655-2DF5-E011-9905-7FD3958A82E6', '20303790', 'SD NEGERI 3 KALIBOMBONG', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('50CCB955-2DF5-E011-AF32-213D80076B9D', '20304642', 'SD NEGERI 1 KALITENGAH', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('50E1C755-2DF5-E011-A7E2-1BDF0FCF2825', '20304106', 'SD NEGERI 4 BANDINGAN', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('50E6D655-2DF5-E011-AC6C-C130E3CA4DCB', '20304061', 'SD NEGERI 4 KALISATKIDUL', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('50E866D7-8DFC-E111-93BB-41805E0F4D81', '20304636', 'SD Negeri 1 Karanganyar', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('50EACE55-2DF5-E011-8571-E1034631EA6E', '20304654', 'SD NEGERI 1 KAREKAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('50ECC155-2DF5-E011-A640-157D50457FE3', '20304640', 'SD NEGERI 1 KALIURIP', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('50EDC353-2DF5-E011-9EBF-376F9A2E84D0', '20303839', 'SD NEGERI 2 KEBONDALEM.', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('50FBC755-2DF5-E011-902C-5DA7630687C7', '20304414', 'SD NEGERI 1 PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('51951C7B-6B7C-44C0-9AFD-30B84EF737A1', '60710711', 'MIS AL FATAH MAJALENGKA', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('5252B8CA-5C98-4D71-BB58-811383EE4B8E', '20303949', 'SMK COKROAMINOTO 2 BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMK');
INSERT INTO `sekolah` VALUES ('53174049-FDC6-4CB9-BA43-3A7991B37CDB', '60710836', 'MIS COKROAMINOTO 01 BADAMITA', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('5370BB23-1830-441C-934D-B304BA22259F', '20303938', 'SMK HKTI 2 PURWAREJA KLAMPOK', 'SWASTA', 'Kec. Purwareja Klampok', 'SMK');
INSERT INTO `sekolah` VALUES ('53DAADE0-A002-4103-BEF7-07005CA44844', '60710832', 'MIS COKROAMINOTO ADIPASIR', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('54054388-F529-4BD9-B8F1-B96C6E181A23', '60710825', 'MIS NU 01 SITUWANGI', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('55631EC3-4312-42A9-9A32-18F04192ED95', '60710773', 'MIS MUHAMMADIYAH TLODAS', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('55785C70-8DD1-4A14-BFDB-647E3691284A', '60710798', 'MIS MUHAMMADIYAH 01 DANAKERTA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('55FF242D-A883-4A95-B5D9-E14807211D65', '20363514', 'MTsS RAUDLATUTHOLIBIN SEMANGKUNG', 'SWASTA', 'Kec. Pejawaran', 'MTs');
INSERT INTO `sekolah` VALUES ('563EB08C-5E6C-4AE0-864A-BCD188C44A75', '60710783', 'MIS COKROAMINOTO 02 PETUGURAN', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('56895EFF-DEBF-4BE1-A1DF-A1912FE90061', '60710831', 'MIS ISLAMIYAH 02 RAKIT', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('58598F56-9636-4D78-98B5-A7EFD048FFD2', '69900169', 'SMK MAARIF NU 01 AL MUBAROK', 'SWASTA', 'Kec. Kalibening', 'SMK');
INSERT INTO `sekolah` VALUES ('589F4C3F-F0E2-4671-AB81-8E8030831C3C', '70010536', 'SMK Muhammadiyah Karangkobar', 'SWASTA', 'Kec. Karangkobar', 'SMK');
INSERT INTO `sekolah` VALUES ('58C4602E-72BE-4B5C-AFFF-234735815AEC', '20363497', 'MTSS AL FATAH BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'MTs');
INSERT INTO `sekolah` VALUES ('5A48BE01-0A55-4CA7-AA20-3DE1D87248AC', '20363503', 'MTSS MUHAMMADIYAH KARANGKOBAR', 'SWASTA', 'Kec. Karangkobar', 'MTs');
INSERT INTO `sekolah` VALUES ('5A913362-CCDC-44E4-9291-32D6BD88C4E6', '69774957', 'SMK NEGERI 1 PEJAWARAN', 'NEGERI', 'Kec. Pejawaran', 'SMK');
INSERT INTO `sekolah` VALUES ('5A9C1C8E-35EF-4E16-98F1-F88CD8E0A93D', '60710708', 'MIS GUPPI WINONG', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('5B0CAA65-C253-4881-8398-7B9AD85FE1F0', '60710756', 'MI MA`ARIF DAGANSARI', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('5B67113F-7D5D-4459-9A10-DC94613FC8A9', '60710818', 'MIS MUHAMMADIYAH MERTASARI', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('5B8CBF46-76CC-4492-A91B-6D38A95F825D', '20363516', 'MTSS COKROAMINOTO TANJUNGTIRTA', 'SWASTA', 'Kec. Punggelan', 'MTs');
INSERT INTO `sekolah` VALUES ('5BF940CF-0A40-4A61-9D6E-B0A19E63BB05', '70005597', 'SDIT AL IHSAN BANJARNEGARA', 'SWASTA', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('5E409552-B781-4688-873D-D23395A5F1D9', '60710796', 'MI GUPPI 02 TLAGA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('5E56214C-B7B8-48A9-82A8-673B8FFDA82D', '60710874', 'MIS MUHAMMADIYAH PIASA', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('5FDFCDE0-9CBF-4CC4-87C5-06E8FF7A05E4', '60710812', 'MIS ISLAMIYAH KALIMANDI', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('6002B855-2DF5-E011-8A84-431B067CB9E2', '20338237', 'SD NEGERI 1 KEBAKALAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('6005225A-2DF5-E011-873A-4F80452D1E8F', '20304028', 'SMP NEGERI 1 KALIBENING', 'NEGERI', 'Kec. Kalibening', 'SMP');
INSERT INTO `sekolah` VALUES ('600766D7-8DFC-E111-A72B-6D50E3771E08', '20304590', 'SD NEGERI 1 BANDINGAN', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('600BC155-2DF5-E011-A85B-2DCDF785D77E', '20304433', 'SD NEGERI 1 SAWAL', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('600CD255-2DF5-E011-9202-5D5FBFC1A3C0', '20304105', 'SD NEGERI 4 BATUR', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('6017BD55-2DF5-E011-8B11-6D040258F1A9', '20303912', 'SD NEGERI 2 LEBAKWANGI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('6021BC55-2DF5-E011-9045-1B04064090A5', '20340891', 'SD NEGERI 1 DEPOK', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('6022225A-2DF5-E011-B6E7-35A186CBD7EA', '20304015', 'SMP NEGERI 4 KALIBENING', 'NEGERI', 'Kec. Kalibening', 'SMP');
INSERT INTO `sekolah` VALUES ('6028C055-2DF5-E011-94FB-49090D19A0B5', '20304157', 'SD NEGERI 6 KEBUTUHDUWUR', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('602DB355-2DF5-E011-9F7E-BF782A039850', '20304478', 'SD NEGERI 2 BRENGKOK', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('6037B855-2DF5-E011-AD39-8914D4AAB2E2', '20338250', 'SD NEGERI 2 KEBAKALAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('6037BA55-2DF5-E011-95B8-698071A0A1BD', '20303900', 'SD NEGERI 2 PUCUNGBEDUG', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('6038C555-2DF5-E011-96E8-41385C2FA437', '20304653', 'SD NEGERI 1 KASILIB', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('603DC855-2DF5-E011-A86E-8BD000712B39', '20304531', 'SD NEGERI 1 TANJUNGTIRTA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('603DC955-2DF5-E011-8A8E-D32CCE5DC8F0', '20303744', 'SD NEGERI 2 TANJUNGTIRTA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('6040D055-2DF5-E011-ACD6-11279E280B12', '20303710', 'SD NEGERI 3 BABADAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('6041C655-2DF5-E011-B276-89743762CD93', '20304511', 'SD NEGERI 1 SITUWANGI', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('6043C355-2DF5-E011-A8DF-15CB64519EA2', '20304514', 'SD NEGERI 1 SIPEDANG', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('6048B955-2DF5-E011-A3FA-1B9B7075314F', '20338262', 'SD NEGERI 4 JALATUNDA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('604DD355-2DF5-E011-846E-579BB35DBCE3', '20304451', 'SD NEGERI 1 PANDANSARI', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('604EC655-2DF5-E011-B261-7D43B739683A', '20304438', 'SD NEGERI 1 PINGIT', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('6050205A-2DF5-E011-BE84-0DB1742F6E7C', '20304043', 'SMP NEGERI 2 BANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('60574DC9-04B6-E111-BE36-FF669A02D1A2', '20340303', 'SMP NEGERI 5 SATAP PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SMP');
INSERT INTO `sekolah` VALUES ('6059B455-2DF5-E011-9824-3D31AA5D00AA', '20303725', 'SD NEGERI 3 DERIK', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('605BB555-2DF5-E011-BB4C-21E940876C71', '20303933', 'SD NEGERI 2 KLAMPOK', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('605DC855-2DF5-E011-BF8D-4967AAA78C50', '20304528', 'SD NEGERI 1 TLAGA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('6063BC55-2DF5-E011-9D97-5FFC0264CCA0', '20304130', 'SD NEGERI 1 MASARAN', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('6067B355-2DF5-E011-9C9B-5F3237649518', '20304660', 'SD NEGERI 1 KARANGMANGU', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('606AC855-2DF5-E011-93A9-555B34BFFEEB', '20304460', 'SD NEGERI 1 MLAYA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('6071215A-2DF5-E011-BD30-01522D56ADCF', '20304037', 'SMP NEGERI 1 PAGENTAN', 'NEGERI', 'Kec. Pagentan', 'SMP');
INSERT INTO `sekolah` VALUES ('6074D055-2DF5-E011-B879-6DB44F1BF85B', '20340962', 'SD NEGERI 3 PLUMBUNGAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('6079C055-2DF5-E011-9B77-D303F77FB572', '20303750', 'SD NEGERI 2 SOKAYASA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('60841F5A-2DF5-E011-A156-7333AC9D48D4', '20303998', 'SMP NEGERI 2 PURWOREJO KLAMPOK', 'NEGERI', 'Kec. Purwareja Klampok', 'SMP');
INSERT INTO `sekolah` VALUES ('6086C055-2DF5-E011-998E-7DCC134B9D4F', '20304519', 'SD NEGERI 1 SIGALUH', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('6086D555-2DF5-E011-95CB-D33E6E27C5CE', '20304635', 'SD NEGERI 1 KALIBOMBONG', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('6088D355-2DF5-E011-8E8E-E5B4BBA52235', '20303978', 'SD NEGERI 1 SUWIDAK', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('60921F5A-2DF5-E011-8581-5DB9C64A8340', '20304020', 'SMP NEGERI 3 PURWOREJO KLAMPOK', 'NEGERI', 'Kec. Purwareja Klampok', 'SMP');
INSERT INTO `sekolah` VALUES ('6097B955-2DF5-E011-9852-89F9C2A52440', '20304461', 'SD NEGERI 1 MERTASARI', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('609828CC-EFB5-E111-B004-85837CD75C18', '20351013', 'SMP NEGERI 6 SATU ATAP BANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('60A2C555-2DF5-E011-897F-A7730BB7B58B', '20303841', 'SD NEGERI 2 KASILIB', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('60A39A61-FBB5-E111-BA9A-5D0F16788E74', '20362358', 'SMP NEGERI 6 SATU ATAP KALIBENING', 'NEGERI', 'Kec. Kalibening', 'SMP');
INSERT INTO `sekolah` VALUES ('60A5B755-2DF5-E011-AD17-C7C5DC67CE92', '20338238', 'SD NEGERI 1 KEBANARAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('60A6B655-2DF5-E011-89AB-5D379DFFE069', '20304056', 'SD NEGERI 4 KECITRAN', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('60A9A95A-2DF5-E011-AA4C-F9354AB1F05A', '20304036', 'SMP PGRI PURWOREJO KLAMPOK', 'SWASTA', 'Kec. Purwareja Klampok', 'SMP');
INSERT INTO `sekolah` VALUES ('60B0C655-2DF5-E011-A416-1F7820C88B94', '20304627', 'SD NEGERI 1 LENGKONG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('60B2D655-2DF5-E011-931F-8F0D7CF2F9CC', '20304479', 'SD NEGERI 2 ASINAN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('60BAD555-2DF5-E011-B469-2D2E5A0AFD1B', '20304463', 'SD NEGERI 1 PASEGERAN', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('60C7D555-2DF5-E011-BD40-6D6857DAFF52', '20304437', 'SD NEGERI 1 PINGITLOR', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('60C87C5A-2DF5-E011-8073-0BF6892CEDA8', '20304035', 'SMP PGRI SUSUKAN', 'SWASTA', 'Kec. Susukan', 'SMP');
INSERT INTO `sekolah` VALUES ('60D3CE55-2DF5-E011-9551-ADD452C88B66', '20304582', 'SD NEGERI 1 BABADAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('60D5C355-2DF5-E011-B0CC-D3F6FD525EBF', '20303964', 'SD NEGERI SIJENGGUNG', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('60DABC55-2DF5-E011-9829-71AF4EE66DB6', '20304541', 'SD NEGERI 1 DUREN', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('60DAC455-2DF5-E011-94DB-0953F22B5019', '20304650', 'SD NEGERI 1 KARANGJAMBE', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('60E5B255-2DF5-E011-9D88-37217971FA36', '20304450', 'SD NEGERI 1 PANERUSAN WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('60EEC755-2DF5-E011-A2F1-21B86976DF9A', '20304054', 'SD NEGERI 5 BANDINGAN', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('60F2205A-2DF5-E011-B2D7-D72FCFD0B3BA', '20303995', 'SMP NEGERI 2 WANADADI', 'NEGERI', 'Kec. Wanadadi', 'SMP');
INSERT INTO `sekolah` VALUES ('60F87B1D-3A25-E111-A199-AB7ED113023E', '20304595', 'SD NEGERI 1 BLAMBANGAN', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('60F9B655-2DF5-E011-A9CD-07ADE5A12467', '20338256', 'SD NEGERI 3 KERTAYASA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('60FEC055-2DF5-E011-A39A-A31C0F279CF9', '20304539', 'SD NEGERI 1 GEMBONGAN', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('60FFC655-2DF5-E011-96A3-8D2ED37F7BB5', '20303743', 'SD NEGERI 2 TANJUNGANOM', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('61E8F104-8B2C-44A3-A74E-39BF6AD4DE1C', '20363520', 'MTSS ATH THAHIRIYAH PUCUNGBEDUG', 'SWASTA', 'Kec. Purwanegara', 'MTs');
INSERT INTO `sekolah` VALUES ('64803AB4-C015-4A5F-BF96-ECF9D11932D9', '20363507', 'MTSS AL MAARIF MANDIRAJA', 'SWASTA', 'Kec. Mandiraja', 'MTs');
INSERT INTO `sekolah` VALUES ('651D510A-0414-4155-9065-53E588974D28', '20363518', 'MTSS RIYADUSH SHOLIHIN PURWAREJA KLAMPOK', 'SWASTA', 'Kec. Purwareja Klampok', 'MTs');
INSERT INTO `sekolah` VALUES ('666851C6-A330-4DCE-B665-D437CDD4BB6D', '60710681', 'MIS COKROAMINOTO REJASARI', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('66702928-E99A-416A-8D4E-A24FFA2AC355', '20304578', 'SD NEGERI 1 BANDINGAN', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('667705C7-F03E-4642-8B8A-95B0C235C53A', '60710745', 'MIS MUHAMMADIYAH BANJENGAN', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('67369233-5BA5-4A50-A198-8EE68B5FFE52', '60710790', 'MI COKROAMINOTO 2 BADAKARYA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('6764841C-0C31-40FC-8C55-BE67B2304D09', '60710801', 'MIS MAARIF KLAPA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('678E221A-0A68-4371-81AF-1765D6791E45', '60710763', 'MIS GUPPI PAGENTAN', 'SWASTA', 'Kec. Pagentan', 'MI');
INSERT INTO `sekolah` VALUES ('67AD4530-1BEE-4154-BC56-2FDB820D9712', '60710696', 'MI MUHAMMADIYAH 01 BATUR', 'SWASTA', 'Kec. Batur', 'MI');
INSERT INTO `sekolah` VALUES ('67CDB0D2-B892-4B5D-A07C-E7F1DAAD7100', '60710816', 'MIS MUHAMMADIYAH KALIAJIR', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('6825245D-16AD-41A5-845A-DFF6D3690031', '20364904', 'MAS COKROAMINOTO KARANGKOBAR', 'SWASTA', 'Kec. Karangkobar', 'MA');
INSERT INTO `sekolah` VALUES ('686E97A3-579C-4D7F-A39B-C690FA6B9621', '60710856', 'MIS MUHAMMADIYAH GUMINGSIR', 'SWASTA', 'Kec. Wanadadi', 'MI');
INSERT INTO `sekolah` VALUES ('69A6A031-70A6-4857-9336-BC94059FD335', '20362362', 'SMK BINA MANDIRI PURWAREJA KLAMPOK', 'SWASTA', 'Kec. Purwareja Klampok', 'SMK');
INSERT INTO `sekolah` VALUES ('6A6D4238-5070-4922-879F-7D9462BDD090', '69988631', 'SD NEGERI 4 TLAGA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('6B7605E5-0D7E-4909-AD46-F366A50811E4', '60710747', 'MIS COKROAMINOTO 01 LEBAKWANGI', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('6DF6402E-28ED-4472-A584-0204039192F2', '20350566', 'SMK NEGERI 1 WANAYASA', 'NEGERI', 'Kec. Wanayasa', 'SMK');
INSERT INTO `sekolah` VALUES ('6EF3E567-5A53-44DB-866D-5E2CDA84E002', '60710751', 'MIS COKROAMINOTO DUREN', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('6F7A965D-007C-4FF1-A3A8-EB102C5E8E13', '60710824', 'MIS MUHAMMADIYAH 03 PINGIT', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('7005BC55-2DF5-E011-8BF9-7504EC386CF1', '20304490', 'SD NEGERI 1 WANADRI', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('700FCA55-2DF5-E011-92D6-971782D95D66', '20304078', 'SD NEGERI 4 PETUGURAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('7018C155-2DF5-E011-A59C-DB54D2FE9113', '20304424', 'SD NEGERI 1 RANDEGAN', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('701A0687-01B6-E111-93AA-5F399C04982A', '20360849', 'SMP NEGERI 3 PAGEDONGAN', 'NEGERI', 'Kec. Pagedongan', 'SMP');
INSERT INTO `sekolah` VALUES ('701D215A-2DF5-E011-8F6F-139C78F61D17', '20304024', 'SMP NEGERI 2 KARANGKOBAR', 'NEGERI', 'Kec. Karangkobar', 'SMP');
INSERT INTO `sekolah` VALUES ('7021C255-2DF5-E011-B8B6-59A4BB106C23', '20304549', 'SD NEGERI 1 CLAPAR', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('7025BE55-2DF5-E011-9373-43724474F268', '20304607', 'SD NEGERI 1 KRANDEGAN', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('7026D255-2DF5-E011-80A6-EF30C3202104', '20304521', 'SD NEGERI 1 SUMBEREJO', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('7030C855-2DF5-E011-B9BD-1D424346E96E', '20304494', 'SD NEGERI 2 BONDOLHARJO', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('7032BB55-2DF5-E011-A4F1-6D6FB0467241', '20303779', 'SD NEGERI 3 PETIR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('7035D755-2DF5-E011-8FF0-C36A7350E3CD', '20304631', 'SD NEGERI 1 LAWEN', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('704F2A0F-EDB9-E111-871B-9D85BD6940C5', '20304621', 'SD NEGERI 1 KUTAWULUH', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('7051CA55-2DF5-E011-B8E2-F55532E7F6D7', '20304510', 'SD NEGERI 01 SLATRI', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('705AC155-2DF5-E011-8CA3-4790B9DA2F24', '20303727', 'SD NEGERI 2 SINGAMERTA', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('7062B955-2DF5-E011-9A87-D99B6EAEEA70', '20303898', 'SD NEGERI 2 PURWONEGORO', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('706BD355-2DF5-E011-A42C-CD169318638B', '20304637', 'SD NEGERI 1 KARANGTENGAH', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('7074CE55-2DF5-E011-9075-57AB8F5CF857', '20303722', 'SD NEGERI 3 BINANGUN', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('7077C655-2DF5-E011-B22C-E5A9793F79A9', '20304609', 'SD NEGERI 1 KINCANG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('7077C755-2DF5-E011-9D97-AB0DDBF77F98', '20304107', 'SD NEGERI 4 ADIPASIR', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('707DD455-2DF5-E011-A379-EDDC30B1F80D', '20304066', 'SD NEGERI 4 JATILAWANG', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('7082BB55-2DF5-E011-8D2C-2FA49340AF81', '20304079', 'SD NEGERI 4 PETIR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('7085B455-2DF5-E011-955F-153E9D0B3D90', '20304156', 'SD NEGERI 6 GUMELEM WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('7093C355-2DF5-E011-A71C-3FCD9FFC972C', '20339227', 'SD NEGERI 1 BANJARKULON', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('7095D155-2DF5-E011-8ABA-691C0F101DA8', '20303737', 'SD NEGERI 2 SEMANGKUNG', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('709CBB55-2DF5-E011-A8E0-9548DA500741', '20304148', 'SD NEGERI 5 PETIR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('709FC755-2DF5-E011-9B86-D95DBF7CA79E', '20304069', 'SD NEGERI 4 LENGKONG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('70A0C655-2DF5-E011-889C-851C5FE1B5BA', '20304492', 'SD NEGERI 2 BADAMITA', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('70A0D555-2DF5-E011-B3CD-4B8FDE31176A', '20304583', 'SD NEGERI 1 ASINAN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('70B7B355-2DF5-E011-8CD9-FFFF9161B7B9', '20304085', 'SD NEGERI 3 SUSUKAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('70B9B255-2DF5-E011-A3DD-F1C229966FCE', '20304140', 'SD NEGERI 1 KEMRANGGON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('70C0C455-2DF5-E011-86DD-651108B4D3CC', '20304117', 'SD NEGERI GUMINGSIR', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('70CCC255-2DF5-E011-A64B-7F4F918B235F', '20303873', 'SD NEGERI 2 CLAPAR', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('70D6B255-2DF5-E011-8AED-45869E5F728C', '20304470', 'SD NEGERI 1 PANERUSAN KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('70D7004A-6D2B-E111-9E0C-596294B95610', '20340910', 'SD IT MUTIARA HATI', 'SWASTA', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('70EBBB55-2DF5-E011-80F9-3F5C75E086E3', '20304596', 'SD NEGERI 1 BINORONG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('70EC0E48-04B6-E111-BA02-BB3549231D29', '20339186', 'SMP NEGERI 3 SATAP PEJAWARAN', 'NEGERI', 'Kec. Pejawaran', 'SMP');
INSERT INTO `sekolah` VALUES ('70F5215A-2DF5-E011-BF1A-1915102AE6BA', '20303994', 'SMP NEGERI 2 WANAYASA', 'NEGERI', 'Kec. Wanayasa', 'SMP');
INSERT INTO `sekolah` VALUES ('70F9C155-2DF5-E011-8925-333A91567E9E', '20304571', 'SD NEGERI 1 GUNUNGGIANA', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('7118A353-8560-4850-A238-9D5987304F0F', '70015835', 'SDIT BINA INSAN BANJARNEGARA', 'SWASTA', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('71917A03-0191-4F5E-87A6-6C2775BD7A65', '60710858', 'MIS COKROAMINOTO KARANGKEMIRI', 'SWASTA', 'Kec. Wanadadi', 'MI');
INSERT INTO `sekolah` VALUES ('7228399E-ADBD-4597-A0C6-FD72656440D5', '60710804', 'MIS COKROAMINOTO 03 TRIBUANA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('728A6B28-4E68-4C2B-93B5-5EBA57B57231', '20363512', 'MTSS NURUL HUDA PAGEDONGAN', 'SWASTA', 'Kec. Pagedongan', 'MTs');
INSERT INTO `sekolah` VALUES ('72ACA62A-8FAE-4D4D-9B4F-5AA6E305ECE4', '60710830', 'MIS ISLAMIYAH 01 RAKIT', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('7501685F-8258-4818-8E27-9AEBFF202588', '20363510', 'MTSS AL HIDAYAH TWELAGIRI', 'SWASTA', 'Kec. Pagedongan', 'MTs');
INSERT INTO `sekolah` VALUES ('75A5E713-6666-4CFE-AD6D-00186C8BC206', '60710800', 'MIS MAARIF DANAKERTA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('75E8051E-522D-4476-8C9D-05E890873FA8', '60710731', 'MIS MUHAMMADIYAH PETAMBAKAN', 'SWASTA', 'Kec. Madukara', 'MI');
INSERT INTO `sekolah` VALUES ('7705744E-873B-4E3B-8E62-77F9964F3294', '60710870', 'MIS MA`ARIF SIKENONG BANTAR', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('7707355E-B881-4C3D-A65E-D89ECC06898C', '20303986', 'SMA NEGERI 1 BATUR', 'NEGERI', 'Kec. Batur', 'SMA');
INSERT INTO `sekolah` VALUES ('77ACF69A-D231-4605-94CB-A611C323BDC4', '60710754', 'MIS COKROAMINOTO WANALABA', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('7A2322A5-3851-4CC6-83E7-0BF15D6E03FE', '60710866', 'MIS MUHAMMADIYAH WANAYASA', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('7A43D27F-0142-46B3-AD9C-F1AF609AB821', '60710828', 'MI NAHDLATUL ULAMA GELANG', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('7AC8ADC5-96F9-4177-A4A9-499C4BEB7BF6', '60710755', 'MIS MATHLAUL ANWAR', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('7D4F6F61-DDCE-4E70-AEBB-4A0F0996EB64', '20363495', 'MTSN 1 BANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'MTs');
INSERT INTO `sekolah` VALUES ('7ECF54B3-FB42-470D-8ACA-0AA394D8A13B', '60710704', 'MIS MUHAMMADIYAH 02 BLAMBANGAN', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('7F71160D-D1D8-4775-BA9A-77E769993C95', '69900364', 'SMK NEGERI 1 SUSUKAN', 'NEGERI', 'Kec. Susukan', 'SMK');
INSERT INTO `sekolah` VALUES ('8007D555-2DF5-E011-9D43-1FBBCA2CE2ED', '20304512', 'SD NEGERI 1 SIRUKUN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('800FB455-2DF5-E011-887A-FD201A1A0D92', '20304154', 'SD NEGERI 5 GUMELEM KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('80147D5A-2DF5-E011-9CF9-B700167DF760', '20303956', 'SMP COKROAMINOTO 1 PAGEDONGAN', 'SWASTA', 'Kec. Pagedongan', 'SMP');
INSERT INTO `sekolah` VALUES ('8022B655-2DF5-E011-865A-EB64F1234F93', '20304151', 'SD NEGERI 5 KLAMPOK', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('802B215A-2DF5-E011-B1B2-F18107EA1773', '20304039', 'SMP NEGERI 1 PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SMP');
INSERT INTO `sekolah` VALUES ('802FB755-2DF5-E011-9B2A-A91A46364BE0', '20338251', 'SD NEGERI 2 PANGGISARI', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('8037228E-07B6-E111-B218-4D64D53464F8', '20338492', 'SMP NEGERI 3 WANAYASA', 'NEGERI', 'Kec. Wanayasa', 'SMP');
INSERT INTO `sekolah` VALUES ('8039215A-2DF5-E011-8C91-655F03EA0998', '20304002', 'SMP NEGERI 2 PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SMP');
INSERT INTO `sekolah` VALUES ('803CB655-2DF5-E011-B99F-CF66145E84E7', '20303813', 'SD NEGERI 3 KALIWINASUH', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('803FBB55-2DF5-E011-95D7-6163A1D19B9D', '20304059', 'SD NEGERI 4 KARANGANYAR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('80407D5A-2DF5-E011-8D70-9BA6067A0077', '20303952', 'SMP MA ARIF NU 01 KARANGKOBAR', 'SWASTA', 'Kec. Karangkobar', 'SMP');
INSERT INTO `sekolah` VALUES ('8040D255-2DF5-E011-A9DE-E144C573CAB7', '20304472', 'SD NEGERI 1 PEKASIRAN', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('8041205A-2DF5-E011-B6FB-1DF4395317B6', '20304031', 'SMP NEGERI 1 BANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('8044BA55-2DF5-E011-A71A-33AF5EF4EAB4', '20304466', 'SD NEGERI 1 PETIR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('804AC955-2DF5-E011-BFB1-0B44CBF9252B', '20303771', 'SD NEGERI 3 PURWASANA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('804FD755-2DF5-E011-B5E6-238549F5EE20', '20303764', 'SD NEGERI 3 LAWEN', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('8055BF55-2DF5-E011-9033-2BB89FB84037', '20304431', 'SD NEGERI 1 SEMAMPIR', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('8067C155-2DF5-E011-BBBA-5FE515083079', '20303776', 'SD NEGERI 3 PRIGI', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('8067D055-2DF5-E011-9878-9D1C292AA8AC', '20303700', 'SD NEGERI 3 ARIBAYA', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('806BCA55-2DF5-E011-B227-BF8A4196B81F', '20304629', 'SD NEGERI 01 LEKSANA', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('8070205A-2DF5-E011-9451-712703998B69', '20304017', 'SMP NEGERI 4 BANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('8070BC55-2DF5-E011-9495-0D06C2EF0804', '20304606', 'SD NEGERI 01 MANTRIANOM', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('8078CA55-2DF5-E011-A3D4-CB2EFD32E98B', '20304586', 'SD NEGERI 1 AMBAL', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('8082BE55-2DF5-E011-859D-A3411E1276B6', '20303917', 'SD NEGERI 2 KUTABANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('8088D155-2DF5-E011-AB88-E9DEC8E6837A', '20304430', 'SD NEGERI 1 SEMANGKUNG', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('808ABC55-2DF5-E011-B029-E5AB1391107B', '20304485', 'SD NEGERI 1 WINONG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('808BC455-2DF5-E011-AF26-17E0F0470A0C', '20304119', 'SD NEGERI GRIPIT', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('808FBB55-2DF5-E011-AF0D-1F3D11E84C96', '20304152', 'SD NEGERI 5 KARANGANYAR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('8090215A-2DF5-E011-8D38-ED2E8559F746', '20304022', 'SMP NEGERI 3 PAGENTAN', 'NEGERI', 'Kec. Pagentan', 'SMP');
INSERT INTO `sekolah` VALUES ('80A2B455-2DF5-E011-91E6-9DA223529570', '20304101', 'SD NEGERI 4 DERIK', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('80A8D455-2DF5-E011-8C50-C9F56FC247C4', '20304110', 'SD NEGERI 3 WANARAJA', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('80AABE55-2DF5-E011-8C4C-F7E3EBBF84E7', '20303904', 'SD NEGERI 2 PARAKANCANGGAH', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('80ADD555-2DF5-E011-BE9B-D70415EF3170', '20304516', 'SD NEGERI 1 SINDUAJI', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('80B1B455-2DF5-E011-8173-CFCCA9399593', '20304166', 'SD NEGERI 7 GUMELEM KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('80B6BB55-2DF5-E011-8609-473539A3CAE6', '20304147', 'SD NEGERI 5 PURWANEGARA', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('80BCBD55-2DF5-E011-A78E-ADAB08724911', '20303797', 'SD NEGERI 3 GENTANSARI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('80BDC655-2DF5-E011-A11B-B7EC0D67A723', '20303909', 'SD NEGERI 2 LENGKONG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('80C3BB55-2DF5-E011-A4DB-B5ED61EE2DC4', '20304062', 'SD NEGERI 4 KALIPELUS', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('80C9BD55-2DF5-E011-929B-C799065AC765', '20304098', 'SD NEGERI 3 WANADRI', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('80CAD155-2DF5-E011-960D-A10EDAE3E052', '20303882', 'SD NEGERI 2 PEGUNDUNGAN', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('80CDC455-2DF5-E011-A7F1-6113A7EE5AB2', '20304536', 'SD NEGERI 1 MEDAYU', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('80D4B355-2DF5-E011-9FD3-AFA9D72B0592', '20304099', 'SD NEGERI 4 GUMELEM KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('80D4CA55-2DF5-E011-9559-9D2D1A0003F7', '20304497', 'SD NEGERI 2 BINANGUN', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('80D9B955-2DF5-E011-9F42-554DCEB4876D', '20304644', 'SD NEGERI 1 KALIPELUS', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('80D9C255-2DF5-E011-B587-C58EE0DF48DD', '20303734', 'SD NEGERI 2 SERED', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('80DA1F5A-2DF5-E011-817E-ABDAB7C06503', '20337886', 'SMP NEGERI 4 PURWANEGARA', 'NEGERI', 'Kec. Purwanegara', 'SMP');
INSERT INTO `sekolah` VALUES ('80DFD355-2DF5-E011-8330-3D3909986594', '20303866', 'SD NEGERI 2 JATILAWANG', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('80E5215A-2DF5-E011-98AC-3F5BD501E23B', '20304045', 'SMP NEGERI 1 WANAYASA', 'NEGERI', 'Kec. Wanayasa', 'SMP');
INSERT INTO `sekolah` VALUES ('80F2A95A-2DF5-E011-9496-53D31BD7A9D6', '20303950', 'SMP MUHAMMADIYAH WANADADI', 'SWASTA', 'Kec. Wanadadi', 'SMP');
INSERT INTO `sekolah` VALUES ('80F2C655-2DF5-E011-8EB7-BDF63BE2CE82', '20303907', 'SD NEGERI 2 LUWUNG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('80F67C5A-2DF5-E011-A41F-7B8B0DFE788D', '20340881', 'SMP MUHAMMADIYAH PURWAREJA KLAMPOK', 'SWASTA', 'Kec. Purwareja Klampok', 'SMP');
INSERT INTO `sekolah` VALUES ('80F8BB55-2DF5-E011-A484-1FF784BFA9E1', '20304630', 'SD NEGERI 1 LEBAKWANGI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('8239833A-CC0F-43DB-A4DC-CA0530F575BF', '20364912', 'MAS MA`ARIF NU WANAYASA', 'SWASTA', 'Kec. Wanayasa', 'MA');
INSERT INTO `sekolah` VALUES ('832036CE-517F-461D-8C86-29028AAA36B0', '20363526', 'MTs WALISONGO', 'SWASTA', 'Kec. Sigaluh', 'MTs');
INSERT INTO `sekolah` VALUES ('836C44F2-F0F6-4450-9C58-C1BD58742B10', '60710833', 'MIS MUHAMMADIYAH BANDINGAN', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('853C6E3C-E525-402F-AD6A-BD1A58640F25', '60710854', 'MIS COKROAMINOTO LEMAHJAYA', 'SWASTA', 'Kec. Wanadadi', 'MI');
INSERT INTO `sekolah` VALUES ('859EB1E2-871C-4D57-B14D-0C7CAB8A72ED', '70011440', 'SD ADZKIA', 'SWASTA', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('860B28FE-94A5-4389-AE01-2CE0DC7794DA', '60710817', 'MIS MAARIF KALIPELUS', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('86E40D58-6DBF-4651-BF68-3675EB59455F', '20363498', 'MTSS MUHAMMADIYAH BATUR', 'SWASTA', 'Kec. Batur', 'MTs');
INSERT INTO `sekolah` VALUES ('86FCD8C4-B8E8-4913-9007-655A3209B29A', '60710744', 'MI MUHAMMADIYAH KALIWUNGU', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('87C76164-044B-451C-B971-9FCFB9820B04', '60710864', 'MIS MUHAMMADIYAH KASIMPAR', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('8879852B-22C1-41F3-BC69-74D23227C93F', '60710750', 'MIS MUHAMMADIYAH LEBAKWANGI', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('88845A6C-2D55-41B1-B535-4A7D4760BD0C', '69762663', 'SMK NEGERI 1 MANDIRAJA', 'NEGERI', 'Kec. Mandiraja', 'SMK');
INSERT INTO `sekolah` VALUES ('88A61476-FD9A-4187-A5F3-0084A554D83B', '60710850', 'MIS ARROHMAN PANERUSAN KULON', 'SWASTA', 'Kec. Susukan', 'MI');
INSERT INTO `sekolah` VALUES ('89186F35-8204-41EA-A1C3-0C276F549F87', '60710869', 'MIS MA`ARIF LEGOKLANGKIR', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('892727CA-5731-44D4-954B-EDA0137CFF9E', '60710703', 'MIS MUHAMMADIYAH 01 BLAMBANGAN', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('89EC999A-5B6F-4284-844A-159725952FFB', '60710860', 'MIS COKROAMINOTO LINGGASARI', 'SWASTA', 'Kec. Wanadadi', 'MI');
INSERT INTO `sekolah` VALUES ('8B8A2BA8-E379-4296-B47E-3E624CD234CE', '60702888', 'MAS MAARIF BAWANG', 'SWASTA', 'Kec. Bawang', 'MA');
INSERT INTO `sekolah` VALUES ('8C6881ED-E936-489B-94A0-DD0F8CFFA967', '20337887', 'SMK NEGERI 1 PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SMK');
INSERT INTO `sekolah` VALUES ('8C962BF4-4624-4DA6-87A3-01A6AF2931C4', '20362369', 'SMK PANCA BHAKTI RAKIT', 'SWASTA', 'Kec. Rakit', 'SMK');
INSERT INTO `sekolah` VALUES ('8D03A3A6-AF51-4EC2-8524-103FB9C1E1B6', '60710721', 'MIS GUPPI DEPOK', 'SWASTA', 'Kec. Kalibening', 'MI');
INSERT INTO `sekolah` VALUES ('8D2F2E44-1526-474C-9270-FD9E9D6BE53F', '69956203', 'MIS MA`ARIF NU HIZBUL QUR`AN', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('8D3F4395-EBB7-4F72-94ED-CD98F86E05B6', '60710859', 'MIS COKROAMINOTO KANDANGWANGI', 'SWASTA', 'Kec. Wanadadi', 'MI');
INSERT INTO `sekolah` VALUES ('8E878B4A-FDC8-43C4-AA02-4142325E625A', '60710768', 'MIS GUPPI SALAM', 'SWASTA', 'Kec. Pandanarum', 'MI');
INSERT INTO `sekolah` VALUES ('8EA800F8-113A-45F9-806B-B4EA92BB6EEA', '60710808', 'MIS AL FATAH 02 SIRKANDI', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('8FF9F5A3-AEFD-4B2A-B48E-45DC4CC16E18', '60710683', 'MIS GUPPI KALILUNJAR', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('900494C5-C973-44BA-AC05-E77C67690270', '70015193', 'SDIT INSAN MANDIRI PUNGGELAN', 'SWASTA', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('9006C255-2DF5-E011-B811-7B466C0F8168', '20304633', 'SD NEGERI KUTAYASA', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('900CC755-2DF5-E011-845B-63E80F8FEC10', '20303698', 'SD NEGERI 3 ADIPASIR', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('9013205A-2DF5-E011-A9D1-BF8C7563B3AA', '20304029', 'SMP NEGERI 1 BAWANG', 'NEGERI', 'Kec. Bawang', 'SMP');
INSERT INTO `sekolah` VALUES ('9021B755-2DF5-E011-A6F6-D178E12FB2BC', '20338241', 'SD NEGERI 1 PANGGISARI', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('9027D455-2DF5-E011-9D48-45348B297563', '20303793', 'SD NEGERI 3 JATILAWANG', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('9033D255-2DF5-E011-969C-197215B67EE2', '20304476', 'SD NEGERI 1 PASURENAN', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('9035C055-2DF5-E011-83F5-CBB634195A3F', '20303878', 'SD NEGERI 2 PESANGKALAN', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('903ECB55-2DF5-E011-85FC-E3DBC96F3F83', '20303874', 'SD NEGERI 2 SAMPANG', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('9045C555-2DF5-E011-97B5-7D0D8403C0BA', '20304589', 'SD MUHAMMADIYAH WANADADI', 'SWASTA', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('9049B755-2DF5-E011-9F3E-BFCA65150FC1', '20338242', 'SD NEGERI 1 PURWASABA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('9060D155-2DF5-E011-90DF-E17D80F542AE', '20304535', 'SD NEGERI 1 SIDENGOK', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('9070D655-2DF5-E011-B769-0B676E995544', '20303781', 'SD NEGERI 3 PASEGERAN', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('9071B655-2DF5-E011-A6A1-0529CE995B76', '20304605', 'SD MUHAMMADIYAH PURWOREJO', 'SWASTA', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('907ABD55-2DF5-E011-A68A-6322468137CA', '20304496', 'SD NEGERI 2 BINORONG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('9084C755-2DF5-E011-A2CE-A36E5131F23E', '20303816', 'SD NEGERI 2 KINCANG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('9086E6E1-05B6-E111-B82D-B5645EEC79CE', '20338599', 'SMP NEGERI 5 SATAP PURWANEGARA', 'NEGERI', 'Kec. Purwanegara', 'SMP');
INSERT INTO `sekolah` VALUES ('9091C553-2DF5-E011-B804-E3B2CC5CED46', '20338714', 'SMP ISLAM DARUNAJAH', 'SWASTA', 'Kec. Banjarmangu', 'SMP');
INSERT INTO `sekolah` VALUES ('9091CE55-2DF5-E011-8C1E-AF74E8B4D024', '20304129', 'SD NEGERI KASMARAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('9093D555-2DF5-E011-AB6E-DD76C4DAC2E4', '20304428', 'SD NEGERI 1 SEMBAWA', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('9097C255-2DF5-E011-B982-43369EF944C4', '20303745', 'SD NEGERI 2 TALUNAMBA', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('90A0C355-2DF5-E011-8702-BDAAC1C63FB6', '20304419', 'SD NEGERI 1 PRENDENGAN', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('90ACC755-2DF5-E011-B07A-3367282A230C', '20304149', 'SD NEGERI 5 LENGKONG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('90B4D355-2DF5-E011-9171-DB4E484A8875', '20304529', 'SD NEGERI 1 TEMPURAN', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('90C4D255-2DF5-E011-B8D4-3BAA9C0C519A', '20303884', 'SD NEGERI 2 PASURENAN', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('90CC1F5A-2DF5-E011-9D0F-39E6E5A6FE3F', '20304050', 'SMP NEGERI 1 PURWANEGARA', 'NEGERI', 'Kec. Purwanegara', 'SMP');
INSERT INTO `sekolah` VALUES ('90D2B555-2DF5-E011-91E7-0F7708EEF19A', '20304459', 'SD NEGERI 1 PAGAK', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('90E6BF55-2DF5-E011-91EE-75FD2BEE2717', '20304057', 'SD NEGERI 4 KEBUTUHDUWUR', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('90F0C355-2DF5-E011-A56A-E7A51E7789C5', '20303834', 'SD NEGERI 2 KENDAGA', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('90F5C955-2DF5-E011-A280-833C35CCEB32', '20304112', 'SD NEGERI 3 SAWANGAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('90FBC855-2DF5-E011-B977-BFF06BF811A1', '20304435', 'SD NEGERI 1 SAMBONG', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('913B5E2E-DDA8-4D3B-A24D-E0466C9AA617', '60710857', 'MIS COKROAMINOTO 02 WANAKARSA', 'SWASTA', 'Kec. Wanadadi', 'MI');
INSERT INTO `sekolah` VALUES ('91C52E57-565A-47A8-BBE6-6CB0C58723DD', '60710699', 'MIS ISLAMIYAH PEKASIRAN', 'SWASTA', 'Kec. Batur', 'MI');
INSERT INTO `sekolah` VALUES ('91D1A246-7EC5-44BC-8803-7CB1FD414133', '60710724', 'MIS GUPPI BINANGUN', 'SWASTA', 'Kec. Karangkobar', 'MI');
INSERT INTO `sekolah` VALUES ('91FBF48D-C42C-4F08-AEE6-92D6A3D690DE', '60710686', 'MIS COKROAMINOTO PEKANDANGAN', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('9445FACF-7124-4D70-AB6C-278C57ED585D', '60710684', 'MIS COKROAMINOTO SIJERUK', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('944B4755-BF3B-47BC-AD36-39340E44BD8E', '70033482', 'MI AL HIDAYAH PURWAREJA', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('95C4A203-3C2A-4A6D-ADD4-8EA95B77636F', '70055409', 'Sekolah Rakyat Menengah Pertama 27 Banjarnegara', 'NEGERI', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('9669BF63-CF2C-4086-9666-6186C09A6BF0', '60710764', 'MIS MUHAMMADIYAH KASMARAN', 'SWASTA', 'Kec. Pagentan', 'MI');
INSERT INTO `sekolah` VALUES ('96773773-D1C4-4AB3-8E1D-6D5DABE0A86C', '60710806', 'MIN 1 BANJARNEGARA', 'NEGERI', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('96FC4187-FE48-476E-AFAD-00139555A2A0', '60710689', 'MIS COKROAMINOTO BEJI', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('97404053-2D5E-4DCE-8C02-A87915131CCB', '60710815', 'MIS MUHAMMADIYAH 01 MERDEN', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('97A27999-438C-4738-A3AE-D6E92CA81D24', '60710736', 'MIS AL MAARIF BLIMBING', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('98F12260-9C72-428D-9379-ECE860E69973', '60710848', 'MIS AL FATAH KEDAWUNG', 'SWASTA', 'Kec. Susukan', 'MI');
INSERT INTO `sekolah` VALUES ('99560772-82FC-4D2C-9375-4D1994CE3FCF', '60710795', 'MIS COKROAMINOTO TANJUNGTIRTA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('9B712F40-6071-49E1-A22A-6C29C782C2C6', '20363501', 'MTSS MUHAMMADIYAH 1 KALIBENING', 'SWASTA', 'Kec. Kalibening', 'MTs');
INSERT INTO `sekolah` VALUES ('9C105A44-10E4-46E8-8FB4-62A24786CB48', '69965598', 'SMPIT MUTIARA HATI', 'SWASTA', 'Kec. Purwareja Klampok', 'SMP');
INSERT INTO `sekolah` VALUES ('9C54A4D8-7EC3-40D3-BD6F-16B92D1FDEB8', '60710720', 'MIS MUHAMMADIYAH BAKULAN', 'SWASTA', 'Kec. Kalibening', 'MI');
INSERT INTO `sekolah` VALUES ('9CAD88A3-B837-4A87-BFBB-C1FF329BD02E', '60710782', 'MI COKROAMINOTO 01 PETUGURAN', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('9CBDABDE-AFDB-4F6F-8EE7-9B519040EAC9', '20340806', 'SMKS MIFTAHUSSHOLIHIN SIGALUH', 'SWASTA', 'Kec. Sigaluh', 'SMK');
INSERT INTO `sekolah` VALUES ('9F05BA81-438A-45D6-BA6B-C2FE74E75491', '20303988', 'SMAS MUHAMMADIYAH 4 BANJARNEGARA', 'SWASTA', 'Kec. Kalibening', 'SMA');
INSERT INTO `sekolah` VALUES ('9F3C1535-B42C-4299-8D3E-6455BA28663B', '60710695', 'MIS MUHAMMADIYAH KARANGTENGAH', 'SWASTA', 'Kec. Banjarnegara', 'MI');
INSERT INTO `sekolah` VALUES ('A010B355-2DF5-E011-8BC8-A1747C573C9C', '20304615', 'SD NEGERI 1 KEDAWUNG', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('A014D555-2DF5-E011-9D65-A16DE5F971C1', '20304648', 'SD NEGERI 1 KARANGANYAR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('A01CDAE9-FAB5-E111-9C82-55D5D645E6AD', '20351046', 'SMP NEGERI 4 SATU ATAP BAWANG', 'NEGERI', 'Kec. Bawang', 'SMP');
INSERT INTO `sekolah` VALUES ('A020B955-2DF5-E011-A108-83E94B5DB4F1', '20338260', 'SD NEGERI 3 SALAMERTA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('A022C855-2DF5-E011-A26E-FB5BA8F76A6F', '20304593', 'SD NEGERI 1 BONDOLHARJO', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('A02EBC55-2DF5-E011-95AE-FB56B0DB8D72', '20304556', 'SD NEGERI 1 JOHO', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('A02EC455-2DF5-E011-924C-73B0C8691E96', '20304131', 'SD NEGERI MAJATENGAH', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('A02ED555-2DF5-E011-B70B-0F3095AE75F5', '20304622', 'SD NEGERI 1 MAJATENGAH', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('A030BD19-916D-471E-AF4A-C0CD4687A238', '60710765', 'MIS MUHAMMADIYAH PAGENTAN', 'SWASTA', 'Kec. Pagentan', 'MI');
INSERT INTO `sekolah` VALUES ('A030FF15-06B6-E111-8A4C-59872956F0B7', '20303713', 'SD NEGERI 3 DARMAYASA', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('A03B3714-1EFA-4685-831A-470C4EBC557F', '20364910', 'MAS WALISONGO', 'SWASTA', 'Kec. Sigaluh', 'MA');
INSERT INTO `sekolah` VALUES ('A03CB755-2DF5-E011-ABC6-41A32B4A41DD', '20338271', 'SD NEGERI BLIMBING', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('A044B855-2DF5-E011-AF5A-BFAF5382C433', '20340835', 'SD NEGERI 3 MANDIRAJA WETAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('A04CBB55-2DF5-E011-B380-EB8BB42D56BC', '20303800', 'SD NEGERI 3 KALITENGAH', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('A052B255-2DF5-E011-ADE0-C3B98410837F', '20303871', 'SD NEGERI 2 GUMELEM WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('A0583C59-2DF5-E011-8F6A-B1BDE344BE32', '20304053', 'SD MUHAMMADIYAH 3 BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('A05ABE55-2DF5-E011-BB43-D3651BFD9DA1', '20304067', 'SD NEGERI 4 KRANDEGAN', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('A05AD055-2DF5-E011-88F1-63464752194A', '20303757', 'SD NEGERI 3 PAGENTAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('A061CF55-2DF5-E011-A167-71B529FB5CB3', '20304659', 'SD NEGERI 1 KARANGNANGKA', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('A0651F5A-2DF5-E011-BC0F-E93DF836A390', '20303996', 'SMP NEGERI 2 SUSUKAN', 'NEGERI', 'Kec. Susukan', 'SMP');
INSERT INTO `sekolah` VALUES ('A067D255-2DF5-E011-A15F-E9C9261D808B', '20304145', 'SD NEGERI 6 BATUR', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('A068B555-2DF5-E011-81B7-AB3936738E70', '20304055', 'SD NEGERI 4 KLAMPOK', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('A068C755-2DF5-E011-9513-D7BB32574AAA', '20340898', 'SD NEGERI 3 PINGIT', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('A06F5AD1-05B6-E111-BDCF-712A786325C6', '20340877', 'SD IT PERMATA HATI PETAMBAKAN', 'SWASTA', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('A077C855-2DF5-E011-9872-27F27643DE41', '20304410', 'SD NEGERI 1 PURWASANA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('A07DBC55-2DF5-E011-85C8-25FC71A4BB90', '20303901', 'SD NEGERI 2 PUCANG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('A07DC255-2DF5-E011-AB30-F5C62F44200D', '20304426', 'SD NEGERI 1 SERED', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('A081D055-2DF5-E011-B33A-D76C25837562', '20304088', 'SD NEGERI 3 SOKARAJA', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('A081D255-2DF5-E011-9057-B1E55BFBAE0A', '20304493', 'SD NEGERI 2 BAKAL', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('A083B555-2DF5-E011-A4DE-BD85C5FB87B3', '20303825', 'SD NEGERI 2 KALIWINASUH', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('A08AC255-2DF5-E011-864B-F9268C939130', '20303975', 'SD NEGERI 1 PAKELEN', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('A08D205A-2DF5-E011-9D36-D7D8F95DE172', '20304048', 'SMP NEGERI 1 SIGALUH', 'NEGERI', 'Kec. Sigaluh', 'SMP');
INSERT INTO `sekolah` VALUES ('A08ED255-2DF5-E011-838D-ADA0752B3B7B', '20303748', 'SD NEGERI 2 SUMBEREJO', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('A0A6C955-2DF5-E011-8F24-7FCFEFC35549', '20303892', 'SD NEGERI 2 SAMBONG', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('A0B34BFC-04B6-E111-BBE7-2B9211A5D644', '20361972', 'SMP COKROAMINOTO PUNGGELAN', 'SWASTA', 'Kec. Punggelan', 'SMP');
INSERT INTO `sekolah` VALUES ('A0B3C955-2DF5-E011-9F55-4DCC5C77F1B6', '20303709', 'SD NEGERI 2 TRIBUANA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('A0B6D455-2DF5-E011-82BC-B3E8786ACD1A', '20303853', 'SD NEGERI 2 DAWUHAN', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('A0B7A95A-2DF5-E011-8E61-EBD8DA01B822', '20303934', 'SMP MUHAMMADIYAH BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('A0B9C855-2DF5-E011-AD56-094ADDEFC795', '20304617', 'SD NEGERI 1 KECEPIT', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('A0BCC055-2DF5-E011-864F-2F494EE24C54', '20303968', 'SD NEGERI 1 PRINGAMBA', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('A0C0C955-2DF5-E011-9404-234C2CFB9C37', '20340901', 'SD NEGERI 3 TLAGA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('A0C4C155-2DF5-E011-89B2-774C9FE6A25F', '20304604', 'SD NEGERI 1 BANTARWARU', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('A0CAC655-2DF5-E011-BCCC-63266DADE5FF', '20304625', 'SD NEGERI 1 LUWUNG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('A0D1C155-2DF5-E011-B1A5-7F32BBBA51D6', '20304612', 'SD NEGERI 1 KENTENG', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('A0D1D255-2DF5-E011-9657-1114CA8FA1ED', '20303880', 'SD NEGERI 2 PEKASIRAN', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('A0DEC155-2DF5-E011-914B-FBF19C361DC8', '20304467', 'SD NEGERI PETAMBAKAN', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('A0DFB555-2DF5-E011-894D-8D786846E83A', '20304520', 'SD NEGERI 1 SIRKANDI', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('A0E3BA55-2DF5-E011-B34D-ED90FCB0C786', '20303775', 'SD NEGERI 3 PUCUNGBEDUG', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('A0E6B955-2DF5-E011-9B49-55AF75AFC960', '20304169', 'SD NEGERI 6 PETIR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('A0F2C555-2DF5-E011-BF46-23440023B754', '20304068', 'SD NEGERI 4 LEMAHJAYA', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('A0F3B955-2DF5-E011-9C06-B5C9AAD72941', '20304572', 'SD NEGERI 1 GUMIWANG', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('A0FDBA55-2DF5-E011-866F-57C43EE6C4C1', '20304102', 'SD NEGERI 4 DANARAJA', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('A17681A5-337F-4CC8-B21D-71892471F7FE', '60710797', 'MIS COKROAMINOTO SIDARATA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('A1CDD2F6-A78E-49BE-97DE-398B96CDBB3B', '20364903', 'MAS NURUL HIKMAH KALIBENING', 'SWASTA', 'Kec. Kalibening', 'MA');
INSERT INTO `sekolah` VALUES ('A35B4B7F-72F9-46A4-916B-972518E61890', '20364909', 'MAS GUPPI RAKIT', 'SWASTA', 'Kec. Rakit', 'MA');
INSERT INTO `sekolah` VALUES ('A5FCF8C6-93FC-4EFF-9ABF-072779B3AB23', '70045606', 'MA COKROAMINOTO MADUKARA', 'SWASTA', 'Kec. Madukara', 'MA');
INSERT INTO `sekolah` VALUES ('A6C11721-4025-40DF-91F5-87245284C87B', '20338495', 'SMAS MUHAMMADIYAH 1 BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMA');
INSERT INTO `sekolah` VALUES ('A6C58DAC-7A33-4653-B2CB-393A415FC627', '20303987', 'SMA NEGERI 1 BANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'SMA');
INSERT INTO `sekolah` VALUES ('A6D58F47-60A3-4138-84C8-9438A849D71E', '20338496', 'SMAS PGRI PURWAREJA KLAMPOK', 'SWASTA', 'Kec. Purwareja Klampok', 'SMA');
INSERT INTO `sekolah` VALUES ('A6F99D00-F0E9-49F4-8A8B-1600D3C8564F', '60710835', 'MIS NU KINCANG', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('A92C500E-EF01-4BFC-8BC2-5F36C4081F16', '60710851', 'MIS AL ISLAM KARANGJATI', 'SWASTA', 'Kec. Susukan', 'MI');
INSERT INTO `sekolah` VALUES ('AA10B726-0A40-462E-975C-BC7ADC27D420', '60710714', 'MIS MAARIF KEBONDALEM', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('AA50BD87-1D1B-4445-9E7F-A20E5AEADC83', '60710823', 'MIS COKROAMINOTO PINGIT', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('AA66A59E-387D-4251-BE2E-9D665F86EF4F', '20303942', 'SMK NEGERI 1 BAWANG', 'NEGERI', 'Kec. Bawang', 'SMK');
INSERT INTO `sekolah` VALUES ('AA778AA7-A931-4230-A7D3-353E73FB2C56', '60710687', 'MIS COKROAMINOTO PASEH', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('ABBF244D-98D7-43B4-AB4E-7583B3AA2AB7', '60710842', 'MIS COKROAMINOTO PANAWAREN', 'SWASTA', 'Kec. Sigaluh', 'MI');
INSERT INTO `sekolah` VALUES ('AC5EDAFD-D440-41DC-9A15-C60BF1913B5B', '60710748', 'MIS COKROAMINOTO 02 LEBAKWANGI', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('AEAF8614-4FE0-4A37-95ED-D54A1E85F191', '20363529', 'MTs MAARIF KUBANG', 'SWASTA', 'Kec. Wanayasa', 'MTs');
INSERT INTO `sekolah` VALUES ('AF1ADCCB-EA97-4060-9110-02E422AA3508', '60710873', 'MIS MA`ARIF KECEPIT', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('AFDE8842-79AB-410D-87C2-1FB93BD06D69', '69900360', 'SMK NEGERI 1 PANDANARUM', 'NEGERI', 'Kec. Pandanarum', 'SMK');
INSERT INTO `sekolah` VALUES ('B008C855-2DF5-E011-B6A8-B7BA370E658B', '20303899', 'SD NEGERI 2 PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('B01CBA55-2DF5-E011-8F8A-F552EC45EBA0', '20304439', 'SD NEGERI 1 PARAKAN', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('B026B555-2DF5-E011-A872-950A63180C15', '20304411', 'SD NEGERI 1 PURWAREJA', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('B030779E-FCB5-E111-99AB-A7485D09B25A', '20354039', 'SMP NEGERI 4 MANDIRAJA', 'NEGERI', 'Kec. Mandiraja', 'SMP');
INSERT INTO `sekolah` VALUES ('B0317D5A-2DF5-E011-9B0A-B5FEF28132ED', '20337880', 'SMP COKROAMINOTO BANJARMANGU', 'SWASTA', 'Kec. Banjarmangu', 'SMP');
INSERT INTO `sekolah` VALUES ('B047215A-2DF5-E011-9178-353AFF0D7045', '20304014', 'SMP NEGERI 4 PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SMP');
INSERT INTO `sekolah` VALUES ('B049B455-2DF5-E011-A135-851824DEF4DE', '20304144', 'SD NEGERI 6 GUMELEM KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('B051D555-2DF5-E011-823B-1BCF9834A034', '20304138', 'SD NEGERI 1 KERTOSARI', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('B05D7D5A-2DF5-E011-8B51-0749F003A0B2', '20303954', 'SMP ISLAM AL MABRUR', 'SWASTA', 'Kec. Pejawaran', 'SMP');
INSERT INTO `sekolah` VALUES ('B063D655-2DF5-E011-9680-7953A4E9FDD4', '20303806', 'SD NEGERI 3 KASINOMAN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('B06DD155-2DF5-E011-975B-73F373E363ED', '20303731', 'SD NEGERI 2 SIDENGOK', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('B07E205A-2DF5-E011-8964-536005B8A5F0', '20304011', 'SMP NEGERI 1 PAGEDONGAN', 'NEGERI', 'Kec. Pagedongan', 'SMP');
INSERT INTO `sekolah` VALUES ('B087BD55-2DF5-E011-ABF3-AFC48E7851D5', '20303915', 'SD NEGERI 2 KUTAYASA', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('B094BA55-2DF5-E011-B5AD-8D9686B0A88C', '20304081', 'SD NEGERI 4 MERDEN', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('B097BC55-2DF5-E011-93E2-C3972A3C617B', '20304484', 'SD NEGERI 1 WIRAMASTRA', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('B09AB355-2DF5-E011-AA2D-33433E98BD0B', '20303925', 'SD NEGERI 2 PAKIKIRAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('B09CC155-2DF5-E011-84FF-859CE0882EC7', '20303719', 'SD NEGERI 3 BOJANEGARA', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('B09ECE55-2DF5-E011-BF95-AF5CA254E333', '20304623', 'SD NEGERI 1 MAJASARI', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('B0ADC355-2DF5-E011-8387-4F75AB8BB068', '20303966', 'SD NEGERI REJASARI', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('B0B1BF55-2DF5-E011-B67F-53DD2605ACED', '20303782', 'SD NEGERI 3 PARAKANCANGGAH', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('B0C68BFF-F9D9-E111-8B2A-2B0140DE59A6', '20340904', 'SD NEGERI 1 KARANGSARI', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('B0E67C5A-2DF5-E011-9CB6-0BC27E1D74FB', '20304018', 'SMP NEGERI 3 SUSUKAN', 'NEGERI', 'Kec. Susukan', 'SMP');
INSERT INTO `sekolah` VALUES ('B0E6C255-2DF5-E011-B717-D58FFE597B56', '20303801', 'SD NEGERI 3 KALIURIP', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('B0EEC855-2DF5-E011-BD15-CBAFCEBDE68C', '20304137', 'SD NEGERI KLAPA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('B11AA0C7-F1D5-4EE9-9CAF-A3D8E0DD7D3D', '60710767', 'MIS GUPPI SINDUAJI', 'SWASTA', 'Kec. Pandanarum', 'MI');
INSERT INTO `sekolah` VALUES ('B3169EE4-6DDB-4877-BEF6-810A47981142', '60710760', 'MIS COKROAMINOTO 01 KEBUTUHJURANG', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('B4B35A7B-B039-471F-A52A-68A5A36FA97D', '20363504', 'MTSS COKROAMINOTO MADUKARA', 'SWASTA', 'Kec. Madukara', 'MTs');
INSERT INTO `sekolah` VALUES ('B4D7B951-87BF-4C5B-BCCF-46DB7C85515F', '20364911', 'MAS COKROAMINOTO WANADADI', 'SWASTA', 'Kec. Wanadadi', 'MA');
INSERT INTO `sekolah` VALUES ('B6EC1AD0-4190-48DC-A4EF-52DBA52BD6B6', '60710742', 'MIS AL WATHONIYAH GLEMPANG', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('B7252B5C-07DA-4F28-9903-12E34E98CB53', '60710722', 'MIS GUPPI TANGGAPAN', 'SWASTA', 'Kec. Karangkobar', 'MI');
INSERT INTO `sekolah` VALUES ('B75B29F0-184A-4A4C-A2A4-A2B159D3AEC4', '20363527', 'MTSS COKROAMINOTO WANADADI', 'SWASTA', 'Kec. Wanadadi', 'MTs');
INSERT INTO `sekolah` VALUES ('B77007EF-9ACA-43DF-9B39-5BD515B52972', '20363511', 'MTs AL IRSYAD GUNUNGJATI', 'SWASTA', 'Kec. Pagedongan', 'MTs');
INSERT INTO `sekolah` VALUES ('B7F5A61A-B965-4895-95EE-3D1DD4254C3B', '20340817', 'SMK DARUNNAJAH BANJARMANGU', 'SWASTA', 'Kec. Banjarmangu', 'SMK');
INSERT INTO `sekolah` VALUES ('B8737B7D-E5D5-41A7-B2C0-6B1FD89DA0BF', '60710802', 'MIS MUHAMMADIYAH 01 SAMBONG', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('BACBCD98-D1B5-4D32-87B2-86C6DF7B709F', '60710715', 'MIS MUHAMMADIYAH KARANGGONDANG', 'SWASTA', 'Kec. Kalibening', 'MI');
INSERT INTO `sekolah` VALUES ('BB6AEAC6-8754-499E-9F6F-CA9724A4B8DB', '20362363', 'SMK AL MABRUR PEJAWARAN', 'SWASTA', 'Kec. Pejawaran', 'SMK');
INSERT INTO `sekolah` VALUES ('BBA0BA79-45C7-475D-8D4C-7DE1BF3DFB08', '60710774', 'MIS MUHAMMADIYAH GIRITIRTA', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('BCF75D21-D294-4925-BEB9-B7AA29D87203', '60710737', 'MIS MA`ARIF KEBANARAN', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('BE92290A-36D7-40E4-B620-E7AFF5BE8CC8', '60710862', 'MIS MUHAMMADIYAH PAGONDANGAN', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('BED82E2C-0D66-4860-B48F-BBB0E3933DB7', '20363513', 'MTSS MUHAMMADIYAH SARWODADI', 'SWASTA', 'Kec. Pejawaran', 'MTs');
INSERT INTO `sekolah` VALUES ('BEE659F8-8CA7-4086-BD30-CD55CBBEEC4D', '20303984', 'SMA NEGERI 1 KARANGKOBAR', 'NEGERI', 'Kec. Karangkobar', 'SMA');
INSERT INTO `sekolah` VALUES ('BF19274A-744C-40BE-9183-629A89C757C8', '70033916', 'MI INSAN RABBANI', 'SWASTA', 'Kec. Susukan', 'MI');
INSERT INTO `sekolah` VALUES ('BF2C4354-642F-48D4-A028-074B8E384BE9', '60710839', 'MIS P2A TANJUNGANOM', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('BF616D0D-8F25-44F4-A5D7-883A7FDB11B4', '60710679', 'MIS COKROAMINOTO BANJARKULON', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('BFFB33DB-1F36-4A54-B055-C0C448E7E534', '60710707', 'MIS MUHAMMADIYAH MANTRIANOM', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('C000215A-2DF5-E011-B53A-D58DD0B4FDE4', '20304049', 'SMP NEGERI 1 RAKIT', 'NEGERI', 'Kec. Rakit', 'SMP');
INSERT INTO `sekolah` VALUES ('C000D755-2DF5-E011-B97E-C9229252B54E', '20304452', 'SD NEGERI 1 PANDANARUM', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('C00AD455-2DF5-E011-B156-33A87338A20D', '20303704', 'SD NEGERI 2 WANARAJA', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('C010C555-2DF5-E011-AAC5-4FAD62A80E86', '20340897', 'SD NEGERI 1 WANAKARSA', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('C013225A-2DF5-E011-B5D2-2122CBD1CBE7', '20304040', 'SMP NEGERI 1 PANDANARUM', 'NEGERI', 'Kec. Pandanarum', 'SMP');
INSERT INTO `sekolah` VALUES ('C013BF55-2DF5-E011-9E4E-7F13E74E6CD5', '20304584', 'SD NEGERI 1 ARGASOKA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('C015C855-2DF5-E011-8B0B-87E9547D26C4', '20304143', 'SD NEGERI BADAKARYA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('C01CCA55-2DF5-E011-B706-73D5C4BE1383', '20303718', 'SD NEGERI 3 BONDOLHARJO', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('C020BF55-2DF5-E011-964E-FF11B0CE2B19', '20304480', 'SD NEGERI 2 ARGASOKA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('C021D555-2DF5-E011-9908-EB2232C522D6', '20304421', 'SD NEGERI 1 PLORENGAN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('C022205A-2DF5-E011-ABEF-2BE842827A07', '20304041', 'SMP NEGERI 2 BAWANG', 'NEGERI', 'Kec. Bawang', 'SMP');
INSERT INTO `sekolah` VALUES ('C024BD55-2DF5-E011-91FD-6BFE7BAB5548', '20303798', 'SD NEGERI 3 GEMURUH', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('C025C155-2DF5-E011-80D0-1738222BCC1E', '20303846', 'SD NEGERI 2 GEMBONGAN', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('C029CA55-2DF5-E011-A2B5-A9D7AC878F50', '20303931', 'SD NEGERI 2 MLAYA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('C02BD155-2DF5-E011-A524-07D1D197B5AF', '20303780', 'SD NEGERI 3 PEJAWARAN', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('C032BE55-2DF5-E011-BE42-5B16B79AC698', '20304072', 'SD NEGERI 4 SOKANANDI', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('C032C155-2DF5-E011-9867-E1C092BDCEA9', '20303891', 'SD NEGERI 2 PRIGI', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('C036CA55-2DF5-E011-9F10-5782EED28CBB', '20304065', 'SD NEGERI 4 JEMBANGAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('C03BB355-2DF5-E011-A12E-5325096B2EBC', '20304577', 'SD NEGERI 1 BRENGKOK', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('C03E225A-2DF5-E011-BF0F-15626D3CF20B', '20304008', 'SMP NEGERI 3 KALIBENING', 'NEGERI', 'Kec. Kalibening', 'SMP');
INSERT INTO `sekolah` VALUES ('C04163D7-8DFC-E111-9661-FB3CF5429CA0', '20362745', 'SMP ISLAM TERPADU PERMATA HATI BANJARNEGARA', 'SWASTA', 'Kec. Madukara', 'SMP');
INSERT INTO `sekolah` VALUES ('C045D155-2DF5-E011-9BEE-5790EB22F3A3', '20304436', 'SD NEGERI 1 RATAMBA', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('C0473C59-2DF5-E011-87D3-B924EA8CE34A', '20304249', 'SD MUHAMMADIYAH 2 BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('C050C055-2DF5-E011-AB2A-7FCD22BBD96D', '20304096', 'SD NEGERI 3 TLAGAWERA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('C051B855-2DF5-E011-8162-8B101FB6FA8B', '20338246', 'SD NEGERI 2 CANDIWULAN', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('C057C955-2DF5-E011-9EAE-D54689DDCBD7', '20303865', 'SD NEGERI 2 JEMBANGAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('C058B355-2DF5-E011-9422-21C95F7ACB9D', '20303796', 'SD NEGERI 3 GUMELEM KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('C05AD255-2DF5-E011-A2DF-6957410FAB6C', '20304580', 'SD NEGERI 1 BAKAL', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('C060D455-2DF5-E011-884A-4FCEF4FE87D9', '20304128', 'SD NEGERI 1 KASIMPAR', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('C06C8780-F3B5-E111-86EA-DD7C88C47199', '20362359', 'SMP IP BILINGUAL SCHOOL TUNAS BANGSA', 'SWASTA', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('C06DC555-2DF5-E011-A287-197DD9522692', '20303824', 'SD NEGERI 2 KANDANGWANGI', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('C06F7CEC-03B6-E111-AE9B-6FA1B2E35BFC', '20339184', 'SMP NEGERI 4 PEJAWARAN', 'NEGERI', 'Kec. Pejawaran', 'SMP');
INSERT INTO `sekolah` VALUES ('C074D255-2DF5-E011-A498-0FE56277BA51', '20304167', 'SD NEGERI 7 BATUR', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('C0751F5A-2DF5-E011-B07C-878D9D7B1B9E', '20304051', 'SMP NEGERI 1 PURWAREJA - KLAMPOK', 'NEGERI', 'Kec. Purwareja Klampok', 'SMP');
INSERT INTO `sekolah` VALUES ('C075B555-2DF5-E011-91CF-EFCA934097B6', '20304639', 'SD NEGERI 1 KALIWINASUH', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('C076B455-2DF5-E011-B0D7-571A6F3FD630', '20303770', 'SD NEGERI 3 PANERUSAN WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('C07AD155-2DF5-E011-834D-45B31FF96FF0', '20304599', 'SD NEGERI 1 BEJI', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('C07BCF55-2DF5-E011-B367-0D31BF1BC42A', '20303928', 'SD NEGERI 2 PAGENTAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('C07F66D7-8DFC-E111-AAA5-D5CAD5B589BD', '20303903', 'SD Negeri 2 Pringamba', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('C08149B4-03B6-E111-A074-617FFE98451F', '20351027', 'SMP NEGERI 3 SATAP PANDANARUM', 'NEGERI', 'Kec. Pandanarum', 'SMP');
INSERT INTO `sekolah` VALUES ('C084C855-2DF5-E011-B0D6-313F4C9BF099', '20303896', 'SD NEGERI 2 PURWASANA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('C085CA55-2DF5-E011-ABE5-CB82849AB22C', '20304597', 'SD NEGERI 1 BINANGUN', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('C091C855-2DF5-E011-B87F-016F0F245619', '20304558', 'SD NEGERI 1 JEMBANGAN', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('C096D355-2DF5-E011-ABD4-3DBE2DDFFDD6', '20304579', 'SD NEGERI 1 BALUN', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('C09B205A-2DF5-E011-BD5D-83FB2A12F20C', '20304026', 'SMP NEGERI 1 MADUKARA', 'NEGERI', 'Kec. Madukara', 'SMP');
INSERT INTO `sekolah` VALUES ('C09E215A-2DF5-E011-95D1-37FFEB13168A', '20304038', 'SMP NEGERI 1 PEJAWARAN', 'NEGERI', 'Kec. Pejawaran', 'SMP');
INSERT INTO `sekolah` VALUES ('C0A2D155-2DF5-E011-89A9-E5705AA597FA', '20304121', 'SD NEGERI 1 CONDONGCAMPUR', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('C0A9BB55-2DF5-E011-A10E-1119A2502BC8', '20303783', 'SD NEGERI 3 PARAKAN', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('C0A9C155-2DF5-E011-AFE4-616F16C86B08', '20303971', 'SD NEGERI PEKAUMAN', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('C0AAB255-2DF5-E011-B10E-B9CC5CD524DA', '20303823', 'SD NEGERI 2 KARANGJATI', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('C0B2B755-2DF5-E011-BA26-2B469B609DB7', '20338236', 'SD NEGERI 1 KALIWUNGU', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('C0B2BC55-2DF5-E011-BA72-BDA8DB2488CA', '20304500', 'SD NEGERI 2 BAWANG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('C0B7BE55-2DF5-E011-B63D-DF73A5FCE75D', '20304509', 'SD N 1 SOKANANDI', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('C0BCC555-2DF5-E011-8142-91573D78A8AC', '20303705', 'SD NEGERI 2 WANAKARSA', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('C0C9C055-2DF5-E011-AD9C-8FCD8C020AF9', '20303974', 'SD NEGERI 1 PANAWAREN', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('C0D5205A-2DF5-E011-B00B-E716D9BF5B88', '20304044', 'SMP NEGERI 2 BANJARMANGU', 'NEGERI', 'Kec. Banjarmangu', 'SMP');
INSERT INTO `sekolah` VALUES ('C0E1CA55-2DF5-E011-AC9C-0715D559B957', '20304434', 'SD NEGERI 1 SAMPANG', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('C0E3BD55-2DF5-E011-AA55-2D9B0261049A', '20303721', 'SD NEGERI 3 BINORONG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('C0ECB555-2DF5-E011-8C9F-43499F9258A7', '20303749', 'SD NEGERI 2 SIRKANDI', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('C0EDD355-2DF5-E011-9349-674A6FF36591', '20303922', 'SD NEGERI 2 PANDANSARI', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('C0EECA55-2DF5-E011-80FD-BD7338A5765A', '20303895', 'SD NEGERI 2 PURWODADI', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('C0F0BA55-2DF5-E011-8256-1108021FD2DF', '20303791', 'SD NEGERI 3 KALIAJIR', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('C2655319-5BEA-4E85-910B-C58275EA1722', '70033932', 'MI AL MUBAROK KALISATKIDUL', 'SWASTA', 'Kec. Kalibening', 'MI');
INSERT INTO `sekolah` VALUES ('C2D896E7-4871-4A49-A167-D10FDC5B72EC', '60710693', 'MIS MUHAMMADIYAH SEMAMPIR', 'SWASTA', 'Kec. Banjarnegara', 'MI');
INSERT INTO `sekolah` VALUES ('C2EBA854-4463-48F4-8E72-29C61548400D', '60710685', 'MIS MUHAMMADIYAH GRIPIT', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('C4EB6819-61D9-4E6D-926E-63735CC927E3', '60710739', 'MIS MUHAMMADIYAH SOMAWANGI', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('C51CA480-5F1A-4324-AD41-31B19344B0A7', '60710852', 'MIS COKROAMINOTO TAPEN', 'SWASTA', 'Kec. Wanadadi', 'MI');
INSERT INTO `sekolah` VALUES ('C6258FDA-ECB3-4E66-B7E4-B0557019AAF6', '60710723', 'MIS GUPPI 01 DIWEK', 'SWASTA', 'Kec. Karangkobar', 'MI');
INSERT INTO `sekolah` VALUES ('C63EDF10-5773-4B87-BF2B-63298DC79760', '20363496', 'MTSN 2 BANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'MTs');
INSERT INTO `sekolah` VALUES ('C66C1026-62EF-4E32-9B21-89CD6336E95B', '20303941', 'SMK TAMANSISWA BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMK');
INSERT INTO `sekolah` VALUES ('C6D62C75-7658-497C-88C6-8EC94F5E1D79', '60710701', 'MIS MUHAMMADIYAH PUCANG', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('C6FC7838-677D-4955-9C82-70AB0F2DE5BF', '60710717', 'MIS GUPPI TIMBANG', 'SWASTA', 'Kec. Kalibening', 'MI');
INSERT INTO `sekolah` VALUES ('C859D6E9-E2BA-4B88-816C-629578020DA8', '60710775', 'MIS MUHAMMADIYAH KARANGSARI', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('C8761AF9-9BA8-453B-8E49-C8E6CE2E5FBE', '60710770', 'MIS COKROAMINOTO NGASINAN', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('C9926FDC-2A4C-4697-B117-2F6FCE5FB5DB', '60710691', 'MIS MUHAMMADIYAH 02 MERDEN', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('CB31C0CC-2CC6-4E4D-9D9B-8F9BC2B65EAE', '60710758', 'MIS MUHAMMADIYAH MELIKAN', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('CCE73AD1-0D00-447F-8760-00132293B9B5', '60710730', 'MIS GUPPI RAKITAN', 'SWASTA', 'Kec. Madukara', 'MI');
INSERT INTO `sekolah` VALUES ('CDA6D347-2454-4259-86BF-635247A3A8BE', '60710871', 'MIS MA`ARIF SUWIDAK', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('CDAB0287-5374-4439-97DB-E7CC876A6DCD', '60710725', 'MIS GUPPI SEGAN', 'SWASTA', 'Kec. Karangkobar', 'MI');
INSERT INTO `sekolah` VALUES ('CE2F57DC-EA38-4DE3-8C98-C8BCEDEA0538', '60710868', 'MIS MUHAMMADIYAH KUNINGAN', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('CE9EFEB7-4D6B-418F-9152-FDB294FFDB41', '60710799', 'MIS MUHAMMADIYAH 02 DANAKERTA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('D00E215A-2DF5-E011-ADCF-01C29CF3F90A', '20303997', 'SMP NEGERI 2 RAKIT', 'NEGERI', 'Kec. Rakit', 'SMP');
INSERT INTO `sekolah` VALUES ('D013BC55-2DF5-E011-A6C2-8DC7ECFC42CB', '20304136', 'SD NEGERI 1 KUTAYASA', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('D01CB855-2DF5-E011-B2AB-C98ECC834AF5', '20338259', 'SD NEGERI 3 PURWASABA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('D026B255-2DF5-E011-88B5-67417EE07C18', '20304522', 'SD NEGERI 1 SUSUKAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('D02DBF55-2DF5-E011-BA5C-7389BE5E91D0', '20304618', 'SD NEGERI 1 KEBUTUHJURANG', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('D033B555-2DF5-E011-B1A9-092F36C6BDCC', '20303897', 'SD NEGERI 2 PURWAREJA', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('D03BD555-2DF5-E011-9E40-1FFB3ED27F3B', '20304425', 'SD NEGERI 1 SIDAKANGEN', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('D04DD255-2DF5-E011-8187-073766C56091', '20304655', 'SD NEGERI 1 KARANGTENGAH', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('D058CB55-2DF5-E011-80C6-97D27F39299E', '20303973', 'SD NEGERI PAWEDEN', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('D05CD755-2DF5-E011-A857-F5268044A341', '20304513', 'SD NEGERI 1 SIRONGGE', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('D06BC355-2DF5-E011-8C46-D9B75B8CF6FF', '20304646', 'SD NEGERI 1 KALILUNJAR', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('D06ECF55-2DF5-E011-B610-4B669153C23C', '20304113', 'SD NEGERI METAWANA', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('D06FBF55-2DF5-E011-80A5-1BBE6BCF584B', '20304570', 'SD NEGERI 1 GUNUNGJATI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('D07E6DA3-EDB9-E111-94A8-ABAEEFEB870C', '20304109', 'SD NEGERI 3 WANAYASA', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('D0842506-07B6-E111-9839-831F07CAAF1F', '20351035', 'SMP NEGERI 2 SATU ATAP SIGALUH', 'NEGERI', 'Kec. Sigaluh', 'SMP');
INSERT INTO `sekolah` VALUES ('D0A4BC55-2DF5-E011-99EF-DD0C826B89A0', '20303859', 'SD NEGERI 2 GENTANSARI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('D0A5C455-2DF5-E011-A690-B7E22E6B0981', '20304506', 'SD NEGERI 1 WANADADI', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('D0AA205A-2DF5-E011-A61E-53630C72479E', '20303993', 'SMP NEGERI 3 BANJARNEGARA', 'NEGERI', 'Kec. Madukara', 'SMP');
INSERT INTO `sekolah` VALUES ('D0B5C7CE-9EBA-4861-8767-BF788EAE1D4D', '60710741', 'MIS AL MA`ARIF MANDIRAJA WETAN', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('D0BAC355-2DF5-E011-B4D4-C57BBD8C0972', '20304518', 'SD NEGERI 1 SIGEBLOG', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('D0BD75E5-1887-42C0-AF2F-92182D10174F', '20303937', 'SMK NEGERI 2 BAWANG', 'NEGERI', 'Kec. Bawang', 'SMK');
INSERT INTO `sekolah` VALUES ('D0C3B655-2DF5-E011-84C6-6D2CB324F8A1', '20304158', 'SD NEGERI 6 KLAMPOK', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('D0CCBC55-2DF5-E011-A4C1-61E81B08341E', '20304651', 'SD NEGERI 1 KEBONDALEM', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('D0E3A95A-2DF5-E011-B710-D3C14D4E025B', '20303953', 'SMP ISLAM AL MUNAWWAROH', 'SWASTA', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('D0F9D455-2DF5-E011-9B0C-97D1A50B0E09', '20304601', 'SD NEGERI 1 BEDANA', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('D0FFC555-2DF5-E011-BECD-79E80E2C7E9C', '20303760', 'SD NEGERI 3 MEDAYU', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('D1280FFB-AB79-4EE0-A3BD-95590E694C41', '20363519', 'MTSS MUHAMMADIYAH MERDEN', 'SWASTA', 'Kec. Purwanegara', 'MTs');
INSERT INTO `sekolah` VALUES ('D2BB4726-0718-4AD2-8AF4-6F1F7AB62285', '60710734', 'MIS AL HIDAYAH PURWASABA', 'SWASTA', 'Kec. Mandiraja', 'MI');
INSERT INTO `sekolah` VALUES ('D32D419E-F31C-4251-A06D-171F00BBAC84', '60710809', 'MIS ISLAMIYAH KECITRAN', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('D4DAA066-10A6-4AEA-A10F-1F9E92896A92', '60710728', 'MIS COKROAMINOTO 01 DAWUHAN', 'SWASTA', 'Kec. Madukara', 'MI');
INSERT INTO `sekolah` VALUES ('D56C413C-296B-404E-A98C-9F1F059B17D6', '20303943', 'SMK MUHAMMADIYAH BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMK');
INSERT INTO `sekolah` VALUES ('D609CC54-8BF7-441E-A188-D754693D84F8', '20363528', 'MTSS MUHAMMADIYAH WANAYASA', 'SWASTA', 'Kec. Wanayasa', 'MTs');
INSERT INTO `sekolah` VALUES ('D61DBEEA-945B-4829-85F7-EF583FCDD021', '60710821', 'MIS MA`ARIF PUCUNGBEDUG', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('D63271B1-B40D-4BA8-8B07-E172443E5311', '60710749', 'MIS GUPPI LEBAKWANGI', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('D6E9CC50-0083-4078-A2A1-99F8754021B6', '20303936', 'SMK PANCA BHAKTI BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMK');
INSERT INTO `sekolah` VALUES ('D7110111-C30F-410A-BC68-9710EE18AF8A', '60710680', 'MIS MUHAMMADIYAH BANJARMANGU', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('D79CB0DD-9476-4FB1-9CC3-333940101DC4', '60710771', 'MIS COKROAMINOTO BANDUNGAN', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('D8488219-7E19-4777-B528-9B2CB814718A', '60710876', 'MIS MUHAMMADIYAH PENANGGUNGAN', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('D92CD3D4-2B28-47D6-B3C0-B9B0E182DC4C', '60710785', 'MIS COKROAMINOTO PURWASANA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('DAB40AA7-ADC6-4AE7-9B7E-46B578636724', '60710788', 'MIS MUHAMMADIYAH BADAKARYA', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('DB7F4985-2A4C-4F42-B655-243A676E367E', '60710807', 'MIS AL FATAH1 SIRKANDI', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('DBB18C30-23C7-483B-8152-9CBCCCB6199B', '69895108', 'Raudlotut Tholibin Purwanegara', 'SWASTA', 'Kec. Purwanegara', 'MTs');
INSERT INTO `sekolah` VALUES ('DBB8E676-7EBC-4CFB-8A08-95B6261645DB', '69956204', 'MIS AHSANUL `ULUM', 'SWASTA', 'Kec. Banjarnegara', 'MI');
INSERT INTO `sekolah` VALUES ('DC708A7C-A5C0-4C4D-A460-FAA8766A4838', '60710682', 'MIS COKROAMINOTO KESENET', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('DCDAE155-026D-4388-875B-9D6BAA85D3BD', '20350560', 'SMK COKROAMINOTO WANADADI', 'SWASTA', 'Kec. Wanadadi', 'SMK');
INSERT INTO `sekolah` VALUES ('E001BE53-2DF5-E011-899A-E3A1240B1E3B', '20303805', 'SD NEGERI 3 KEBONDALEM', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('E006B755-2DF5-E011-9410-B56E3FEA8B46', '20338239', 'SD NEGERI 1 KERTAYASA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('E008B555-2DF5-E011-A753-55349BC74219', '20304160', 'SD NEGERI 9 GUMELEM KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('E008C955-2DF5-E011-94FC-53AC666E05F0', '20304525', 'SD NEGERI 1 TRIBUANA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('E00AC455-2DF5-E011-B5CA-1143374CD0C1', '20303739', 'SD NEGERI 2 SIPEDANG', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('E00CC655-2DF5-E011-98DA-3B5503B0A9E6', '20303807', 'SD NEGERI 3 KASILIB', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('E00FB855-2DF5-E011-AD72-93CC3C53F076', '20338248', 'SD NEGERI 2 JALATUNDA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('E017BE55-2DF5-E011-86BF-EFC456463227', '20304071', 'SD NEGERI 4 WANADRI', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('E01DC555-2DF5-E011-BF1E-A33CF50159DD', '20304662', 'SD NEGERI 1 KARANGKEMIRI', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('E02CB455-2DF5-E011-8D32-457C3956D275', '20303723', 'SD NEGERI 3 BERTA', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('E02EC255-2DF5-E011-9146-D17E9CD3F56F', '20304423', 'SD NEGERI 1 RAKITAN', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('E02FD655-2DF5-E011-A8C7-63667FEC7BBE', '20303833', 'SD NEGERI 2 KERTOSARI', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('E035C355-2DF5-E011-AC0D-193919A71BAC', '20304498', 'SD NEGERI BEJI', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('E035D455-2DF5-E011-BDDF-4923FD700F07', '20303879', 'SD NEGERI 02 PENANGGUNGAN', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('E03AB955-2DF5-E011-9841-51ABD2B10E2A', '20338269', 'SD NEGERI 7 SOMAWANGI', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('E03BC255-2DF5-E011-A718-877DC2C1261B', '20304132', 'SD NEGERI MADUKARA', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('E03ED355-2DF5-E011-933A-C7C1A44D81A6', '20304454', 'SD NEGERI 1 PAGERGUNUNG', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('E03FBE55-2DF5-E011-B438-077BE3E047FC', '20304550', 'SD NEGERI 1 GENTANSARI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('E045BD55-2DF5-E011-8060-CF69E1F2810F', '20304108', 'SD NEGERI 3 WINONG', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('E048C255-2DF5-E011-877C-8DEB9A9D6775', '20303967', 'SD NEGERI REJASA', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('E04BCB55-2DF5-E011-83F2-71D497E27128', '20303819', 'SDN 2 Karanggondang', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('E052C555-2DF5-E011-955A-BB4610996AC4', '20303707', 'SD NEGERI 2 WANADADI', 'NEGERI', 'Kec. Wanadadi', 'SD');
INSERT INTO `sekolah` VALUES ('E052D155-2DF5-E011-81E6-B7F4E6DD745C', '20304474', 'SD NEGERI 1 PEGUNDUNGAN', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('E05A1B59-2DF5-E011-B711-4D3837777242', '20304588', 'SD KRISTEN KLAMPOK', 'SWASTA', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('E05AB755-2DF5-E011-871A-25D5701EFE43', '20340549', 'SD NEGERI 2 PURWASABA', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('E062215A-2DF5-E011-94EB-718E8C81557F', '20304027', 'SMP NEGERI 1 KARANGKOBAR', 'NEGERI', 'Kec. Karangkobar', 'SMP');
INSERT INTO `sekolah` VALUES ('E062BF55-2DF5-E011-BB10-F72D07C7C379', '20304487', 'SD NEGERI 1 WANGON', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('E064C955-2DF5-E011-84B2-95296F5CE742', '20303847', 'SD NEGERI 2 GEMBOL', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('E065CB55-2DF5-E011-8403-970D30E7C9AC', '20303883', 'SD Negeri 2 Pasuruhan', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('E069D755-2DF5-E011-8A6F-EB10AFE24B3E', '20303740', 'SD NEGERI 2 SIRONGGE', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('E06D78E0-1239-400C-BD65-F19BC42EE90F', '70005649', 'SD KHALIMUL KHASAN 1 BILINGUAL SCHOOL', 'SWASTA', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('E06FB955-2DF5-E011-A402-8D385CA64F00', '20303773', 'SD NEGERI 3 PURWANEGARA', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('E076D755-2DF5-E011-A187-1B53293D3614', '20304092', 'SD NEGERI 3 SIRONGGE', 'NEGERI', 'Kec. Pandanarum', 'SD');
INSERT INTO `sekolah` VALUES ('E079BDD8-04B6-E111-9073-67E9F66297B5', '20351017', 'SMP NEGERI 6 SATAP PUNGGELAN', 'NEGERI', 'Kec. Punggelan', 'SMP');
INSERT INTO `sekolah` VALUES ('E07DB755-2DF5-E011-A5D2-9392A6BB27EC', '20338233', 'SD NEGERI 1 GLEMPANG', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('E083E9E4-ECB9-E111-AF48-67B786FBB2F5', '20303893', 'SD NEGERI 2 RATAMBA', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('E08B5CE8-1816-433F-A54E-DFB5B16F96FE', '70028668', 'SD ISLAM INTEGRAL HIDAYATULLAH BANJARNEGARA', 'SWASTA', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('E08BB655-2DF5-E011-BAA9-E5846C3A895D', '20304060', 'SD NEGERI 4 KALIWINASUH', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('E08DB255-2DF5-E011-9F1B-A9DFBBFC0AEA', '20304543', 'SD NEGERI 1 DERMASARI', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('E08FBE55-2DF5-E011-9020-1BA24483DA60', '20303765', 'SD NEGERI 3 KUTABANJARNEGARA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('E090B555-2DF5-E011-8787-D1909A8302E5', '20304645', 'SD NEGERI 1 KALIMANDI', 'NEGERI', 'Kec. Purwareja Klampok', 'SD');
INSERT INTO `sekolah` VALUES ('E091C755-2DF5-E011-9AA2-A3D7CF05C1F9', '20304084', 'SD NEGERI 3 TANJUNGANOM', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('E09FCA55-2DF5-E011-AABE-61048FD55A88', '20304413', 'SD NEGERI 1 PURWODADI', 'NEGERI', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('E0B6C155-2DF5-E011-9895-43A91BD5ADB7', '20304134', 'SD NEGERI LIMBANGAN', 'NEGERI', 'Kec. Madukara', 'SD');
INSERT INTO `sekolah` VALUES ('E0B7CF55-2DF5-E011-9D3C-49C0D4A04B0C', '20304491', 'SD NEGERI 2 BABADAN', 'NEGERI', 'Kec. Pagentan', 'SD');
INSERT INTO `sekolah` VALUES ('E0BEBF55-2DF5-E011-9FDD-9FFA59AABED4', '20304481', 'SD NEGERI 2 AMPELSARI', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('E0BFB755-2DF5-E011-8223-579E269E7BCA', '20338249', 'SD NEGERI 2 KALIWUNGU', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('E0C5A95A-2DF5-E011-B291-D5A4F1E367BA', '20303957', 'SMP COKROAMINOTO BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('E0D4A95A-2DF5-E011-B339-1B2B0D4C8C99', '20304033', 'SMP TAMANSISWA BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('E0D7D155-2DF5-E011-B589-B114CA7496AF', '20303857', 'SD NEGERI 2 CONDONGCAMPUR', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('E0E7B755-2DF5-E011-AABD-C5038D06D8EB', '20338266', 'SD NEGERI 2 SOMAWANGI', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('E0E81F5A-2DF5-E011-BD21-4BDF787DF537', '20304001', 'SMP NEGERI 2 PURWANEGARA', 'NEGERI', 'Kec. Purwanegara', 'SMP');
INSERT INTO `sekolah` VALUES ('E0EBBE55-2DF5-E011-88CD-BF6A12AC7F14', '20304634', 'SD NEGERI 1 KEBUTUHDUWUR', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('E0F3B255-2DF5-E011-90EF-0BC79A82DCD2', '20304658', 'SD NEGERI 1 KARANGSALAM', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('E0F3BF55-2DF5-E011-A71A-99CCB474E67C', '20303738', 'SD NEGERI 2 SEMAMPIR', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('E0FDC355-2DF5-E011-8D07-DBA6FE1705C2', '20303832', 'SD NEGERI 2 KESENET', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('E130A591-001E-4496-915F-4564650C61B9', '60710838', 'MADRASAH IBTIDAIYAH COKROAMINOTO LENGKONG', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('E1730B72-88B5-4E9A-958F-4110403581C2', '60710690', 'MIS MUHAMMADIYAH SIGEBLOG', 'SWASTA', 'Kec. Banjarmangu', 'MI');
INSERT INTO `sekolah` VALUES ('E4146DB2-B043-4C71-88D7-F0DDC4D8BDB3', '60710811', 'MIS MUHAMMADIYAH KALIMANDI', 'SWASTA', 'Kec. Purwareja Klampok', 'MI');
INSERT INTO `sekolah` VALUES ('E423C664-2F47-42A3-8BF7-D8688BFA7880', '20363515', 'MTSS MUHAMMADIYAH KECEPIT', 'SWASTA', 'Kec. Punggelan', 'MTs');
INSERT INTO `sekolah` VALUES ('E44F31E7-FB7A-4592-B42E-FEED9A2BCB53', '70033996', 'MTs AL HAMIDAH', 'SWASTA', 'Kec. Rakit', 'MTs');
INSERT INTO `sekolah` VALUES ('E47FA839-D17E-4C20-997B-925B073AA486', '60710792', 'MI COKROAMINOTO 02 BONDOLHARJO', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('E72900F6-606C-48B5-8B30-8CB729AE1D1F', '20303980', 'SMA NEGERI 1 PURWANEGARA', 'NEGERI', 'Kec. Purwanegara', 'SMA');
INSERT INTO `sekolah` VALUES ('E7425EFF-1A76-44C6-92CC-1A5E7644F6A2', '20364906', 'MA AL IRSYAD GUNUNGJATI', 'SWASTA', 'Kec. Pagedongan', 'MA');
INSERT INTO `sekolah` VALUES ('E9136524-81C5-4446-A4D5-B9DFEEAEF33C', '69881650', 'MTSS Andalusia', 'SWASTA', 'Kec. Banjarnegara', 'MTs');
INSERT INTO `sekolah` VALUES ('EB2BC2AE-9B57-4D72-90EC-87ECD215069E', '60710732', 'MIS COKROAMINOTO 02 DAWUHAN', 'SWASTA', 'Kec. Madukara', 'MI');
INSERT INTO `sekolah` VALUES ('EB874C3E-EFBC-4EBF-9F42-EC6BD7579F6D', '70033966', 'MI MA`ARIF NU 01 RAKIT', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('EBB821E1-FD21-43D5-B2E0-3DDE9D2986B0', '69881428', 'MAS  Muhammadiyah Sigaluh', 'SWASTA', 'Kec. Sigaluh', 'MA');
INSERT INTO `sekolah` VALUES ('ECE1D7D9-79FD-419C-9FB8-D9322AD1C813', '60710819', 'MIS MUHAMMADIYAH KARANGANYAR', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('ECFACB9B-089D-4EBF-B721-BC047AA06384', '20363517', 'MTSS COKROAMINOTO TRIBUANA', 'SWASTA', 'Kec. Punggelan', 'MTs');
INSERT INTO `sekolah` VALUES ('EE02A802-1B7F-4515-BCE9-D0C7C88539F9', '60710826', 'MIS NU 02 SITUWANGI', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('EE564E4D-7393-4B5D-A1B3-3E57A68D7B03', '60728791', 'MAS TANBIHUL GHOFILIN', 'SWASTA', 'Kec. Bawang', 'MA');
INSERT INTO `sekolah` VALUES ('F0047D5A-2DF5-E011-A0C7-67E66CB1E949', '20340882', 'SMP NURUL AMBIYA MANDIRAJA', 'SWASTA', 'Kec. Mandiraja', 'SMP');
INSERT INTO `sekolah` VALUES ('F012D355-2DF5-E011-A8E2-05CD367136DB', '20304488', 'SD NEGERI 1 WANAYASA', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('F019C755-2DF5-E011-85BB-69FA8F8CBD69', '20303848', 'SD NEGERI 2 GELANG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('F01DB455-2DF5-E011-8715-0F67FA0F8765', '20304153', 'SD NEGERI 5 GUMELEM WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('F022C955-2DF5-E011-A402-5B0D13B2FE8E', '20304409', 'SD NEGERI 1 SIDARATA', 'NEGERI', 'Kec. Punggelan', 'SD');
INSERT INTO `sekolah` VALUES ('F028C355-2DF5-E011-841A-A3F317706BCE', '20304613', 'SD NEGERI 1 KENDAGA', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('F029B855-2DF5-E011-A873-4F4FA77143D6', '20338258', 'SD NEGERI 3 PANGGISARI', 'NEGERI', 'Kec. Mandiraja', 'SD');
INSERT INTO `sekolah` VALUES ('F033C755-2DF5-E011-B60A-F95D027E8DEA', '20303876', 'SD NEGERI 2 PINGIT', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('F03BC455-2DF5-E011-9B8B-B349E5C52BFE', '20303885', 'SD NEGERI 2 PASEH', 'NEGERI', 'Kec. Banjarmangu', 'SD');
INSERT INTO `sekolah` VALUES ('F03CD655-2DF5-E011-A814-D9B279BD4331', '20303735', 'SD NEGERI 2 SEMBAWA', 'NEGERI', 'Kec. Kalibening', 'SD');
INSERT INTO `sekolah` VALUES ('F043B255-2DF5-E011-8B64-3784366F4E1F', '20304574', 'SD NEGERI 1 GUMELEM WETAN', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('F05DC055-2DF5-E011-B8D5-95E6A83C66F2', '20303716', 'SD NEGERI 3 CENDANA', 'NEGERI', 'Kec. Banjarnegara', 'SD');
INSERT INTO `sekolah` VALUES ('F068E96A-03B6-E111-87FC-1B4F94186E3E', '20340880', 'SMP NEGERI 2 SATU ATAP PANDANARUM', 'NEGERI', 'Kec. Pandanarum', 'SMP');
INSERT INTO `sekolah` VALUES ('F07CB955-2DF5-E011-BA1B-8F06941737FD', '20304547', 'SD NEGERI 1 DANARAJA', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('F093C055-2DF5-E011-8C73-BD9CF442C1B7', '20304515', 'SD NEGERI 1 SINGAMERTA', 'NEGERI', 'Kec. Sigaluh', 'SD');
INSERT INTO `sekolah` VALUES ('F09BD255-2DF5-E011-B35E-79601E680D22', '20304542', 'SD NEGERI 1 DIENGKULON', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('F0A1BD55-2DF5-E011-B7A4-9F6D79E135DE', '20304486', 'SD NEGERI 1 WATUURIP', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('F0AC66D7-8DFC-E111-8A14-7BC0D673D885', '20340902', 'SD Negeri 1 Karangtengah', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('F0AEBA55-2DF5-E011-A627-E5AAB2D9ED15', '20303905', 'SD NEGERI 2 PARAKAN', 'NEGERI', 'Kec. Purwanegara', 'SD');
INSERT INTO `sekolah` VALUES ('F0B9B688-05B6-E111-8A13-19DBDC231517', '20303858', 'SD NEGERI 2 GEMURUH', 'NEGERI', 'Kec. Bawang', 'SD');
INSERT INTO `sekolah` VALUES ('F0B9C755-2DF5-E011-8076-A1967918224C', '20340899', 'SD NEGERI 6 LENGKONG', 'NEGERI', 'Kec. Rakit', 'SD');
INSERT INTO `sekolah` VALUES ('F0BD1F5A-2DF5-E011-B2BB-C52B9D8BF16C', '20304009', 'SMP NEGERI 3 MANDIRAJA', 'NEGERI', 'Kec. Mandiraja', 'SMP');
INSERT INTO `sekolah` VALUES ('F0C2D355-2DF5-E011-AADE-FB7D6839B83D', '20304471', 'SD NEGERI 1 PENANGGUNGAN', 'NEGERI', 'Kec. Wanayasa', 'SD');
INSERT INTO `sekolah` VALUES ('F0E8AD63-ABDC-E211-9E7C-7FFB85D7433E', '20304600', 'SD NEGERI 1 BEJI', 'NEGERI', 'Kec. Pejawaran', 'SD');
INSERT INTO `sekolah` VALUES ('F0EBD255-2DF5-E011-A92D-0969D0D00317', '20304161', 'SD NEGERI 9 BATUR', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('F0F0BD55-2DF5-E011-9D8F-7521A1BC4897', '20303763', 'SD NEGERI 3 LEBAKWANGI', 'NEGERI', 'Kec. Pagedongan', 'SD');
INSERT INTO `sekolah` VALUES ('F0F1D155-2DF5-E011-AE4F-0577B2BE28F2', '20304501', 'SD NEGERI 2 BATUR', 'NEGERI', 'Kec. Batur', 'SD');
INSERT INTO `sekolah` VALUES ('F0F9B455-2DF5-E011-BD91-EF264EEE3BCC', '20304162', 'SD NEGERI 8 GUMELEM KULON', 'NEGERI', 'Kec. Susukan', 'SD');
INSERT INTO `sekolah` VALUES ('F293616D-3F32-4F68-96FF-B16C1E43DD17', '60710752', 'MIS MA`ARIF JAGANGSARI', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('F2A04732-E279-476C-A53E-E555762CC042', '60710781', 'MIS MUHAMMADIYAH KECEPIT', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('F2B8E6B8-9513-4DC8-B374-2AF904F38512', '20363523', 'MTSS COKROAMINOTO BADAMITA', 'SWASTA', 'Kec. Rakit', 'MTs');
INSERT INTO `sekolah` VALUES ('F2E0A254-EF7C-4AD2-A8A4-4BB21C02E30A', '70015854', 'SDIT INSAN MULIA KARANGKOBAR', 'SWASTA', 'Kec. Karangkobar', 'SD');
INSERT INTO `sekolah` VALUES ('F31599D9-7C21-48DB-8B06-E65E50259EC8', '20363521', 'MTSN 3 BANJARNEGARA', 'NEGERI', 'Kec. Rakit', 'MTs');
INSERT INTO `sekolah` VALUES ('F322A145-574A-4A8A-978B-98239204DD2D', '60710746', 'MIS COKROAMINOTO GENTANSARI', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('F3636A6F-0A52-47FD-8C6D-7FAFD573523E', '60710761', 'MIS COKROAMINOTO 02 KEBUTUHJURANG', 'SWASTA', 'Kec. Pagedongan', 'MI');
INSERT INTO `sekolah` VALUES ('F3E279CC-2A51-4860-90E8-7A8AB81DFE6B', '60710834', 'MIS COKROAMINOTO KINCANG', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('F473A660-2939-4FBF-92DB-3DD00B57D7CB', '70039040', 'SMP AL QUR AN DAN DAKWAH ALAM BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMP');
INSERT INTO `sekolah` VALUES ('F4850031-F3E0-42D1-B74F-8F98EFDDF470', '60726962', 'MIS MA`ARIF NURUL FATAH PETIR', 'SWASTA', 'Kec. Purwanegara', 'MI');
INSERT INTO `sekolah` VALUES ('F4A99927-23F9-47F0-9075-9800710F290F', '60710865', 'MIS MA`ARIF PANDANSARI', 'SWASTA', 'Kec. Wanayasa', 'MI');
INSERT INTO `sekolah` VALUES ('F554B1E7-6340-4A6B-9134-8E916E47E0BF', '60710697', 'MIS MUHAMMADIYAH 02 BATUR', 'SWASTA', 'Kec. Batur', 'MI');
INSERT INTO `sekolah` VALUES ('F71CBB1F-DF59-40B4-9BBE-AFA1BED8B314', '60710829', 'MIS AL MAARIF GELANG', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('FA3B0695-9EE8-4053-BD4A-43660C7027E2', '60710766', 'MIS MUHAMMADIYAH GETAS', 'SWASTA', 'Kec. Pandanarum', 'MI');
INSERT INTO `sekolah` VALUES ('FAB85855-1DF3-44A5-8D72-A388886E6DFC', '60710777', 'MIS MUHAMMADIYAH GERMADANG', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('FACEB9E0-01A7-4642-8B10-6156CA55F02C', '60710769', 'MI MUHAMMADIYAH PENUSUPAN', 'SWASTA', 'Kec. Pejawaran', 'MI');
INSERT INTO `sekolah` VALUES ('FCC2CDA5-4F83-42E3-8906-E72201C92C8A', '60710837', 'MIS COKROAMINOTO LUWUNG', 'SWASTA', 'Kec. Rakit', 'MI');
INSERT INTO `sekolah` VALUES ('FD12A25F-1B79-4176-AA2F-770CC600F287', '20363525', 'MTSS MUHAMMADIYAH SIGALUH', 'SWASTA', 'Kec. Sigaluh', 'MTs');
INSERT INTO `sekolah` VALUES ('FD7FB9D1-4105-4BBC-AA79-9F5EF1B67828', '60710779', 'MIN 4 BANJARNEGARA', 'NEGERI', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('FD853E91-3FEB-45C4-90FD-94F6C9A43E63', '60710709', 'MIS MUHAMMADIYAH MASARAN', 'SWASTA', 'Kec. Bawang', 'MI');
INSERT INTO `sekolah` VALUES ('FDEA94B8-16B9-4AAD-B4A4-08AFF9089CF8', '60710805', 'MIS COKROAMINOTO SAWANGAN', 'SWASTA', 'Kec. Punggelan', 'MI');
INSERT INTO `sekolah` VALUES ('FE4D2413-5405-49B9-A29B-8FBF828F3C20', '20338494', 'SMAS COKROAMINOTO 1 BANJARNEGARA', 'SWASTA', 'Kec. Banjarnegara', 'SMA');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekolah_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `no_wa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(1) NOT NULL,
  `isActive` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('6d929831-65f1-42ad-82c9-38d1c8a686dc', 'Operator SD Muhammadiyah Danaraja', '000BBB55-2DF5-E011-87A9-47CF1D434172', '08888812093', 'sd_muh_danaraja', '$2y$10$3dU5nULvoY4oS0JwfKvN5uJUZpGwwUCeB4qVbca2w.isMmkQwfUNW', 2, '1', '2025-12-13 19:12:19', NULL);
INSERT INTO `users` VALUES ('94fcf8dd-240f-4ab9-ae32-24cf2bde3c82', 'Admin 1', NULL, NULL, 'admin', '$2y$10$lq.0xmZyrgDtAgS3o/e2x.A/HqqN3wQAyi31SZluyKgNeLH66nwA.', 1, '1', '2025-11-22 20:28:33', '2026-01-27 22:06:09');
INSERT INTO `users` VALUES ('97ee1129-ecf7-403b-a573-11552d6b5223', 'operator berta 1', '206CAB5B-EDB9-E111-BADA-7539C92D9F6D', '123', 'berta1', '$2y$10$YXKbsHXSA7q1XzdI7h0Ii.WcOzPKdIyVP4zFZkXl6CPEZgcGOIyVy', 2, '1', '2026-02-05 21:38:17', NULL);
INSERT INTO `users` VALUES ('a06a7519-3da0-4fc2-a859-a934d5c1d1df', 'Agus Suberta 4', '0018B555-2DF5-E011-88AB-41D0C9C75D87', '0812391203', 'berta4', '$2y$10$39LxcL/9ITzHR56REWWMWOcCdykTPRB5VS9oVYLiGOgs2Yu3eEcpK', 2, '1', '2026-01-28 14:40:45', '2026-02-04 10:24:09');

SET FOREIGN_KEY_CHECKS = 1;
