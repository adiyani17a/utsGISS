-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.34-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for gis
CREATE DATABASE IF NOT EXISTS `gis` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `gis`;

-- Dumping structure for table gis.kota
CREATE TABLE IF NOT EXISTS `kota` (
  `id` int(11) NOT NULL,
  `kode_kabupaten` int(11) DEFAULT NULL,
  `nama_kabupaten` varchar(50) DEFAULT NULL,
  `nama_bupati` varchar(50) DEFAULT NULL,
  `jumlah_penduduk` int(11) DEFAULT NULL,
  `jumlah_ukm` int(11) DEFAULT NULL,
  `pusat_kota_latitude` varchar(50) DEFAULT NULL,
  `pusat_kota_longitude` varchar(50) DEFAULT NULL,
  `pusat_ukm_latitude` varchar(50) DEFAULT NULL,
  `pusat_ukm_longitude` varchar(50) DEFAULT NULL,
  `wilayah_latitude` varchar(300) DEFAULT NULL,
  `wilayah_longitude` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table gis.kota: ~0 rows (approximately)
/*!40000 ALTER TABLE `kota` DISABLE KEYS */;
REPLACE INTO `kota` (`id`, `kode_kabupaten`, `nama_kabupaten`, `nama_bupati`, `jumlah_penduduk`, `jumlah_ukm`, `pusat_kota_latitude`, `pusat_kota_longitude`, `pusat_ukm_latitude`, `pusat_ukm_longitude`, `wilayah_latitude`, `wilayah_longitude`) VALUES
	(1, NULL, 'sds', 'ddsd', 12, 12, '-7.29527997586906', '112.67002751811322', '-7.464157449740248', '112.79499700053509', '-7.209454811815859,-7.502282102273771,-7.539041996568683,-7.283020241180736,-7.1713050621443815', '112.57664372905072,112.71259953959759,112.90348699076947,112.87739446147259,112.75929143412884'),
	(2, NULL, 'sds', 'ddsd', 12, 12, '-7.29527997586906', '112.67002751811322', '-7.464157449740248', '112.79499700053509', '-7.209454811815859,-7.502282102273771,-7.539041996568683,-7.283020241180736,-7.1713050621443815', '112.57664372905072,112.71259953959759,112.90348699076947,112.87739446147259,112.75929143412884');
/*!40000 ALTER TABLE `kota` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
