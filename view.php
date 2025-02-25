<?php

include 'includes/config/Database.conf.php';
include 'includes/classes/Database.class.php';
include 'includes/classes/Puush.class.php';
include 'includes/config/Global.conf.php';

$DB = new Database($dbhost, $dbport, $dbuser, $dbpass, $dbname);

if (!isset($_GET['image'])) {
    exit('ERR No image provided.');
}

$image = basename(urldecode($_GET['image']));

// Retrieve the file information from the database
$fileInfo = $DB->getFileInfo($image);
if (!$fileInfo) {
    exit('ERR No file info found.');
}

// Extract the original file name and determine the extension
$originalName = $fileInfo['orginalname'];
$ext = strtolower(Puush::getExtension($originalName));

$matched = $uploadDirectory . "/" . $image . "." . $ext;

if (!file_exists($matched)) {
    exit('ERR No image found.');
}

global $whitelist;
$mime = false;
foreach ($whitelist as $type => $extensions) {
    if (in_array($ext, $extensions, true)) {
        $mime = $type;
        break;
    }
}

if ($mime !== false) {
    if ($ext === 'swf') {
        echo '<script src="https://unpkg.com/@ruffle-rs/ruffle"></script>';
        echo '<div style="width: 100%; height: 100%;">';
        echo '<embed src="' . $matched . '" width="100%" height="100%" />';
        echo '</div>';
    } else {
        header('Content-type: ' . $mime);
        header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60 * 24))); // 1 day
        header('Cache-Control: public, max-age=86400');

        ob_clean();
        flush();

        readfile($matched);
    }
    $DB->updateViewCount($_GET['image']);
}
?>