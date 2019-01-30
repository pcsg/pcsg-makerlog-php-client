<?php

// get new tokens via phantomjs - used at travis ci

/**
 * Return new tokens
 *
 * @param string $username
 * @param string $password
 * @return bool|mixed|string
 */
function getTokens($username, $password)
{
    $exec   = 'phantomjs '.dirname(__FILE__).'/phantom-login.js ';
    $tokens = shell_exec($exec."'".$username."' '".$password."'");

    echo $tokens;

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

