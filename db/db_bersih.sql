/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.13-MariaDB : Database - db_bersih
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `debug` */

CREATE TABLE `debug` (
  `debug` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `debug` */

/*Table structure for table `tb_config_host` */

CREATE TABLE `tb_config_host` (
  `id_app` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `app_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_app`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tb_config_host` */

insert  into `tb_config_host`(`id_app`,`app_name`) values (1,'Simak');
insert  into `tb_config_host`(`id_app`,`app_name`) values (2,'Kepegawaian');
insert  into `tb_config_host`(`id_app`,`app_name`) values (3,'Respon');

/*Table structure for table `tb_config_host_det` */

CREATE TABLE `tb_config_host_det` (
  `id_app_det` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_app` smallint(5) unsigned DEFAULT NULL,
  `id_operasi` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_app_det`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `tb_config_host_det` */

insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (1,1,2);
insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (2,2,2);
insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (3,1,3);
insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (4,1,4);
insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (5,2,3);
insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (6,1,23);
insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (7,3,23);
insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (8,3,3);
insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (9,3,21);
insert  into `tb_config_host_det`(`id_app_det`,`id_app`,`id_operasi`) values (10,3,18);

/*Table structure for table `tb_event` */

CREATE TABLE `tb_event` (
  `id_event` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `event_name` varchar(50) NOT NULL,
  `event_desc` varchar(100) DEFAULT NULL,
  `event_message` text,
  `event_status` tinyint(4) DEFAULT NULL COMMENT '1=active;2=no',
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_event` */

/*Table structure for table `tb_event_kontak` */

CREATE TABLE `tb_event_kontak` (
  `id_event_kontak` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` smallint(5) unsigned DEFAULT NULL,
  `id_kontak` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_event_kontak`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_event_kontak` */

/*Table structure for table `tb_event_meta` */

CREATE TABLE `tb_event_meta` (
  `id_event_meta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` smallint(5) unsigned NOT NULL,
  `repeat_start` varchar(100) NOT NULL,
  `repeat_interval` varchar(100) NOT NULL,
  `repeat_year` varchar(100) NOT NULL,
  `repeat_month` varchar(100) NOT NULL,
  `repeat_day` varchar(100) NOT NULL,
  `repeat_week` varchar(100) NOT NULL,
  `repeat_weekday` varchar(100) NOT NULL,
  `repeat_hour` varchar(100) DEFAULT NULL,
  `repeat_minute` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_event_meta`),
  UNIQUE KEY `ID` (`id_event_meta`),
  KEY `id_event` (`id_event`),
  CONSTRAINT `tb_event_meta_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `tb_event` (`id_event`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_event_meta` */

/*Table structure for table `tb_grup_kontak` */

CREATE TABLE `tb_grup_kontak` (
  `id_grup_kontak` int(11) NOT NULL AUTO_INCREMENT,
  `grup_kontak` varchar(255) NOT NULL,
  PRIMARY KEY (`id_grup_kontak`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_grup_kontak` */

/*Table structure for table `tb_grup_kontak_member` */

CREATE TABLE `tb_grup_kontak_member` (
  `id_grup_kontak_member` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_grup_kontak` int(11) DEFAULT NULL,
  `id_kontak` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_grup_kontak_member`),
  KEY `FK_tb_grup_kontak_member` (`id_kontak`),
  KEY `FK_tb_grup_kontak_member2` (`id_grup_kontak`),
  CONSTRAINT `FK_tb_grup_kontak_member` FOREIGN KEY (`id_kontak`) REFERENCES `tb_kontak` (`id_kontak`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_tb_grup_kontak_member2` FOREIGN KEY (`id_grup_kontak`) REFERENCES `tb_grup_kontak` (`id_grup_kontak`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_grup_kontak_member` */

/*Table structure for table `tb_host` */

CREATE TABLE `tb_host` (
  `id_host` bigint(20) NOT NULL AUTO_INCREMENT,
  `host` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `db` varchar(50) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `user_screen` varchar(100) DEFAULT NULL,
  `nama_host` varchar(255) DEFAULT NULL,
  `is_local` tinyint(1) NOT NULL,
  `karakter_pemisah` char(1) DEFAULT NULL,
  PRIMARY KEY (`id_host`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_host` */

/*Table structure for table `tb_jenis_operasi` */

CREATE TABLE `tb_jenis_operasi` (
  `id_jenis_operasi` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_operasi` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jenis_operasi`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tb_jenis_operasi` */

insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (0,'Procedural');
insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (1,'Insert');
insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (2,'Update');
insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (3,'Delete');
insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (4,'Select');
insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (5,'Broadcast');

/*Table structure for table `tb_jenis_sql` */

CREATE TABLE `tb_jenis_sql` (
  `id_jenis_sql` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_sql` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jenis_sql`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tb_jenis_sql` */

insert  into `tb_jenis_sql`(`id_jenis_sql`,`jenis_sql`) values (1,'Query');
insert  into `tb_jenis_sql`(`id_jenis_sql`,`jenis_sql`) values (2,'Function');
insert  into `tb_jenis_sql`(`id_jenis_sql`,`jenis_sql`) values (3,'Procedure');

/*Table structure for table `tb_kontak` */

CREATE TABLE `tb_kontak` (
  `id_kontak` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_kontak` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `user_screen` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_kontak`)
) ENGINE=InnoDB AUTO_INCREMENT=549 DEFAULT CHARSET=latin1;

/*Data for the table `tb_kontak` */

insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (1,'a','+628989200981','a',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (2,'b','+628989200981','b',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (3,'c','+628989200981','c',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (4,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (5,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (6,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (7,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (8,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (9,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (10,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (11,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (12,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (13,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (14,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (15,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (16,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (17,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (18,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (19,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (20,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (21,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (22,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (23,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (24,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (25,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (26,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (27,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (28,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (29,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (30,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (31,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (32,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (33,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (34,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (35,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (36,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (37,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (38,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (39,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (40,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (41,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (42,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (43,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (44,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (45,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (46,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (47,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (48,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (49,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (50,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (51,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (52,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (53,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (54,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (55,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (56,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (57,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (58,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (59,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (60,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (61,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (62,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (63,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (64,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (65,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (66,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (67,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (68,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (69,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (70,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (71,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (72,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (73,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (74,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (75,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (76,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (77,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (78,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (79,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (80,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (81,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (82,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (83,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (84,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (85,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (86,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (87,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (88,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (89,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (90,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (91,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (92,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (93,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (94,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (95,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (96,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (97,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (98,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (99,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (100,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (101,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (102,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (103,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (104,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (105,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (106,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (107,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (108,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (109,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (110,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (111,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (112,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (113,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (114,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (115,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (116,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (117,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (118,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (119,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (120,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (121,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (122,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (123,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (124,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (125,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (126,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (127,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (128,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (129,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (130,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (131,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (132,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (133,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (134,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (135,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (136,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (137,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (138,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (139,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (140,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (141,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (142,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (143,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (144,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (145,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (146,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (147,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (148,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (149,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (150,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (151,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (152,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (153,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (154,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (155,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (156,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (157,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (158,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (159,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (160,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (161,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (162,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (163,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (164,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (165,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (166,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (167,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (168,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (169,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (170,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (171,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (172,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (173,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (174,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (175,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (176,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (177,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (178,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (179,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (180,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (181,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (182,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (183,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (184,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (185,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (186,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (187,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (188,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (189,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (190,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (191,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (192,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (193,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (194,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (195,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (196,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (197,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (198,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (199,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (200,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (201,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (202,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (203,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (204,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (205,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (206,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (207,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (208,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (209,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (210,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (211,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (212,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (213,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (214,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (215,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (216,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (217,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (218,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (219,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (220,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (221,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (222,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (223,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (224,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (225,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (226,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (227,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (228,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (229,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (230,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (231,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (232,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (233,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (234,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (235,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (236,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (237,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (238,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (239,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (240,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (241,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (242,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (243,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (244,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (245,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (246,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (247,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (248,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (249,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (250,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (251,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (252,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (253,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (254,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (255,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (256,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (257,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (258,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (259,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (260,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (261,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (262,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (263,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (264,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (265,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (266,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (267,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (268,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (269,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (270,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (271,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (272,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (273,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (274,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (275,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (276,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (277,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (278,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (279,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (280,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (281,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (282,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (283,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (284,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (285,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (286,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (287,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (288,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (289,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (290,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (291,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (292,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (293,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (294,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (295,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (296,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (297,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (298,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (299,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (300,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (301,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (302,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (303,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (304,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (305,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (306,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (307,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (308,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (309,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (310,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (311,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (312,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (313,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (314,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (315,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (316,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (317,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (318,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (319,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (320,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (321,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (322,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (323,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (324,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (325,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (326,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (327,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (328,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (329,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (330,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (331,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (332,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (333,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (334,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (335,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (336,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (337,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (338,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (339,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (340,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (341,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (342,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (343,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (344,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (345,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (346,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (347,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (348,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (349,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (350,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (351,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (352,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (353,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (354,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (355,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (356,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (357,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (358,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (359,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (360,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (361,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (362,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (363,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (364,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (365,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (366,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (367,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (368,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (369,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (370,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (371,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (372,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (373,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (374,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (375,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (376,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (377,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (378,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (379,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (380,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (381,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (382,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (383,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (384,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (385,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (386,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (387,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (388,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (389,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (390,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (391,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (392,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (393,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (394,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (395,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (396,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (397,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (398,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (399,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (400,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (401,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (402,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (403,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (404,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (405,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (406,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (407,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (408,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (409,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (410,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (411,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (412,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (413,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (414,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (415,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (416,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (417,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (418,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (419,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (420,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (421,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (422,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (423,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (424,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (425,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (426,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (427,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (428,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (429,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (430,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (431,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (432,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (433,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (434,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (435,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (436,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (437,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (438,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (439,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (440,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (441,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (442,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (443,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (444,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (445,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (446,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (447,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (448,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (449,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (450,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (451,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (452,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (453,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (454,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (455,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (456,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (457,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (458,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (459,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (460,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (461,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (462,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (463,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (464,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (465,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (466,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (467,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (468,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (469,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (470,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (471,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (472,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (473,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (474,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (475,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (476,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (477,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (478,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (479,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (480,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (481,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (482,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (483,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (484,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (485,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (486,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (487,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (488,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (489,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (490,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (491,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (492,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (493,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (494,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (495,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (496,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (497,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (498,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (499,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (500,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (501,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (502,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (503,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (504,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (505,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (506,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (507,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (508,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (509,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (510,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (511,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (512,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (513,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (514,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (515,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (516,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (517,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (518,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (519,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (520,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (521,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (522,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (523,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (524,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (525,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (526,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (527,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (528,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (529,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (530,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (531,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (532,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (533,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (534,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (535,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (536,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (537,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (538,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (539,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (540,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (541,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (542,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (543,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (544,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (545,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (546,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (547,'d','+628989200981','d',NULL);
insert  into `tb_kontak`(`id_kontak`,`nama_kontak`,`no_hp`,`email`,`user_screen`) values (548,'d','+628989200981','d',NULL);

/*Table structure for table `tb_log_respon` */

CREATE TABLE `tb_log_respon` (
  `id_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_log_respon` */

/*Table structure for table `tb_m_user` */

CREATE TABLE `tb_m_user` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user_role` tinyint(3) unsigned NOT NULL COMMENT 'tb_m_user_role',
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `identifier_login` varchar(100) DEFAULT NULL,
  `value_identifier` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_user_role` (`id_user_role`),
  CONSTRAINT `tb_m_user_ibfk_1` FOREIGN KEY (`id_user_role`) REFERENCES `tb_m_user_role` (`id_user_role`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tb_m_user` */

insert  into `tb_m_user`(`id_user`,`id_user_role`,`username`,`password`,`identifier_login`,`value_identifier`) values (1,1,'admin','21232f297a57a5a743894a0e4a801fc3',NULL,NULL);
insert  into `tb_m_user`(`id_user`,`id_user_role`,`username`,`password`,`identifier_login`,`value_identifier`) values (4,2,'contohfix','4553eb3ff328b4868a7a1e6e53cd28b4','NIM','09045009');
insert  into `tb_m_user`(`id_user`,`id_user_role`,`username`,`password`,`identifier_login`,`value_identifier`) values (5,2,'contoh','4553eb3ff328b4868a7a1e6e53cd28b4','NIM','0904505009');

/*Table structure for table `tb_m_user_role` */

CREATE TABLE `tb_m_user_role` (
  `id_user_role` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_user_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tb_m_user_role` */

insert  into `tb_m_user_role`(`id_user_role`,`user_role`) values (1,'Admin');
insert  into `tb_m_user_role`(`id_user_role`,`user_role`) values (2,'User');

/*Table structure for table `tb_operasi` */

CREATE TABLE `tb_operasi` (
  `id_operasi` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_host` bigint(20) NOT NULL,
  `id_jenis_operasi` int(11) NOT NULL,
  `id_jenis_sql` int(11) NOT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `is_publik` tinyint(1) NOT NULL COMMENT '1: publik; 0: privat',
  `nama_operasi` varchar(255) NOT NULL,
  `penanda_login` tinyint(3) unsigned DEFAULT '2',
  `use_sender` tinyint(3) NOT NULL DEFAULT '2' COMMENT '1 = yes; 2 = no',
  `sender_col` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_operasi`),
  KEY `FK_tb_operasi_to_tb_host` (`id_host`),
  CONSTRAINT `FK_tb_operasi_to_tb_host` FOREIGN KEY (`id_host`) REFERENCES `tb_host` (`id_host`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi` */

/*Table structure for table `tb_operasi_cast` */

CREATE TABLE `tb_operasi_cast` (
  `id_operasi` bigint(20) NOT NULL,
  `id_host` bigint(20) NOT NULL,
  PRIMARY KEY (`id_operasi`,`id_host`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_cast` */

/*Table structure for table `tb_operasi_in` */

CREATE TABLE `tb_operasi_in` (
  `id_op_in` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_operasi` bigint(20) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `user_screen` varchar(100) DEFAULT NULL,
  `message_in` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: sms; 1: ym',
  `id_eksekusi_ym` char(17) DEFAULT NULL,
  PRIMARY KEY (`id_op_in`),
  KEY `FK_tb_operasi_out` (`id_operasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_in` */

/*Table structure for table `tb_operasi_in_data` */

CREATE TABLE `tb_operasi_in_data` (
  `id_op_in_data` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_op_in` bigint(20) NOT NULL,
  `sent_data` longtext NOT NULL,
  `format` tinyint(4) NOT NULL COMMENT '0: regular; 1: table',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: sms; 1: ym',
  `id_eksekusi_ym` char(17) DEFAULT NULL,
  PRIMARY KEY (`id_op_in_data`),
  KEY `FK_tb_operasi_out_data` (`id_op_in`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_in_data` */

/*Table structure for table `tb_operasi_join` */

CREATE TABLE `tb_operasi_join` (
  `id_operasi_join` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_operasi` bigint(20) NOT NULL,
  `field_join` varchar(100) NOT NULL,
  PRIMARY KEY (`id_operasi_join`),
  KEY `FK_tb_operasi_join_to_tb_operasi` (`id_operasi`),
  CONSTRAINT `FK_tb_operasi_join_to_tb_operasi` FOREIGN KEY (`id_operasi`) REFERENCES `tb_operasi` (`id_operasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_join` */

/*Table structure for table `tb_operasi_order_by` */

CREATE TABLE `tb_operasi_order_by` (
  `id_operasi_order_by` int(11) NOT NULL AUTO_INCREMENT,
  `id_operasi` bigint(20) NOT NULL,
  `order_by` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=ascending;2=descending',
  PRIMARY KEY (`id_operasi_order_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_order_by` */

/*Table structure for table `tb_operasi_out` */

CREATE TABLE `tb_operasi_out` (
  `id_op_out` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_operasi` bigint(20) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `user_screen` varchar(100) DEFAULT NULL,
  `message_out` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: sms; 1: ym',
  `id_eksekusi_ym` char(17) DEFAULT NULL,
  PRIMARY KEY (`id_op_out`),
  KEY `FK_tb_operasi_out` (`id_operasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_out` */

/*Table structure for table `tb_operasi_out_data` */

CREATE TABLE `tb_operasi_out_data` (
  `id_op_out_data` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_op_out` bigint(20) NOT NULL,
  `reply_data` longtext NOT NULL,
  `format` tinyint(4) NOT NULL COMMENT '0: regular; 1: table',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: sms; 1: ym',
  `id_eksekusi_ym` char(17) DEFAULT NULL,
  PRIMARY KEY (`id_op_out_data`),
  KEY `FK_tb_operasi_out_data` (`id_op_out`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_out_data` */

/*Table structure for table `tb_operasi_output` */

CREATE TABLE `tb_operasi_output` (
  `id_operasi_output` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_operasi` bigint(20) NOT NULL,
  `output` varchar(100) NOT NULL,
  `nama_output` varchar(255) NOT NULL,
  `jenis_output` tinyint(3) unsigned DEFAULT '1' COMMENT '1=string,2=number,3=currency',
  PRIMARY KEY (`id_operasi_output`),
  KEY `FK_tb_operasi_output_to_tb_operasi` (`id_operasi`),
  CONSTRAINT `FK_tb_operasi_output_to_tb_operasi` FOREIGN KEY (`id_operasi`) REFERENCES `tb_operasi` (`id_operasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_output` */

/*Table structure for table `tb_operasi_parameter` */

CREATE TABLE `tb_operasi_parameter` (
  `id_operasi_parameter` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_operasi` bigint(20) NOT NULL,
  `parameter` varchar(100) NOT NULL,
  `nama_parameter` varchar(255) NOT NULL,
  `is_kunci` tinyint(1) NOT NULL COMMENT '1: kunci; 0: value',
  `type` enum('','=','>','>=','<','<=','LIKE') DEFAULT NULL,
  `use_sender` tinyint(3) NOT NULL DEFAULT '2' COMMENT '1 = yes; 2 = no',
  PRIMARY KEY (`id_operasi_parameter`),
  KEY `FK_tb_operasi_parameter_to_tb_operasi` (`id_operasi`),
  CONSTRAINT `FK_tb_operasi_parameter_to_tb_operasi` FOREIGN KEY (`id_operasi`) REFERENCES `tb_operasi` (`id_operasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_parameter` */

/*Table structure for table `tb_operasi_prosedural` */

CREATE TABLE `tb_operasi_prosedural` (
  `id_operasi_prosedural` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_operasi` bigint(20) NOT NULL,
  `nama_prosedural` varchar(255) NOT NULL,
  `nama_hasil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_operasi_prosedural`),
  KEY `FK_tb_operasi_prosedural_to_tb_operasi` (`id_operasi`),
  CONSTRAINT `FK_tb_operasi_prosedural_to_tb_operasi` FOREIGN KEY (`id_operasi`) REFERENCES `tb_operasi` (`id_operasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_prosedural` */

/*Table structure for table `tb_operasi_tabel` */

CREATE TABLE `tb_operasi_tabel` (
  `id_operasi_tabel` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_operasi` bigint(20) NOT NULL,
  `nama_tabel` varchar(100) NOT NULL,
  PRIMARY KEY (`id_operasi_tabel`),
  KEY `FK_tb_operasi_tabel_to_tb_operasi` (`id_operasi`),
  CONSTRAINT `FK_tb_operasi_tabel_to_tb_operasi` FOREIGN KEY (`id_operasi`) REFERENCES `tb_operasi` (`id_operasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_operasi_tabel` */

/*Table structure for table `tb_option` */

CREATE TABLE `tb_option` (
  `ID` tinyint(1) DEFAULT NULL,
  `char_pemisah` char(1) NOT NULL,
  `balas_spam` tinyint(1) NOT NULL,
  `nama_app_sms` varchar(255) DEFAULT NULL,
  `nama_app_ym` varchar(255) DEFAULT NULL,
  `sms_x_hari_kosongkan` int(3) DEFAULT NULL,
  `ym_x_hari_kosongkan` int(11) DEFAULT NULL,
  `dir_backup` text,
  `deskripsi_sms` varchar(254) DEFAULT NULL,
  `deskripsi_ym` varchar(254) DEFAULT NULL,
  `delivery_report` varchar(20) DEFAULT 'default',
  `send_after` smallint(6) DEFAULT '0',
  `keyword_broadcast` varchar(100) DEFAULT NULL,
  `normal_broadcast` varchar(100) DEFAULT NULL,
  `keyword_login` varchar(50) DEFAULT NULL,
  `keyword_host` varchar(50) DEFAULT NULL,
  `phpexe_loc` varchar(500) DEFAULT NULL,
  `respon_loc` varchar(500) DEFAULT NULL,
  `rentang_min` smallint(6) DEFAULT NULL,
  `pesan_spam` varchar(100) DEFAULT NULL,
  `pesan_gagal` varchar(100) DEFAULT NULL,
  `pesan_sukses` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tb_option` */

insert  into `tb_option`(`ID`,`char_pemisah`,`balas_spam`,`nama_app_sms`,`nama_app_ym`,`sms_x_hari_kosongkan`,`ym_x_hari_kosongkan`,`dir_backup`,`deskripsi_sms`,`deskripsi_ym`,`delivery_report`,`send_after`,`keyword_broadcast`,`normal_broadcast`,`keyword_login`,`keyword_host`,`phpexe_loc`,`respon_loc`,`rentang_min`,`pesan_spam`,`pesan_gagal`,`pesan_sukses`) values (1,'#',1,'Unud SMS Gateway','Udayana Yahoo Messenger',1,0,'D:\\','Copyright : Divinkom @2013',NULL,'yes',1,'BCOP','BC',NULL,'HOST','C:/xampp/php/php.exe','C:/xampp/htdocs/respon/',1,'Selamat datang di service respon. Kunjungi halaman kami untuk info lebih lanjut.','Maaf, saat ini perintah tidak dapat dilakukan.','Perintah berhasil dieksekusi.');

/*Table structure for table `tb_privilege` */

CREATE TABLE `tb_privilege` (
  `id_kontak` bigint(20) NOT NULL,
  `id_operasi` bigint(20) NOT NULL,
  PRIMARY KEY (`id_kontak`,`id_operasi`),
  KEY `FK_tb_privilege_to_tb_operasi` (`id_operasi`),
  CONSTRAINT `FK_tb_privilege_to_tb_kontak` FOREIGN KEY (`id_kontak`) REFERENCES `tb_kontak` (`id_kontak`) ON DELETE CASCADE,
  CONSTRAINT `FK_tb_privilege_to_tb_operasi` FOREIGN KEY (`id_operasi`) REFERENCES `tb_operasi` (`id_operasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_privilege` */

/*Table structure for table `tb_service` */

CREATE TABLE `tb_service` (
  `id_service` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `service` varchar(50) NOT NULL DEFAULT '0',
  `pemisah_kolom` text,
  `pemisah_baris` text,
  `inbox_table_serv` varchar(255) NOT NULL,
  `inbox_table` varchar(255) NOT NULL DEFAULT '0',
  `inbox_content` varchar(500) NOT NULL DEFAULT '0',
  `inbox_sender` varchar(255) NOT NULL DEFAULT '0',
  `inbox_date` varchar(255) NOT NULL DEFAULT '0',
  `inbox_flag` varchar(255) NOT NULL DEFAULT '0',
  `inbox_server` varchar(255) NOT NULL DEFAULT '0',
  `outbox_table` varchar(255) NOT NULL DEFAULT '0',
  `outbox_content` varchar(500) NOT NULL DEFAULT '0',
  `outbox_recipient` varchar(255) NOT NULL DEFAULT '0',
  `outbox_date` varchar(255) NOT NULL DEFAULT '0',
  `outbox_flag` varchar(255) NOT NULL DEFAULT '0',
  `outbox_server` varchar(255) NOT NULL DEFAULT '0',
  `max_char` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_service` */

/*Table structure for table `tb_user` */

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id_user`,`username`,`password`,`nama_user`) values (1,'admin','21232f297a57a5a743894a0e4a801fc3','Admin');

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `tes` */

DELIMITER $$

/*!50106 CREATE DEFINER=`root`@`localhost` EVENT `tes` ON SCHEDULE EVERY 1 DAY STARTS '2014-09-29 11:04:43' ON COMPLETION PRESERVE ENABLE DO BEGIN
	    INSERT INTO  debug(debug) values (now());
	END */$$
DELIMITER ;

/* Function  structure for function  `login` */

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `login`(usr varchar(100),pass VARCHAR(100)) RETURNS text CHARSET latin1
BEGIN
	SELECT count(id_user) into @i FROM tb_m_user where tb_m_user.username=usr AND tb_m_user.password=MD5(pass);
	if(@i>0) then
	   RETURN 'true';
	else
	   return 'false';
	end if;
    END */$$
DELIMITER ;

/* Function  structure for function  `view_last_respon` */

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `view_last_respon`() RETURNS text CHARSET latin1
BEGIN
	SET @log = '';
	SELECT concat(`log`,' | ',`datetime`) into @log FROM tb_log_respon ORDER BY id_log DESC LIMIT 1;
	return @log;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `execute_q` */

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `execute_q`(head_query text,query_output text,query_tabel text,query_join text,query_parameter text,outputnya text)
BEGIN
	SET @s = concat(head_query," ",outputnya," into output_smsnya2 FROM ",query_tabel," WHERE ",query_join," AND ",query_parameter); 
	PREPARE stmt1 FROM @s; 
	EXECUTE stmt1; 
	DEALLOCATE PREPARE stmt1;  
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
