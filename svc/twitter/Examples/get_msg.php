<?php

/**
 * TwitterOAuth - https://github.com/ricardoper/TwitterOAuth
 * PHP library to communicate with Twitter OAuth API version 1.1
 *
 * @author Ricardo Pereira <github@ricardopereira.es>
 * @copyright 2014
 */

include("../../../includes/koneksi.php");
include("../../../includes/function.php");
require __DIR__ . '/../vendor/autoload.php';

use TwitterOAuth\Auth\SingleUserAuth;

/**
 * Serializer Namespace
 */
use TwitterOAuth\Serializer\ArraySerializer;


date_default_timezone_set('UTC');


/**
 * Array with the OAuth tokens provided by Twitter
 *   - consumer_key        Twitter API key
 *   - consumer_secret     Twitter API secret
 *   - oauth_token         Twitter Access token         * Optional For GET Calls
 *   - oauth_token_secret  Twitter Access token secret  * Optional For GET Calls
 */
$key = getCredentials();
$credentials = array(
    'consumer_key' => $key['consumer_key'],
    'consumer_secret' => $key['consumer_secret'],
    'oauth_token' => $key['oauth_token'],
    'oauth_token_secret' => $key['oauth_token_secret']
);

/**
 * Instantiate SingleUser
 *
 * For different output formats you can set one of available serializers
 * (Array, Json, Object, Text or a custom one)
 */
$auth = new SingleUserAuth($credentials, new ArraySerializer());

/**
 * MAX ID MSG
 */
$query_max = "SELECT o.count_msg, i.since_id from tb_option_twitter o JOIN (SELECT IFNULL(MAX(inbox_id),0) AS since_id FROM tb_inbox_twitter) i";
$result_max = mysql_query($query_max);
$data = mysql_fetch_array($result_max);
$since_id = $data['since_id'];
$count_msg = $data['count_msg'];

