<?php

require_once __DIR__.'/vendor/autoload.php';

#require_once __DIR__ .'/src/huuid.php';

use \lestad\huuid\HUUID;

echo HUUID::create('net.lestad'), PHP_EOL;
echo HUUID::rHUUID('net.lestad'), PHP_EOL;
echo $c = HUUID::eHUUID('net.lestad'), ' : ', HUUID::isValid($c) ? 'valid' : 'invalid';
echo PHP_EOL, PHP_EOL;


for ($i = 0; $i < 10; $i++) {
    echo $huuid = HUUID::create('net.lestad.huuid'), ' : ';
    echo (HUUID::isValid($huuid) ? 'valid' : 'not valid' ), ' - ';
    echo (HUUID::check($huuid, 'net.lestad.huuid') ? 'in' : 'out' ), PHP_EOL;
    sleep(0.1);
}

for ($i = 0; $i < 10; $i++)
{
    $namespace = 'net.lestad.tests.'.$i;
    $h = HUUID::eHUUID($namespace);
    $valid = HUUID::isValid($h) ? 'valid' : 'invalid';
    echo $h, ' - ', $valid, PHP_EOL;
}
