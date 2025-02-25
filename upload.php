<?php
include 'includes/config/Database.conf.php';
include 'includes/classes/Database.class.php';
include 'includes/classes/Puush.class.php';
include 'includes/config/Global.conf.php';

$DB = new Database($dbhost, $dbport, $dbuser, $dbpass, $dbname);

if (!isset($_POST["k"], $_FILES['f']) || !$DB->checkKey($_POST["k"])) {
    return;
}

$validlnk = $DB->getDomainByKey($_POST["k"]);

$file = $_FILES['f'];

if ($file['size'] > $fileMaxSize) {
    return;
}

$extension = strtolower(Puush::getExtension($file['name']));

global $whitelist;
$mime = false;
foreach ($whitelist as $type => $extensions) {
    if (in_array($extension, $extensions, true)) {
        $mime = $type;
        break;
    }
}

if ($mime === false) {
    return;
}

$fileName = Puush::generateFileName($extension);

move_uploaded_file($file['tmp_name'], $uploadDirectory . "/" . $fileName . "." . $extension);

$DB->insertFile($_POST["k"], $fileName, $file["name"], 0);

echo '0,' . sprintf("http://" . $validlnk . "/%s." . $extension, $fileName) . ',-1,-1';