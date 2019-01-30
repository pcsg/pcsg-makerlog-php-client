<?php

require_once dirname(__FILE__, 2).'/vendor/autoload.php';

//  ../vendor/bin/phpunit
//  ../vendor/bin/phpunit --coverage-clover=./reports/clover.xml --coverage-html=./reports

/**
 * Class MakerLogTest
 * Helper class for the tests
 */
class MakerLogTest
{
    /**
     * Returns the makerlog main class
     *
     * @return \PCSG\Makerlog\Makerlog
     */
    public static function getMakerlog()
    {
        if (file_exists(dirname(__FILE__).'/config.php')) {
            $config = require dirname(__FILE__).'/config.php';
        } else {
            $config = [
                'client_id'     => getenv('client_id'),
                'client_secret' => getenv('client_secret'),
                'access_token'  => getenv('access_token'),
                'refresh_token' => getenv('refresh_token')
            ];
        }

        $Makerlog = new PCSG\Makerlog\Makerlog($config);

        return $Makerlog;
    }

    /**
     * Second client, to test notifications and following
     *
     * @return \PCSG\Makerlog\Makerlog
     */
    public static function getMakerlog2()
    {
        if (file_exists(dirname(__FILE__).'/config.php')) {
            $config = require dirname(__FILE__).'/config.php';

            $config['access_token'] = $config['access_token2'];
        } else {
            $config = [
                'client_id'     => getenv('client_id'),
                'client_secret' => getenv('client_secret'),
                'access_token'  => getenv('access_token2'),
                'refresh_token' => getenv('refresh_token2')
            ];
        }

        $Makerlog = new PCSG\Makerlog\Makerlog($config);

        return $Makerlog;
    }
}

// get new tokens via phantomjs - used at travis ci
if (getenv('username1')) {
    /**
     * Return new tokens
     *
     * @param string $username
     * @param string $password
     * @return bool|mixed|string
     */
    function getTokens($username, $password)
    {
        $exec   = dirname(__FILE__).'/phantomjs phantom-login.js ';
        $tokens = system($exec."'".$username."' '".$password."'");

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
    putenv('access_token='.$tokens);
    putenv('refresh_token='.$tokens);


    // user 2
    $tokens = getTokens(getenv('username2'), getenv('password2'));
    putenv('access_token2='.$tokens);
    putenv('refresh_token2='.$tokens);
}
