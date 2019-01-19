<?php

/**
 * This is an example to get an oAuth token from makerlog
 * The whole thing is sometimes a little bit complicated, so I wrote this little script to make the start a little bit easier
 *
 * - To use this script you need to register an application at https://api.getmakerlog.com/oauth/applications/
 *      - Fill out the name
 *      - Client type must be: confidential
 *      - Authorization Grant Type must be: authorization-code
 *
 * - Then you have to upload this script where it can be accessed online. The place where script is, is your redirect URI.
 *      Example: https://your-domain.tld/oauth/redirect.php
 *
 * - Then please fill in the OAUTH settings
 *
 * - If everything is filled out correctly, then please call up this file in the Browser
 *      Exmaple: https://your-domain.tld/oauth/redirect.php
 *
 *
 * @author Henning Leutz (@https://getmakerlog.com/@dehenne)
 */

/**
 * App settings - OAUTH settings
 *
 * PLEASE SET UP THIS
 */

$clientId = '';
$clientSecret = '';
$scopes = ['tasks:read', 'products:read', 'projects:read', 'notifications:read', 'me:read'];
$redirectUri = '';


/**
 * From here on nothing has to be filled in
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

echo '<pre>';

$apiEndpoint = 'https://api.getmakerlog.com';

/**
 * First we need an oauth authorize code
 */
if (!isset($_REQUEST['code'])) {
    $state = time();
    $_SESSION['state'] = $state;

    // get authorize token
    $url = $apiEndpoint . '/oauth/authorize/?';
    $url .= 'client_id=' . $clientId;
    $url .= '&scopes=' . urlencode(implode(',', $scopes));
    $url .= '&response_type=code';
    $url .= '&redirect_uri=' . urlencode($redirectUri);
    $url .= '&state=' . $_SESSION['state'];

    // Redirect the user to the authorization URL.
    header('Location: ' . $url);
    exit;
}

if (!isset($_REQUEST['state'])) {
    echo "undefined state";
    exit(0);
}

if (!isset($_SESSION['state']) || $_SESSION['state'] != $_REQUEST['state']) {
    echo "State is expired or wrong. Please try again";
    exit(0);
}

/**
 * Then we want the tokens
 */

$code = $_REQUEST['code'];
$state = $_REQUEST['state'];

$Curl = curl_init();

curl_setopt($Curl, CURLOPT_URL, 'https://api.getmakerlog.com/oauth/token/');
curl_setopt($Curl, CURLOPT_USERPWD, $clientId . ":" . $clientSecret);
curl_setopt($Curl, CURLOPT_POST, 1);
curl_setopt($Curl, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => $redirectUri
]));

curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($Curl);
curl_close($Curl);

$result = json_decode($result, true);

if (!$result || !isset($result['access_token'])) {
    echo 'Access Token has probably expired. Please try again';
    exit(0);
}

echo 'Your Access Tokens:' . PHP_EOL;
echo '-------------------' . PHP_EOL;

echo 'Access Token: ' . $result['access_token'] . PHP_EOL;
echo 'Refresh Token: ' . $result['refresh_token'] . PHP_EOL;
