<?php
$domain = "example.com"; // Domain where the images are saved
$uploadDirectory = "ups"; // Directory where the images are saved
$fileMaxSize = 200 * 1024 * 1024;
$whitelist = array(
    'image/jpeg' => ['jpeg', 'jpg'],
    'image/png' => ['png'],
    'image/psd' => ['psd'],
    'image/bmp' => ['bmp', 'wbmp'],
    'image/gif' => ['gif'],
    'audio/mpeg' => ['mp3'],
    'application/x-rar-compressed' => ['rar'],
    'application/x-rar' => ['rar'],
    'application/x-zip-compressed' => ['zip'],
    'application/zip' => ['zip'],
    'application/x-7z-compressed' => ['7z'],
    'text/plain' => ['txt'],
    'text/html' => ['html', 'htm'],
    'text/css' => ['css'],
    'font/otf' => ['otf'],
    'font/ttf' => ['ttf'],
    'font/woff' => ['woff'],
    'font/woff2' => ['woff2'],
    'image/svg+xml' => ['svg'],
    'audio/wav' => ['wav'],
    'audio/x-wav' => ['wav'],
    'image/webp' => ['webp'],
    'application/pdf' => ['pdf'],
    'application/x-shockwave-flash' => ['swf']
);
?>