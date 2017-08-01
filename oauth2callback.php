<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'application/libraries/google-api-php-client/vendor/autoload.php';
require_once 'application/libraries/google-api-php-client/src/Google/Client.php';
require_once 'application/libraries/google-api-php-client/src/Google/Service/Oauth2.php'; 

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_secrets.json');
$client->setRedirectUri('http://shopsatavenue.biz/beta_new/oauth2callback.php');
$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));

$plus = new Google_Service_Oauth2($client);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
  
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  //$redirect_uri = 'http://shopsatavenue.biz/beta_new/oauth2callback.php';
  $userinfo = $plus->userinfo;

}