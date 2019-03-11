<?php

/**
 * This script shows how to get new users
 *
 * @author www.pcsg.de (Henning Leutz - https://twitter.com/de_henne)
 */

require_once dirname(__FILE__, 2).'/vendor/autoload.php';

$Makerlog = new PCSG\Makerlog\Makerlog();

$Stats = $Makerlog->getStats();
$data  = $Stats->getStats();

var_dump(array_keys((array)$data));
exit;

$newUsers = $data->new_users;

foreach ($newUsers as $user) {
    echo $user->username.PHP_EOL;
}

echo PHP_EOL;