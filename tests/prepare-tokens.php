<?php

// get new tokens via phantomjs - used at travis ci

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Return new tokens
 *
 * @param string $user
 * @return bool|mixed|string
 */
function getTokens($user)
{
    echo 'Fetch tokens' . PHP_EOL;

    $exec = 'phantomjs tests/phantom-login.js ';

    switch ($user) {
        case 1:
            $tokens = shell_exec($exec . ' user1');
            break;

        case 2:
            $tokens = shell_exec($exec . ' user2');
            break;

        default:
            echo 'Tokens could not be fetched';
            exit;
    }

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
echo 'Prepare username1: ';
echo getenv('username1');
echo PHP_EOL;
$tokens = getTokens(1);
putenv('access_token=' . $tokens->access_token);
putenv('refresh_token=' . $tokens->refresh_token);

// user 2
echo 'Prepare username2: ';
echo getenv('username2');
echo PHP_EOL;

$tokens = getTokens(2);
putenv('access_token2=' . $tokens->access_token);
putenv('refresh_token2=' . $tokens->refresh_token);

