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

// setenv

echo PHP_EOL;
echo 'set env user1';

if (file_exists('USER1')) {
    $user1 = file_get_contents('USER1');
    echo $user1;
}

echo PHP_EOL;
echo 'set env user1';

if (file_exists('USER2')) {
    $user2 = file_get_contents('USER2');
    echo $user2;
}