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
        $config   = require dirname(__FILE__).'/config.php';
        $Makerlog = new PCSG\Makerlog\Makerlog($config);

        return $Makerlog;
    }
}
