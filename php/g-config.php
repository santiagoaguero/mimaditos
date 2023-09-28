<?php
require_once 'vendor/autoload.php';

// init configuration
$clientID = '203049535631-ep1qalm55b58iafbcu5l363137jr6arv.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/reservet/index.php?vista=authg';

// create Client Request to access Google API

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");