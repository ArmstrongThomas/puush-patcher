<?php

// doesn't currently work.

include 'includes/config/Database.conf.php';
include 'includes/classes/Database.class.php';
include 'includes/classes/Puush.class.php';
include 'includes/config/Global.conf.php';

$DB = new Database($dbhost, $dbport, $dbuser, $dbpass, $dbname);

if (!isset($_POST["k"]) || !$DB->checkKey($_POST["k"]))
    return;
$domain = $DB->getDomainByKey($_POST["k"]);
$lastFiles = $DB->getLastFilesByKey($_POST["k"]);
echo (5-sizeof($lastFiles))."\r\n";

foreach ($lastFiles as $file)
{
    echo sprintf("%d,%s,http://%s/%s,%s,%d,%d\r\n", $file["id"], $file["date"], $domain, $file["name"], $file["orginalname"], $file["viewcount"], $file["thumbenabled"]);
}