try {
	/**
	* REQUEST TO TWITTER
	*/
	$params = array(
		'count' => $count_msg,
		'since_id' => $since_id,
		'full_text'=> true
	);
	$response = $auth->get('direct_messages', $params);

	/**
	 * ARRAY QUEUE MSG
	 * save msg to array
	 */
	$i_msg = 0;
	$arr_tw = array();
	foreach ($response as $ex) {
		$arr_tw[$i_msg]['id_str'] = $ex['id_str'];
		$arr_tw[$i_msg]['sender_screen_name'] = $ex['sender_screen_name'];
		$arr_tw[$i_msg]['text'] = $ex['text'];
		$arr_tw[$i_msg]['sender_id_str'] = $ex['sender_id_str'];
		$arr_tw[$i_msg]['created_at'] = $ex['created_at'];
		//echo $arr_tw[$i_msg]['id_str']."/Text:".$arr_tw[$i_msg]['text']."/Sender:".$arr_tw[$i_msg]['sender_id_str']."/Date:".$arr_tw[$i_msg]['created_at']."<br>";
		$i_msg++;
	}

	/**
	 * INSERT to tb_inbox_twitter
	 */
	$query = "INSERT INTO tb_inbox_twitter(inbox_id, inbox_user_screen,inbox_user, inbox_date, inbox) VALUES ";
	$i=$i_msg-1;
	while($i>=0){
		if($i<$i_msg-1){
			$query.=", ";
		}
		$query .= "('".$arr_tw[$i]['id_str']."','".$arr_tw[$i]['sender_screen_name']."','".$arr_tw[$i]['sender_id_str']."', NOW(), '".$arr_tw[$i]['text']."') ";
		$i=$i-1;
	}
	$result = mysql_query($query);	
	
    /*DATA BALAS SPAM*/
    $query_balas_spam = "SELECT balas_spam FROM tb_option LIMIT 1 ";
    $result_balas_spam = mysql_query($query_balas_spam);
    $data_balas_spam = mysql_fetch_array($result_balas_spam);
    $balas_spam = $data_balas_spam['balas_spam'];

    /*DATA CHAR PEMISAH*/
    $query_char_pemisah ="SELECT char_pemisah FROM tb_option LIMIT 1 ";
    $result_char_pemisah = mysql_query($query_char_pemisah);
    $data_char_pemisah = mysql_fetch_array($result_char_pemisah);
    $char_pemisah = $data_char_pemisah['char_pemisah'];

    /*RESPON SPAM*/
    $data = dataRespon("1", "1");
    for ($i=0; $i<count($data); $i++) { 
        $id_eksekusi = $data[$i]["id_eksekusi"];
        if ($balas_spam==1) {
            $pengirim = $data[$i]["pengirim"];
            $output_sms = $data[$i]["output_sms"];
            fungsi_send_twitter($output_sms, $pengirim);
        }

        $query_parsing = "DELETE FROM tb_eksekusi_respon WHERE id_eksekusi='$id_eksekusi' ";
        $result_parsing = mysql_query($query_parsing);
    }

    /*RESPON GAGAL*/
    $data = dataRespon("1", "2");
    for ($i=0; $i<count($data); $i++) { 
        $id_eksekusi = $data[$i]["id_eksekusi"];
        $pengirim = $data[$i]["pengirim"];
        $output_sms = $data[$i]["output_sms"];
        fungsi_send_twitter($output_sms, $pengirim);

        $query_parsing = "DELETE FROM tb_eksekusi_respon WHERE id_eksekusi='$id_eksekusi' ";
        $result_parsing = mysql_query($query_parsing);
    }

    /*RESPON REPLY DATA*/
    $data = dataRespon("1", "3");
    for ($i=0; $i<count($data); $i++) { 
        $id_eksekusi = $data[$i]["id_eksekusi"];
        $pengirim = $data[$i]["pengirim"];

        $jenis_operasi = $data[$i]["jenis_operasi"];
        $query_parsing = $data[$i]["query_parsing"];
        $host = $data[$i]["host"];
        $username = $data[$i]["username"];
        $password = $data[$i]["password"];
        $output_sms = $data[$i]["output_sms"];
        $output_field = $data[$i]["output_field"];
        $key_op = $data[$i]["key_op"];
        $dbx = $data[$i]["dbx"];
        $id_operasix = $data[$i]["id_operasix"];
        $textx = $data[$i]["sms_in"];

        //'operasi cast / sebar ke yang lain
        cast_operasi($pengirim, $id_operasix, $textx, "2");

        //'search in database used
        mysql_close();
        connectMyDB($host, $username, $password, $dbx);
        try {
            if ($query_parsing="error") {
                $sms_out = $key_op.$char_pemisah.$output_sms;
                $log_in = $output_sms;
            } else {
                if ($jenis_operasi=="4") {
                    $words = explode(",", $output_sms);
                    $result_parsing = mysql_query($query_parsing);
                    $n_parsing = mysql_num_rows($result_parsing);
                    if ($n_parsing==0) {
                        $sms_out = $key_op.$char_pemisah."Error : Data tidak ditemukan.";
                        $log_in="Error : Data tidak ditemukan.";
                    } else {
                        $sms_out=$key_op."".$char_pemisah;
                        $log_in ="";
                        $j=0;
                        while ($data_parsing=mysql_fetch_array($result_parsing, MYSQL_NUM)) {
                            $m=0;
                            foreach ($words as $word) {
                                if ($m==0) {
                                    $sms_out = $sms_out.$word."{:c:}".$data_parsing[$m];
                                    $log_in = $log_in.$word."{:c:}".$data_parsing[$m];
                                } else {
                                    $sms_out = $sms_out.$char_pemisah.$word."{:c:}".$data_parsing[$m];
                                    $log_in = $log_in.$char_pemisah.$word."{:c:}".$data_parsing[$m];
                                }
                                $m++;
                            }

                            if ($j==($n_parsing-1)) {
                                $sms_out = $sms_out;
                                $log_in = $log_in;
                            } else {
                                $sms_out = $sms_out."{:r:}";
                                $log_in = $log_in."{:r:}";
                            }
                            $j++;
                        }
                    }
                } elseif ($jenis_operasi=="3" || $jenis_operasi=="2" || $jenis_operasi=="1") { //dml
                    $m=0;
                    try {
                        $result_parsing_dml = mysql_query($query_parsing);
                    } catch (Exception $e) {
                        $m=1;
                    }
                    if ($m==0) {
                        $sms_out = $key_op.$char_pemisah."Sukses : Perintah sukses dieksekusi !";
                        $log_in = "Sukses : Perintah sukses dieksekusi !";
                    } else {
                        $sms_out = $key_op.$char_pemisah."Error : Perintah gagal !";
                        $log_in = "Error : Perintah gagal !";
                    }
                }else { // fungsi proc
                    if ($output_sms=="") {
                        $m=0;
                        try {
                            $result_parsing_dml = mysql_query($query_parsing);
                        } catch (Exception $e) {
                            $m=1;
                        }
                        if ($m==0) {
                            $sms_out = $key_op.$char_pemisah."Sukses : Perintah sukses dieksekusi !";
                            $log_in = "Sukses : Perintah sukses dieksekusi !";
                        } else {
                            $sms_out = $key_op.$char_pemisah."Error : Perintah gagal !";
                            $log_in = "Error : Perintah gagal !";
                        }
                    } else {
                        $sms_out = $key_op."".$char_pemisah;
                        $log_in = "";
                        $words = explode(",", $output_sms);
                        $result_parsing_stp = mysql_query($query_parsing);
                        $n_parsing = mysql_num_rows($result_parsing_stp);
                        if ($n_parsing==0) {
                            $sms_out = $key_op.$char_pemisah."Error : Data tidak ditemukan.";
                            $log_in="Error : Data tidak ditemukan.";
                        } else {
                            $m=0;
                            $data_parsing_stp=mysql_fetch_array($result_parsing_stp, MYSQL_NUM);
                            $sms_out="";
                            foreach ($words as $word) {
                                if ($data_parsing_stp[$m]=="") {
                                    $sms_out="$sms_out$word = null\n";
                                    $log_in="$log_in$word = null\n";
                                } else {
                                    $sms_out="$sms_out$word = ".$data_parsing_stp[$m]."\n";
                                    $log_in="$log_in$word = ".$data_parsing_stp[$m]."\n";
                                }
                                $m++;
                            }
                        }
                    }
                    
                }   
            }
        } catch (Exception $e) {
            $sms_out = $key_op.$char_pemisah."Error : Server tidak dapat diakses.";
            $log_in ="Error : Server tidak dapat diakses.";
        }

        mysql_close();
        connectMyDB($server_dev, $username_dev, $password_dev, $name_dev);
        //'in dan in data
        $query = "INSERT INTO tb_operasi_in(id_operasi,user_screen,message_in) VALUE ('".$id_operasix."','".$pengirim."','".$textx."') ";
        $result = mysql_query($query);
        $ID = mysql_insert_id();

        //in data
        $query="INSERT INTO tb_operasi_in_data(id_op_in,format,sent_data) VALUE ('".$ID."','0','".$log_in."') ";
        $result = mysql_query($query);

        fungsi_send_twitter($sms_out, $pengirim);
        $query_parsing="DELETE FROM tb_eksekusi_respon WHERE id_eksekusi='$id_eksekusi'";
        $result_parsing = mysql_query($query_parsing);
    }

	/*RESPON SUKSES*/
	$data = dataRespon("1", "4");
	for ($i=0; $i<count($data); $i++) { 
		$id_eksekusi = $data[$i]["id_eksekusi"];
        $pengirim = $data[$i]["pengirim"];

        $jenis_operasi = $data[$i]["jenis_operasi"];
        $query_parsing = $data[$i]["query_parsing"];
        $host = $data[$i]["host"];
        $username = $data[$i]["username"];
        $password = $data[$i]["password"];
        $output_sms = $data[$i]["output_sms"];
        $output_field = $data[$i]["output_field"];
        $sms_in = $data[$i]["sms_in"];
        $dbx = $data[$i]["dbx"];
        $id_operasix = $data[$i]["id_operasix"];

        $is_broadcastx = $data[$i]["is_broadcastx"];
        $broadcast_grupx = $data[$i]["broadcast_grupx"];
		

		//==proses==
	    //koneksi local
	    mysql_close();
	    connectMyDB($host, $username, $password, $dbx);
        try {
        	if ($query_parsing=="error") {
        		$sms_out = $output_sms;
        	}else{
        		//update 0.0.1
                //is broadcast = 2
        		if ($is_broadcastx=="2") {
        			$sms_out = $output_sms;
        		} else {
        			if ($jenis_operasi=="4") {
        				$words = explode(",", $output_sms);
        				$result_parsing = mysql_query($query_parsing);
        				$n_parsing = mysql_num_rows($result_parsing);
        				if ($n_parsing==0) {
        					$sms_out="Maaf data tidak ditemukan.";
        				} else {
        					$sms_out="";
        					$j=0;
        					while ($data_parsing=mysql_fetch_array($result_parsing, MYSQL_NUM)) {
        						$m=0;
        						foreach ($words as $word) {
        							$sms_out=$word." ".$data_parsing[$m]."\n";
        							$m++;
        						}

        						if ($j==($n_parsing-1)) {
        							$sms_out = $sms_out;
        						} else {
        							$sms_out = $sms_out."\n";
        						}
        						$j++;
        					}
        				}
        			}elseif ($jenis_operasi=="3" || $jenis_operasi=="2" || $jenis_operasi=="1") { //insert update delete
        				$m=0;
        				try {
        					$result_parsing_dml = mysql_query($query_parsing);
        				} catch (Exception $e) {
        					$m=1;
        				}
        				if ($m==0) {
        					$sms_out = "Permintaan selesai diproses.";
        				} else {
        					$sms_out="Maaf, permintaan tidak dapat diproses.";
        				}
        			} else { // fungsi dan prosedur
        				if ($output_sms=="") {
        					$m=0;
	        				try {
	        					$result_parsing_stp = mysql_query($query_parsing);
	        				} catch (Exception $e) {
	        					$m=1;
	        				}
	        				if ($m==0) {
	        					$sms_out = "Permintaan selesai diproses.";
	        				} else {
	        					$sms_out="Maaf, permintaan tidak dapat diproses.";
	        				}
        				} else {
        					$words = explode(",", $output_sms);
	        				$result_parsing_stp = mysql_query($query_parsing);
	        				$n_parsing = mysql_num_rows($result_parsing_stp);
	        				if ($n_parsing==0) {
	        					$sms_out="Maaf data tidak ditemukan.";
	        				} else {
	        					$data_parsing_stp=mysql_fetch_array($result_parsing_stp, MYSQL_NUM);
	        					$sms_out="";
	        					$m=0;
        						foreach ($words as $word) {
        							if ($data_parsing_stp[$m]=="") {
        								$sms_out="-\n";
        							} else {
        								$sms_out=$data_parsing_stp[$m]."\n";
        							}
        							$m++;
        						}
	        				}
        				}
        				
        			}
        			
        		}
        	}
        } catch (Exception $e) {
        	$sms_out = "Maaf, saat ini data tidak dapat diakses.";
        }

        mysql_close();
        connectMyDB($server_dev, $username_dev, $password_dev, $name_dev);
		//operasi cast
		cast_operasi($pengirim, $id_operasix, $sms_in, "2");

		if ($is_broadcastx=="1") {
			fungsi_broadcast_twitter($sms_out, $pengirim, $broadcast_grupx);
		}elseif ($is_broadcastx=="2") {
			fungsi_broadcast_twitter($sms_out, $pengirim, $broadcast_grupx);
		} else {
			fungsi_send_twitter($sms_out, $pengirim);
		}
		
		$query_parsing="DELETE FROM tb_eksekusi_respon WHERE id_eksekusi='$id_eksekusi'";
		$result_parsing = mysql_query($query_parsing);
	}

	header("Location: new_msg.php");	
	die();
} catch (Exception $e) {
    echo "[".date("d/m/Y H:i")."]<br>";
	echo 'Error : ',  $e->getMessage(), "<br>";
}
/*echo '<pre>'; print_r($auth->getHeaders()); echo '</pre>';
echo '<pre>'; print_r($response); echo '</pre><hr />';*/

?>