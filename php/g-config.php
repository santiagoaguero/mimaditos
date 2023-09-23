<?php
require_once 'vendor/autoload.php';

// init configuration
$clientID = '213735222223-k25ac704ncjic8ql8iv53capbrrdskp2.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/reservet/index.php?vista=home';

// create Client Request to access Google API

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");