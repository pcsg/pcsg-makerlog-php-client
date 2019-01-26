<?php

require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

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
        if (file_exists(dirname(__FILE__) . '/config.php')) {
            $config = require dirname(__FILE__) . '/config.php';
        } else {
            $config = [
                'client_id' => getenv('client_id'),
                'client_secret' => getenv('client_secret'),
                'access_token' => getenv('access_token')
            ];
        }

        $Makerlog = new PCSG\Makerlog\Makerlog($config);

        return $Makerlog;
    }
}
