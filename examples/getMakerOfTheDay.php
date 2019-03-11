<?php

/**
 * This script shows how to get the Maker Of the Day
 *
 * @author www.pcsg.de (Henning Leutz - https://twitter.com/de_henne)
 */

require_once dirname(__FILE__, 2).'/vendor/autoload.php';

$Makerlog = new PCSG\Makerlog\Makerlog();

$Stats = $Makerlog->getStats();
$data  = $Stats->getStats();

$MakerOfTheDay = $data->maker_of_the_day;

// var_dump($MakerOfTheDay);
echo $MakerOfTheDay->username;
echo PHP_EOL;