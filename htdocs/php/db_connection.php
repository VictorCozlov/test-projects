<?php

$mh = 'sql301.byethost22.com';
$mu = 'b22_19256040';
$mp = 'hostVK91Work';
$myDB = 'b22_19256040_restaurant';

if (!$link = mysql_connect($mh, $mu, $mp)) {
    mysql_error();
    exit;
}

if (!mysql_select_db($myDB, $link)) {
    echo 'can not chose database';
    exit;
}

