/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.13-MariaDB : Database - db_tes
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `tb_bc_sch` */

CREATE TABLE `tb_bc_sch` (
  `id_bc_sch` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `id_contact_group` int(10) unsigned DEFAULT NULL,
  `server` varchar(100) DEFAULT NULL,
  `message` text,
  `time_var` varchar(100) DEFAULT NULL,
  `tipe_time` smallint(100) DEFAULT NULL COMMENT '1=detik;2=menit;3=jam;4=hari;5=minggu;6=bulan',
  `is_now` tinyint(4) DEFAULT '1' COMMENT '1=now;2=datetime',
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  PRIMARY KEY (`id_bc_sch`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `tb_bc_sch` */

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tb_jenis_operasi` */

insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (0,'Procedural');
insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (1,'Insert');
insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (2,'Update');
insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (3,'Delete');
insert  into `tb_jenis_operasi`(`id_jenis_operasi`,`jenis_operasi`) values (4,'Select');

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

/*Table structure for table `tb_log_respon` */

CREATE TABLE `tb_log_respon` (
  `id_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `tb_log_respon` */

insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (1,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-03-07 00:31:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (2,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail : a=0','2017-03-07 00:32:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (3,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail : a=0','2017-03-07 00:33:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (4,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail : a=0','2017-03-07 00:34:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (5,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-03-07 00:35:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (6,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-03-07 00:36:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (7,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-03-07 00:37:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (8,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-03-07 00:38:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (9,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-03-07 00:39:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (10,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-03-07 00:40:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (11,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-03-07 00:41:01');
insert  into `tb_log_respon`(`id_log`,`log`,`datetime`) values (12,'Respon berhasil dieksekusi , 0 pesan berhasil diproses. Detail :','2017-03-07 00:42:01');

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
  `char_pemisah` char(1) NOT NULL,
  `balas_spam` tinyint(1) NOT NULL,
  `phpexe_loc` varchar(500) DEFAULT NULL,
  `respon_loc` varchar(500) DEFAULT NULL,
  `pesan_spam` varchar(100) DEFAULT NULL,
  `pesan_gagal` varchar(100) DEFAULT NULL,
  `pesan_sukses` varchar(100) DEFAULT NULL,
  `rentang_min` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tb_option` */

insert  into `tb_option`(`char_pemisah`,`balas_spam`,`phpexe_loc`,`respon_loc`,`pesan_spam`,`pesan_gagal`,`pesan_sukses`,`rentang_min`) values ('#',1,'C:/xampp/php/php.exe','C:/xampp/htdocs/respon/','Selamat datang di service respon. Kunjungi halaman kami untuk info lebih lanjut.','Maaf, saat ini perintah tidak dapat dilakukan.','Perintah berhasil dieksekusi.',5);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tb_service` */

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

/* Procedure structure for procedure `broadcast` */

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `broadcast`(id_bc int unsigned)
BEGIN
	SELECT bc.id_contact_group,bc.`server`,bc.message,srv.outbox_table,srv.outbox_recipient,srv.`outbox_date`,srv.outbox_flag,srv.outbox_server,srv.outbox_content
	INTO @id_grup,@serv,@msg,@ftbl,@frec,@fdate,@fflag,@fserver,@fmsg
	FROM tb_bc_sch bc 
	INNER JOIN `tb_contact_group` gr ON gr.id_contact_group=bc.id_contact_group
	INNER JOIN tb_service srv ON srv.id_service=gr.id_service
	WHERE id_bc_sch=id_bc;
	
	Set @sql = concat("
	INSERT INTO ", @ftbl ,"(", @fmsg ,",", @fdate ,",", @fflag ,",", @frec ,",", @fserver ,")
	SELECT '", @msg ,"',NOW() AS `datetime`,1 AS flag,cont.`contact_id` AS rec,'", @serv ,"' AS svr
	FROM `tb_contact_group_det` gd
	INNER JOIN tb_contact cont ON cont.`id_contact`=gd.`id_contact`
	WHERE gd.`id_contact_group`=", @id_grup ,"");
	
	
	prepare stmt1 from @sql;
	execute stmt1;
	deallocate prepare stmt1;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
