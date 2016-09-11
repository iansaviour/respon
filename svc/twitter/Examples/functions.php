<?php  
	function getCredentials(){
		$query = "SELECT consumer_key, consumer_secret, oauth_token, oauth_token_secret FROM tb_option_twitter ";
		$res = mysql_query($query);
		$data = mysql_fetch_array($res);
		return $data;
	}

	function limitReq($auth,$type){
		$params = array(
			'resources' => $type,
		);
		$response = $auth->get('application/rate_limit_status', $params);
		$head = $auth->getHeaders();
		return $head['x-rate-limit-remaining'];
	}

?>