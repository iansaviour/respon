<?php

/**
 * TwitterOAuth - https://github.com/ricardoper/TwitterOAuth
 * PHP library to communicate with Twitter OAuth API version 1.1
 *
 * @author Ricardo Pereira <github@ricardopereira.es>
 * @copyright 2014
 */


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
 */
$credentials = array(
    'consumer_key' => '6M0saSWv3XbA6xhCTZ28TgNz3',
    'consumer_secret' => 'DnTX6jXsEr1Whpcv5P20BFBoTaxlls5jnRLndy4wQL6d0MUnCB',
    'oauth_token' => '45765344-R1jUVwfQCJnOn3fGLPLiE3LqvwEKkkC5mJXv5wZlO',
    'oauth_token_secret' => 'KGOS3xaWQTrFAy9cNp0WcHes7lW6SZV9M0SaK1fYOuC5r',
);

/**
 * Instantiate SingleUser
 *
 * For different output formats you can set one of available serializers
 * (Array, Json, Object, Text or a custom one)
 */
$serializer = new ArraySerializer();

$auth = new SingleUserAuth($credentials, $serializer);


/**
 * Allows a Consumer application to obtain an OAuth Request Token to request user authorization
 *
 * https://dev.twitter.com/oauth/reference/post/oauth/request_token
 */
$params = array(
    'id' => '380127138034098176',
);

$response = $auth->post('direct_messages/destroy', $params);


echo '<pre>'; print_r($auth->getHeaders()); echo '</pre>';

echo '<pre>'; print_r($response); echo '</pre><hr />';
