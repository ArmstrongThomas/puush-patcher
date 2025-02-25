<?php

include "includes/config/Global.conf.php";

class Puush
{
    private static function random_filename(): string
    {
        $random_string = md5(uniqid(rand(), true));
        return substr($random_string, 0, rand(4, 8));
    }

    public static function generateFileName($extension): string
    {
        global $uploadDirectory;
        $name = self::random_filename();

        while (file_exists($uploadDirectory . "/" . $name . "." . $extension)) {
            $name = self::random_filename();
        }

        return $name;
    }

    public static function getExtension($file)
    {
        $file = explode(".", $file);
        return end($file);
    }

    public static function validateFile($file): bool
    {
        global $whitelist;
        $finfo = finfo_open(FILEINFO_MIME);
        $mimeType = finfo_file($finfo, $file["tmp_name"], FILEINFO_MIME_TYPE);
        finfo_close($finfo);


        if (!array_key_exists($mimeType, $whitelist)) {
            return false;
        }

        if ($whitelist[$mimeType] !== self::getExtension($file["name"])) {
            return false;
        }

        if (str_starts_with($mimeType, "image")) {
            $imgInfo = getimagesize($file["tmp_name"]);

            if (empty($imgInfo)) {
                return false;
            }
        }

        return true;
    }
}