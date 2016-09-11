<?php
ini_set('max_execution_time', 300);
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

/*percobaan
$auth = new SingleUserAuth($credentials, new ArraySerializer());
$params = array(
			'user_id' => '181498811',
			'text' => time()
		);
$response = $auth->post('direct_messages/new', $params);
echo '<pre>'; print_r($auth->getHeaders()); echo '</pre>';
echo '<pre>'; print_r($response); echo '</pre><hr />';*/

$auth = new SingleUserAuth($credentials, new ArraySerializer());
$arr_inb = array();
$query_inb = "SELECT a.id_outbox, b.inbox_user, a.outbox, b.inbox_user_screen FROM tb_sent_twitter a INNER JOIN tb_inbox_twitter b ON a.id_inbox=b.id_inbox WHERE a.is_sent = '1' ORDER BY a.id_outbox ASC ";
$result_inb = mysql_query($query_inb);
$jum_inb = mysql_num_rows($result_inb);

$query_inb_ex = "SELECT a.id_outbox, a.outbox, a.outbox_user_screen FROM tb_sent_twitter a  WHERE a.is_sent = '1' AND (ISNULL(a.id_inbox) OR a.id_inbox='') ORDER BY a.id_outbox ASC ";
$result_inb_ex = mysql_query($query_inb_ex);
$jum_inb_ex = mysql_num_rows($result_inb_ex);

if  ($jum_inb>0 || $jum_inb_ex >0) {
	if ($jum_inb>0) {
		$i_msg = 0;
		$arr_tw = array();
		
		while ($data_inb = mysql_fetch_array($result_inb)) {
			try {
				$auth = new SingleUserAuth($credentials, new ArraySerializer());
				$params = array(
							'user_id' => $data_inb['inbox_user'],
							'text' => $data_inb['outbox']
						);
				$response = $auth->post('direct_messages/new', $params);
				
				//update statys
				$query_upd = "UPDATE tb_sent_twitter SET is_sent='2' WHERE id_outbox='".$data_inb['id_outbox']."' ";
				$result_upd = mysql_query($query_upd);
				echo"Direct message sent to @".$data_inb['inbox_user_screen']."<br>";	
			} catch (Exception $e) {
				echo 'Error: ',  $e->getMessage(), "<br>";
			}
			$i_msg++;
		}
	}

	$i_msg = 0;
	$arr_tw = array();

	if ($jum_inb_ex>0) {
		$i_msg = 0;
		$arr_tw = array();
		
		while ($data_inb_ex = mysql_fetch_array($result_inb_ex)) {
			try {
				$auth = new SingleUserAuth($credentials, new ArraySerializer());
				$params = array(
							'screen_name' => $data_inb_ex['outbox_user_screen'],
							'text' => $data_inb_ex['outbox']
						);
				$response = $auth->post('direct_messages/new', $params);
				
				//update statys
				$query_upd = "UPDATE tb_sent_twitter SET is_sent='2' WHERE id_outbox='".$data_inb_ex['id_outbox']."' ";
				$result_upd = mysql_query($query_upd);
				echo "[".date("d/m/Y H:i")."]<br>";
				echo"Direct message sent to @".$data_inb_ex['outbox_user_screen']."<br>";	
			} catch (Exception $e) {
				echo "[".date("d/m/Y H:i")."]<br>";
				echo 'Error: ',  $e->getMessage(), "<br>";
			}
			$i_msg++;
		}
	}
}else{
	echo "[".date("d/m/Y H:i")."]<br>";
	echo "No action required ...<br>";
}

?>