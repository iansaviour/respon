/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.13-MariaDB : Database - db_respon_bersih
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

/*Table structure for table `tb_contact` */

CREATE TABLE `tb_contact` (
  `id_contact` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_service` int(11) NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `contact_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id_contact`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_contact` */

/*Table structure for table `tb_contact_group` */

CREATE TABLE `tb_contact_group` (
  `id_contact_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_group` varchar(100) DEFAULT NULL,
  `id_service` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_contact_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_contact_group` */

/*Table structure for table `tb_contact_group_det` */

CREATE TABLE `tb_contact_group_det` (
  `id_contact_group_det` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_contact_group` int(10) unsigned DEFAULT NULL,
  `id_contact` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_contact_group_det`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_contact_group_det` */

/*Table structure for table `tb_eksekusi_respon` */

CREATE TABLE `tb_eksekusi_respon` (
  `id_eksekusi` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_sms` bigint(20) DEFAULT NULL,
  `id_inbox` bigint(20) DEFAULT NULL COMMENT 'tb_inbox_twitter',
  `id_operasi` bigint(20) DEFAULT NULL,
  `query_value` text,
  `output_sms` text,
  `output_field` text,
  `op_status` int(2) DEFAULT '0' COMMENT '0=bukan operasi,1=operasi',
  `key_op` varchar(255) DEFAULT NULL COMMENT 'kunci',
  `is_foward` int(2) DEFAULT '0' COMMENT '0=biasa, 1=foward',
  `is_broadcast` tinyint(3) unsigned DEFAULT '0' COMMENT '0=normal;1=broadcast keyword;3=broadcast normal',
  `broadcast_grup` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_eksekusi`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `tb_eksekusi_respon` */

/*Table structure for table `tb_event` */

CREATE TABLE `tb_event` (
  `id_event` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `event_name` varchar(50) NOT NULL,
  `event_desc` varchar(100) DEFAULT NULL,
  `event_message` text,
  `event_status` tinyint(4) DEFAULT NULL COMMENT '1=active;2=no',
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tb_event` */

insert  into `tb_event`(`id_event`,`event_name`,`event_desc`,`event_message`,`event_status`) values (3,'tes 3','tes 3','tes 3',1);

/*Table structure for table `tb_event_kontak` */

CREATE TABLE `tb_event_kontak` (
  `id_event_kontak` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` smallint(5) unsigned DEFAULT NULL,
  `id_kontak` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_event_kontak`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tb_event_kontak` */

insert  into `tb_event_kontak`(`id_event_kontak`,`id_event`,`id_kontak`) values (1,3,1);
insert  into `tb_event_kontak`(`id_event_kontak`,`id_event`,`id_kontak`) values (2,3,2);
insert  into `tb_event_kontak`(`id_event_kontak`,`id_event`,`id_kontak`) values (3,3,3);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tb_event_meta` */

insert  into `tb_event_meta`(`id_event_meta`,`id_event`,`repeat_start`,`repeat_interval`,`repeat_year`,`repeat_month`,`repeat_day`,`repeat_week`,`repeat_weekday`,`repeat_hour`,`repeat_minute`) values (6,3,'1444928400','5','*','*','*','*','*','*','*');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

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

/*Table structure for table `tb_log_respon` */

CREATE TABLE `tb_log_respon` (
  `id_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tb_log_respon` */

insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (1,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-02-24 22:15:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

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

/*Table structure for table `tb_option_twitter` */

CREATE TABLE `tb_option_twitter` (
  `count_msg` int(10) unsigned DEFAULT '0',
  `consumer_key` varchar(255) DEFAULT NULL,
  `consumer_secret` varchar(255) DEFAULT NULL,
  `oauth_token` varchar(255) DEFAULT NULL,
  `oauth_token_secret` varchar(255) DEFAULT NULL,
  `reload_interval` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_option_twitter` */

insert  into `tb_option_twitter`(`count_msg`,`consumer_key`,`consumer_secret`,`oauth_token`,`oauth_token_secret`,`reload_interval`) values (500,'40lgNNKxTIMJoUD2IrEdS8uNp','ep1HfwHyUtKoojZoYX21efngTVjcHEyWZ8XuHhjP6jaUGR44j5','3920159953-OBqsp2FiSonkmwX1XKDCfbDvMYvjGB1itrzWX63','QeGz68ZhbdPE79uK5QIxJX5jpcGDCyvy2zGk8fqQ0AAWc',60000);

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
