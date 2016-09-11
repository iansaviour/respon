<?php

/**
 * TwitterOAuth - https://github.com/ricardoper/TwitterOAuth
 * PHP library to communicate with Twitter OAuth API version 1.1
 *
 * @author Ricardo Pereira <github@ricardopereira.es>
 * @copyright 2014
 */

include("koneksi.php");
include("functions.php");
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
 * Returns a collection of the most recent Tweets posted by the user
 * https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline
 */

$params = array(
    'user_id' => '181498811',
    'screen_name' => 'catursatrya'
);

/**
 * Send a GET call with set parameters
 */
$response = $auth->get('followers/ids', $params);
/*$head = $auth->getHeaders();
echo $head['x-rate-limit-remaining'];*/
echo '<pre>'; print_r($auth->getHeaders()); echo '</pre>';

echo '<pre>'; print_r($response); echo '</pre><hr />';