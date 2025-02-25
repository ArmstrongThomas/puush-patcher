<?php
// Not currently hooked up.
// This is the delete file function.

include 'includes/config/Database.conf.php';
include 'includes/classes/Database.class.php';
include 'includes/classes/Puush.class.php';
include 'includes/config/Global.conf.php';

$DB = new Database($dbhost, $dbport, $dbuser, $dbpass, $dbname);

if (!isset($_POST["k"], $_POST['i']) || !$DB->checkKey($_POST["k"])) {
    return;
}

if (!$DB->isFileOwner($_POST["i"], $_POST["k"])) {
    return;
}

$name = $DB->getFileNameByID($_POST["i"]);
$DB->deleteFileByID($_POST["i"]);

$matched = glob($uploadDirectory."/". $name.".*");

if (empty($matched)) {
    return;
}

unlink($matched[0]);

require_once "history.php";
