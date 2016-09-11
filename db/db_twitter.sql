-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.26 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for db_twitter
CREATE DATABASE IF NOT EXISTS `db_twitter` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_twitter`;


-- Dumping structure for table db_twitter.tb_inbox
CREATE TABLE IF NOT EXISTS `tb_inbox` (
  `id_inbox` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inbox_id` bigint(20) unsigned NOT NULL,
  `inbox_user` bigint(20) NOT NULL,
  `inbox_user_screen` varchar(100) NOT NULL,
  `inbox_date` datetime NOT NULL,
  `inbox` text,
  PRIMARY KEY (`id_inbox`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=latin1;

-- Dumping data for table db_twitter.tb_inbox: ~42 rows (approximately)
DELETE FROM `tb_inbox`;
/*!40000 ALTER TABLE `tb_inbox` DISABLE KEYS */;
INSERT INTO `tb_inbox` (`id_inbox`, `inbox_id`, `inbox_user`, `inbox_user_screen`, `inbox_date`, `inbox`) VALUES
	(1, 597256046483144704, 181498811, 'catursatrya', '2015-09-06 11:07:49', '10 Mei 2015'),
	(2, 597256358958792704, 97298215, 'iksandili', '2015-09-06 11:07:49', 'Test'),
	(3, 597257964458672128, 150242468, 'JungDePutra', '2015-09-06 11:07:49', 'bang ayo kita duel pes 2015'),
	(4, 597258911209558016, 181498811, 'catursatrya', '2015-09-06 11:07:49', ' https://t.co/DAW3LkrV9y'),
	(5, 597259645728657408, 164896781, 'wayanjimmy', '2015-09-06 11:07:49', 'tes'),
	(6, 597263076325396481, 194836669, 'erick_pursana', '2015-09-06 11:07:49', 'Haloo bang'),
	(7, 602320663446102016, 181498811, 'catursatrya', '2015-09-06 11:07:49', '24 mei 2015'),
	(8, 620476144089853955, 181498811, 'catursatrya', '2015-09-06 11:07:49', 'asa'),
	(9, 620476525930917892, 181498811, 'catursatrya', '2015-09-06 11:07:49', 'test'),
	(10, 620477233296052227, 181498811, 'catursatrya', '2015-09-06 11:07:49', 'iya gmana bos?'),
	(11, 620477580865482755, 181498811, 'catursatrya', '2015-09-06 11:07:49', 'yow dagh'),
	(66, 620483095548956676, 3278188782, 'DfFahlevi', '2015-09-06 11:37:19', 'Uytg'),
	(67, 620483629240578051, 3278188782, 'DfFahlevi', '2015-09-06 11:37:19', 'Lagi sibuk main coc'),
	(68, 620484239423770627, 3278188782, 'DfFahlevi', '2015-09-06 11:37:19', 'Capek lagi main coc'),
	(69, 620490202335744003, 3278188782, 'DfFahlevi', '2015-09-06 11:37:19', 'Ghhh'),
	(70, 620640011940040705, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Gimana mas'),
	(71, 623745702758256644, 3278188782, 'DfFahlevi', '2015-09-06 11:37:19', 'Nugroho'),
	(72, 623805141888561156, 3278188782, 'DfFahlevi', '2015-09-06 11:37:19', 'Pusing kepalaku'),
	(73, 624173923714727940, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Harus traktir aq bang. Nanti klo aq ke bali.'),
	(74, 624397818870956036, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Hiks'),
	(75, 624397841159421963, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Jajanan di warung mas'),
	(76, 624398273902587907, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Ke bali bang. Tp bentar doang'),
	(77, 624398362767310851, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Lg bwt project apa bang ?'),
	(78, 624398392551051267, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Kayaknya interesting'),
	(79, 624409838081040387, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Oh jadi kamu nambah support twitter nya bang ?'),
	(80, 624409885770256388, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Kak saras jg bwt gtu dlu kayaknya.'),
	(81, 624409928229261316, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Ym q jg dijadiin percobaan wkwk'),
	(82, 624527402161451014, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Ok smngt bang'),
	(83, 624527422356979715, 164896781, 'wayanjimmy', '2015-09-06 11:37:19', 'Aq bantu doa aja hehe'),
	(112, 640332589702627331, 181498811, 'catursatrya', '2015-09-19 09:52:46', 'a'),
	(113, 640332673399943171, 181498811, 'catursatrya', '2015-09-19 09:52:46', 'b'),
	(114, 640332898525052932, 181498811, 'catursatrya', '2015-09-19 09:52:46', 'd'),
	(115, 640333159318450180, 181498811, 'catursatrya', '2015-09-19 09:52:46', 'eeeeeeee'),
	(116, 645055264408776708, 181498811, 'catursatrya', '2015-09-19 10:02:46', 'woi'),
	(117, 645056160085577733, 181498811, 'catursatrya', '2015-09-19 10:06:24', 'santai aj a bro..'),
	(118, 645056177655558148, 181498811, 'catursatrya', '2015-09-19 10:06:24', 'gpp kok'),
	(119, 645102270103687173, 181498811, 'catursatrya', '2015-09-19 13:09:23', 'hai'),
	(120, 645102613965307908, 181498811, 'catursatrya', '2015-09-19 13:10:45', 'aa'),
	(121, 645103227671719939, 3278188782, 'DfFahlevi', '2015-09-19 13:12:58', 'Banyak1'),
	(122, 645103524754296840, 3278188782, 'DfFahlevi', '2015-09-19 13:14:28', 'Masak SiH???'),
	(123, 645103871384096771, 3278188782, 'DfFahlevi', '2015-09-19 13:15:26', 'Hai hoy'),
	(124, 645103949431771141, 3278188782, 'DfFahlevi', '2015-09-19 13:15:56', 'Hfyxyffy'),
	(125, 645104086698725380, 3278188782, 'DfFahlevi', '2015-09-19 13:16:26', 'Males aku'),
	(126, 645104186145640451, 181498811, 'catursatrya', '2015-09-19 13:16:56', 'tes'),
	(127, 645104213874184195, 181498811, 'catursatrya', '2015-09-19 13:16:56', 'tes'),
	(128, 645392845520502787, 181498811, 'catursatrya', '2015-09-20 08:24:14', 'woiiiiiii'),
	(129, 645396238456614915, 181498811, 'catursatrya', '2015-09-20 08:37:40', 'test'),
	(130, 645396779127574531, 181498811, 'catursatrya', '2015-09-20 08:39:40', 'tur'),
	(131, 645397760607318019, 181498811, 'catursatrya', '2015-09-20 08:43:39', 'asa'),
	(132, 645397763149004803, 181498811, 'catursatrya', '2015-09-20 08:43:39', 'asas'),
	(133, 645397765841793027, 181498811, 'catursatrya', '2015-09-20 08:43:39', 'asa'),
	(134, 645397768274513923, 181498811, 'catursatrya', '2015-09-20 08:43:39', 'ff'),
	(135, 645397772321951747, 181498811, 'catursatrya', '2015-09-20 08:43:39', 'asa'),
	(136, 645397781553680387, 181498811, 'catursatrya', '2015-09-20 08:43:39', 'tt'),
	(137, 645397785697644547, 181498811, 'catursatrya', '2015-09-20 08:43:39', 'wewew'),
	(138, 645397790823067651, 181498811, 'catursatrya', '2015-09-20 08:43:39', 'yui'),
	(139, 645397796405678083, 181498811, 'catursatrya', '2015-09-20 08:43:39', 'sfsda'),
	(140, 645399911064666116, 181498811, 'catursatrya', '2015-09-20 08:52:00', 'hai bro');
/*!40000 ALTER TABLE `tb_inbox` ENABLE KEYS */;


-- Dumping structure for table db_twitter.tb_opt
CREATE TABLE IF NOT EXISTS `tb_opt` (
  `count_msg` int(10) unsigned DEFAULT '0',
  `consumer_key` varchar(255) DEFAULT NULL,
  `consumer_secret` varchar(255) DEFAULT NULL,
  `oauth_token` varchar(255) DEFAULT NULL,
  `oauth_token_secret` varchar(255) DEFAULT NULL,
  `reload_interval` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_twitter.tb_opt: ~1 rows (approximately)
DELETE FROM `tb_opt`;
/*!40000 ALTER TABLE `tb_opt` DISABLE KEYS */;
INSERT INTO `tb_opt` (`count_msg`, `consumer_key`, `consumer_secret`, `oauth_token`, `oauth_token_secret`, `reload_interval`) VALUES
	(500, 'qwUsv1FtypL2wyu60ZMADSMqa', 'MHnN1YXqNJYFd0HYesGMfVOOwsMtcuZg8m66g5hGUH11bV6JwD', '45765344-R1jUVwfQCJnOn3fGLPLiE3LqvwEKkkC5mJXv5wZlO', 'KGOS3xaWQTrFAy9cNp0WcHes7lW6SZV9M0SaK1fYOuC5r', 30000);
/*!40000 ALTER TABLE `tb_opt` ENABLE KEYS */;


-- Dumping structure for table db_twitter.tb_outbox
CREATE TABLE IF NOT EXISTS `tb_outbox` (
  `id_outbox` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `outbox_date` datetime NOT NULL,
  `outbox` varchar(255) DEFAULT NULL,
  `id_inbox` bigint(20) unsigned DEFAULT NULL,
  `is_sent` tinyint(3) unsigned DEFAULT '1',
  PRIMARY KEY (`id_outbox`),
  KEY `FK_tb_outbox_tb_inbox` (`id_inbox`),
  CONSTRAINT `FK_tb_outbox_tb_inbox` FOREIGN KEY (`id_inbox`) REFERENCES `tb_inbox` (`id_inbox`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=latin1;

-- Dumping data for table db_twitter.tb_outbox: ~45 rows (approximately)
DELETE FROM `tb_outbox`;
/*!40000 ALTER TABLE `tb_outbox` DISABLE KEYS */;
INSERT INTO `tb_outbox` (`id_outbox`, `outbox_date`, `outbox`, `id_inbox`, `is_sent`) VALUES
	(1, '2015-09-06 11:07:49', '#11441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 1, 2),
	(2, '2015-09-06 11:07:49', '#21441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 2, 2),
	(3, '2015-09-06 11:07:49', '#31441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 3, 2),
	(4, '2015-09-06 11:07:49', '#41441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 4, 2),
	(5, '2015-09-06 11:07:49', '#51441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 5, 2),
	(6, '2015-09-06 11:07:49', '#61441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 6, 2),
	(7, '2015-09-06 11:07:49', '#71441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 7, 2),
	(8, '2015-09-06 11:07:49', '#81441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 8, 2),
	(9, '2015-09-06 11:07:49', '#91441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 9, 2),
	(10, '2015-09-06 11:07:49', '#101441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 10, 2),
	(11, '2015-09-06 11:07:49', '#111441508869 Mohon dimaafkan udah byk buat SPAM ya (y)', 11, 2),
	(66, '2015-09-06 11:37:19', '#661441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 66, 2),
	(67, '2015-09-06 11:37:19', '#671441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 67, 2),
	(68, '2015-09-06 11:37:19', '#681441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 68, 2),
	(69, '2015-09-06 11:37:19', '#691441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 69, 2),
	(70, '2015-09-06 11:37:19', '#701441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 70, 2),
	(71, '2015-09-06 11:37:19', '#711441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 71, 2),
	(72, '2015-09-06 11:37:19', '#721441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 72, 2),
	(73, '2015-09-06 11:37:19', '#731441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 73, 2),
	(74, '2015-09-06 11:37:19', '#741441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 74, 2),
	(75, '2015-09-06 11:37:19', '#751441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 75, 2),
	(76, '2015-09-06 11:37:19', '#761441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 76, 2),
	(77, '2015-09-06 11:37:19', '#771441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 77, 2),
	(78, '2015-09-06 11:37:19', '#781441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 78, 2),
	(79, '2015-09-06 11:37:19', '#791441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 79, 2),
	(80, '2015-09-06 11:37:19', '#801441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 80, 2),
	(81, '2015-09-06 11:37:19', '#811441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 81, 2),
	(82, '2015-09-06 11:37:19', '#821441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 82, 2),
	(83, '2015-09-06 11:37:19', '#831441510639 Mohon dimaafkan udah byk buat SPAM ya (y)', 83, 2),
	(112, '2015-09-19 09:52:46', '#1121442627566 Mohon dimaafkan udah byk buat SPAM ya (y)', 112, 2),
	(113, '2015-09-19 09:52:46', '#1131442627566 Mohon dimaafkan udah byk buat SPAM ya (y)', 113, 2),
	(114, '2015-09-19 09:52:46', '#1141442627566 Mohon dimaafkan udah byk buat SPAM ya (y)', 114, 2),
	(115, '2015-09-19 09:52:46', '#1151442627566 Mohon dimaafkan udah byk buat SPAM ya (y)', 115, 2),
	(116, '2015-09-19 10:02:46', '#1161442628166 Mohon dimaafkan udah byk buat SPAM ya (y)', 116, 2),
	(117, '2015-09-19 10:06:24', '#1171442628384 Mohon dimaafkan udah byk buat SPAM ya (y)', 117, 2),
	(118, '2015-09-19 10:06:24', '#1181442628384 Mohon dimaafkan udah byk buat SPAM ya (y)', 118, 2),
	(119, '2015-09-19 13:09:23', '#1191442639363 catursatrya', 119, 2),
	(120, '2015-09-19 13:10:45', '#1201442639445 Hai catursatrya', 120, 2),
	(121, '2015-09-19 13:12:58', '#1211442639578 Hai DfFahlevi', 121, 2),
	(122, '2015-09-19 13:14:28', '#1221442639668 Hai DfFahlevi', 122, 2),
	(123, '2015-09-19 13:15:26', '#1231442639726 Hai DfFahlevi', 123, 2),
	(124, '2015-09-19 13:15:56', '#1241442639756 Hai DfFahlevi', 124, 2),
	(125, '2015-09-19 13:16:26', '#1251442639786 Hai DfFahlevi', 125, 2),
	(126, '2015-09-19 13:16:56', '#1261442639816 Hai catursatrya', 126, 2),
	(127, '2015-09-19 13:16:56', '#1271442639816 Hai catursatrya', 127, 2),
	(128, '2015-09-20 08:24:14', '#1281442708654 Hai catursatrya', 128, 2),
	(129, '2015-09-20 08:37:40', '#1291442709460 Hai catursatrya', 129, 2),
	(130, '2015-09-20 08:39:40', '#130 Hai catursatrya', 130, 2),
	(131, '2015-09-20 08:43:39', '#131 Hai catursatrya', 131, 2),
	(132, '2015-09-20 08:43:39', '#132 Hai catursatrya', 132, 2),
	(133, '2015-09-20 08:43:39', '#133 Hai catursatrya', 133, 2),
	(134, '2015-09-20 08:43:39', '#134 Hai catursatrya', 134, 2),
	(135, '2015-09-20 08:43:39', '#135 Hai catursatrya', 135, 2),
	(136, '2015-09-20 08:43:39', '#136 Hai catursatrya', 136, 2),
	(137, '2015-09-20 08:43:39', '#137 Hai catursatrya', 137, 2),
	(138, '2015-09-20 08:43:39', '#138 Hai catursatrya', 138, 2),
	(139, '2015-09-20 08:43:39', '#139 Hai catursatrya', 139, 2),
	(140, '2015-09-20 08:52:00', '#140 Hai catursatrya', 140, 2);
/*!40000 ALTER TABLE `tb_outbox` ENABLE KEYS */;


-- Dumping structure for trigger db_twitter.trig_inbox
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trig_inbox` AFTER INSERT ON `tb_inbox` FOR EACH ROW BEGIN
	-- UNIX_TIMESTAMP(NOW()),
	INSERT INTO tb_outbox (outbox_date, outbox, id_inbox) VALUES (NOW(), CONCAT('#',NEW.id_inbox, ' Hai ', NEW.inbox_user_screen), NEW.id_inbox);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
