<?php
		//line berikut ditambahkan pak piarsa
		date_default_timezone_set('Asia/Makassar');

		//variabel untuk login default
		$server_dev = "localhost";
		$username_dev = "root";
		$password_dev = "";
		$name_dev =  "db_tes";
		//
		$server_host = "";
		$username_host = "";
		$password_host = "";
		$db_host = "";

		function connectMyDB($server, $username, $password, $name){
			//melakukan koneksi ke server
			$id_mysql = mysqli_connect($server, $username, $password);
			if (! $id_mysql) {
				echo "Tidak dapat melakukan koneksi ke server MySQL !";
			}

			//mengakses database pada server
			$db_kerjasama = mysqli_select_db($id_mysql,$name);
			if (! $db_kerjasama) {
				echo "Database tidak ada !";
			}
		}

		connectMyDB($server_dev, $username_dev, $password_dev, $name_dev);


		/*$link = mysqli_connect('localhost', 'root', '', 'db_payroll');

		 check connection 
		if (!$link) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}*/
?>