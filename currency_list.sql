-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.16-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for demorboutique
CREATE DATABASE IF NOT EXISTS `demorboutique` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `demorboutique`;

-- Dumping structure for table demorboutique.currencies
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_currency` varchar(80) NOT NULL DEFAULT '0',
  `currency_code` varchar(3) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;

-- Dumping data for table demorboutique.currencies: ~108 rows (approximately)
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` (`id`, `country_currency`, `currency_code`, `is_active`) VALUES
	(1, 'Albania Lek', 'ALL', 0),
	(2, 'Afghanistan Afghani', 'AFN', 0),
	(3, 'Argentina Peso', 'ARS', 0),
	(4, 'Aruba Guilder', 'AWG', 0),
	(5, 'Australia Dollar', 'AUD', 1),
	(6, 'Azerbaijan New Manat', 'AZN', 0),
	(7, 'Bahamas Dollar', 'BSD', 0),
	(8, 'Barbados Dollar', 'BBD', 0),
	(9, 'Belarus Ruble', 'BYN', 0),
	(10, 'Belize Dollar', 'BZD', 0),
	(11, 'Bermuda Dollar', 'BMD', 0),
	(12, 'Bolivia Bolíviano', 'BOB', 0),
	(13, 'Bosnia and Herzegovina Convertible Marka', 'BAM', 0),
	(14, 'Botswana Pula', 'BWP', 0),
	(15, 'Bulgaria Lev', 'BGN', 0),
	(16, 'Brazil Real', 'BRL', 0),
	(17, 'Brunei Darussalam Dollar', 'BND', 0),
	(18, 'Cambodia Riel', 'KHR', 0),
	(19, 'Canada Dollar', 'CAD', 1),
	(20, 'Cayman Islands Dollar', 'KYD', 0),
	(21, 'Chile Peso', 'CLP', 0),
	(22, 'China Yuan Renminbi', 'CNY', 0),
	(23, 'Colombia Peso', 'COP', 0),
	(24, 'Costa Rica Colon', 'CRC', 0),
	(25, 'Croatia Kuna', 'HRK', 0),
	(26, 'Cuba Peso', 'CUP', 0),
	(27, 'Czech Republic Koruna', 'CZK', 0),
	(28, 'Denmark Krone', 'DKK', 0),
	(29, 'Dominican Republic Peso', 'DOP', 0),
	(30, 'East Caribbean Dollar', 'XCD', 0),
	(31, 'Egypt Pound', 'EGP', 0),
	(32, 'El Salvador Colon', 'SVC', 0),
	(33, 'Euro Member Countries', 'EUR', 0),
	(34, 'Falkland Islands (Malvinas) Pound', 'FKP', 0),
	(35, 'Fiji Dollar', 'FJD', 0),
	(36, 'Ghana Cedi', 'GHS', 0),
	(37, 'Gibraltar Pound', 'GIP', 0),
	(38, 'Guatemala Quetzal', 'GTQ', 0),
	(39, 'Guernsey Pound', 'GGP', 0),
	(40, 'Guyana Dollar', 'GYD', 0),
	(41, 'Honduras Lempira', 'HNL', 0),
	(42, 'Hong Kong Dollar', 'HKD', 0),
	(43, 'Hungary Forint', 'HUF', 0),
	(44, 'Iceland Krona', 'ISK', 0),
	(45, 'India Rupee', 'INR', 0),
	(46, 'Indonesia Rupiah', 'IDR', 1),
	(47, 'Iran Rial', 'IRR', 0),
	(48, 'Isle of Man Pound', 'IMP', 0),
	(49, 'Israel Shekel', 'ILS', 0),
	(50, 'Jamaica Dollar', 'JMD', 0),
	(51, 'Japan Yen', 'JPY', 1),
	(52, 'Jersey Pound', 'JEP', 0),
	(53, 'Kazakhstan Tenge', 'KZT', 0),
	(54, 'Korea (North) Won', 'KPW', 0),
	(55, 'Korea (South) Won', 'KRW', 0),
	(56, 'Kyrgyzstan Som', 'KGS', 0),
	(57, 'Laos Kip', 'LAK', 0),
	(58, 'Lebanon Pound', 'LBP', 0),
	(59, 'Liberia Dollar', 'LRD', 0),
	(60, 'Macedonia Denar', 'MKD', 0),
	(61, 'Malaysia Ringgit', 'MYR', 0),
	(62, 'Mauritius Rupee', 'MUR', 0),
	(63, 'Mexico Peso', 'MXN', 0),
	(64, 'Mongolia Tughrik', 'MNT', 0),
	(65, 'Mozambique Metical', 'MZN', 0),
	(66, 'Namibia Dollar', 'NAD', 0),
	(67, 'Nepal Rupee', 'NPR', 0),
	(68, 'Netherlands Antilles Guilder', 'ANG', 0),
	(69, 'New Zealand Dollar', 'NZD', 0),
	(70, 'Nicaragua Cordoba', 'NIO', 0),
	(71, 'Nigeria Naira', 'NGN', 0),
	(72, 'Norway Krone', 'NOK', 0),
	(73, 'Oman Rial', 'OMR', 0),
	(74, 'Pakistan Rupee', 'PKR', 0),
	(75, 'Panama Balboa', 'PAB', 0),
	(76, 'Paraguay Guarani', 'PYG', 0),
	(77, 'Peru Sol', 'PEN', 0),
	(78, 'Philippines Peso', 'PHP', 0),
	(79, 'Poland Zloty', 'PLN', 0),
	(80, 'Qatar Riyal', 'QAR', 0),
	(81, 'Romania New Leu', 'RON', 0),
	(82, 'Russia Ruble', 'RUB', 0),
	(83, 'Saint Helena Pound', 'SHP', 0),
	(84, 'Saudi Arabia Riyal', 'SAR', 0),
	(85, 'Serbia Dinar', 'RSD', 0),
	(86, 'Seychelles Rupee', 'SCR', 0),
	(87, 'Singapore Dollar', 'SGD', 0),
	(88, 'Solomon Islands Dollar', 'SBD', 0),
	(89, 'Somalia Shilling', 'SOS', 0),
	(90, 'South Africa Rand', 'ZAR', 0),
	(91, 'Sri Lanka Rupee', 'LKR', 0),
	(92, 'Sweden Krona', 'SEK', 0),
	(93, 'Switzerland Franc', 'CHF', 0),
	(94, 'Suriname Dollar', 'SRD', 0),
	(95, 'Syria Pound', 'SYP', 0),
	(96, 'Taiwan New Dollar', 'TWD', 0),
	(97, 'Thailand Baht', 'THB', 0),
	(98, 'Trinidad and Tobago Dollar', 'TTD', 0),
	(99, 'Turkey Lira', 'TRY', 0),
	(100, 'Tuvalu Dollar', 'TVD', 0),
	(101, 'Ukraine Hryvnia', 'UAH', 0),
	(102, 'United Kingdom Pound', 'GBP', 1),
	(103, 'United States Dollar', 'USD', 1),
	(104, 'Uruguay Peso', 'UYU', 0),
	(105, 'Uzbekistan Som', 'UZS', 0),
	(106, 'Venezuela Bolivar', 'VEF', 0),
	(107, 'Viet Nam Dong', 'VND', 0),
	(108, 'Yemen Rial', 'YER', 0);
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
