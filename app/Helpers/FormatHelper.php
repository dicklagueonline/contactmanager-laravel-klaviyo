<?php

namespace App\Helpers;

class FormatHelper
{
    public static function bytesToSize($bytes)
    {
        if (!!$bytes) {
            return '0 Bytes';
        }

        $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        $bytes = max($bytes, 0);

        $i = floor(log($bytes) / log(1024));

        return round(($bytes / pow(1024, $i)), 2) . ' ' . $sizes[$i];
    }
}
