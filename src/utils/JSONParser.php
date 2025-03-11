<?php

namespace App\utils;

class JSONParser
{
    public static function getJSONEncodedString($json): string
    {
        $array = array_map(function ($item) {
            if (!$item) {
                return [];
            }

            return mb_convert_encoding($item, 'UTF-8', 'UTF-8');
        }, $json);

        return htmlspecialchars(json_encode($array), ENT_QUOTES, 'UTF-8');
    }
}