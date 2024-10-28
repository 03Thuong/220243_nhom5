<?php
require_once 'vendor/autoload.php';

// Setup the Google Client
$client = new Google_Client();
$client->setClientId('707197531980-8t7onugv7m0lfc6c37c5k3unrruo8gef.apps.googleusercontent.com'); // Replace with your Client ID
$client->setClientSecret('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'); // Replace with your Client Secret
$client->setRedirectUri('http://localhost:8080/QLSV/google_login.php'); // Update this to your redirect URL
$client->addScope('email');
$client->addScope('profile');

// Generate the login URL
$googleLoginUrl = $client->createAuthUrl();
?>
