<?php
require_once 'vendor/autoload.php';

// init configuration
$clientID =  getenv("GOOGLE_CLIENT_ID");
$clientSecret = getenv("GOOGLE_CLIENT_SECRET");
$redirectUri = 'http://localhost/reservet/index.php?vista=authg';

// create Client Request to access Google API

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");