<?php

// get new tokens via own token service

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Return new tokens
 *
 * @param string $username
 * @param string $password
 * @return bool|mixed|string
 */
function getTokens($username, $password)
{
    echo 'Fetch tokens'.PHP_EOL;

    $request = 'http://pcsg8.pcsg-server.de/makerlog/token.php';
    $params  = [
        'username' => $username,
        'password' => $password,
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $request.'?'.http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    $tokens = curl_exec($ch);
    curl_close($ch);

    $tokens = str_replace(
        'TypeError: Attempting to change the setter of an unconfigurable property.',
        '',
        $tokens
    ); // phantom bug - workaround

    $tokens = trim($tokens);
    $tokens = json_decode($tokens);

    return $tokens;
}

// user 1
echo 'Prepare username1:';
echo PHP_EOL;
$tokens = getTokens(getenv('username1'), getenv('password1'));
putenv('access_token='.$tokens->access_token);
putenv('refresh_token='.$tokens->refresh_token);

// user 2
echo 'Prepare username2:';
echo PHP_EOL;

$tokens = getTokens(getenv('username2'), getenv('password2'));
putenv('access_token2='.$tokens->access_token);
putenv('refresh_token2='.$tokens->refresh_token);
