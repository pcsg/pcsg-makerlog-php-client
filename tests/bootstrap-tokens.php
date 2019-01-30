<?php

// get new tokens via phantomjs - used at travis ci

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

    $exec = 'phantomjs tests/phantom-login.js ';
    system($exec."'".$username."' '".$password."' --debug 2>&1", $tokens);

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
$tokens = getTokens(getenv('username1'), getenv('password1'));
putenv('access_token='.$tokens->access_token);
putenv('refresh_token='.$tokens->refresh_token);


// user 2
$tokens = getTokens(getenv('username2'), getenv('password2'));
putenv('access_token2='.$tokens->access_token);
putenv('refresh_token2='.$tokens->refresh_token);

