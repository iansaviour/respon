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
 *   - oauth_token         Twitter Access token
 *   - oauth_token_secret  Twitter Access token secret
 */
$credentials = array(
   	'consumer_key' => '7zTBN57Z8aN7pJ60z8zWgWDB2',
    'consumer_secret' => '826JWIOQlRcJf8uKMC9ZGzmsNXeeL6NMdQUdLjvJdUPaN5DuYd',
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
 * To post something with media, first you need to upload some media
 * and get the ids given by Twitter
 *
 * https://dev.twitter.com/rest/public/uploading-media-multiple-photos
 */
$response = $auth->postMedia('media/upload', '../Tests/TwitterIcon.png');
$media_ids[] = $response['media_id'];

/*$response = $auth->postMedia('media/upload', './photo2.jpg');
$media_ids[] = $response['media_id'];

$response = $auth->postMedia('media/upload', './photo3.png');
$media_ids[] = $response['media_id'];*/


/**
 * Now you can post something with the media ids given by Twitter
 *
 * https://dev.twitter.com/rest/reference/post/statuses/update
 */
$params = array(
    'status' => 'This is a media/upload test...',
    'media_ids' => implode(',', $media_ids),
);

$response = $auth->post('statuses/update', $params);


echo '<pre>'; print_r($auth->getHeaders()); echo '</pre>';

echo '<pre>'; print_r($response); echo '</pre><hr />';
