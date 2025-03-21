<?php

namespace App\utils;

class Number
{
    public static function unformatPreis($preis): string
    {
        if (!$preis) {
            return "";
        }

        $preis = str_replace('.', '', $preis);
        return str_replace(',', '.', $preis);
    }

    public static function reformatPreis($preis): string
    {
        if (!$preis) {
            return "";
        }

        $preis = preg_replace('/[^0-9.]/', '', $preis);
        return number_format($preis, 2, ',', '.');
    }

    public static function summePreis($wert1, $wert2): string
    {
        return bcadd($wert1, $wert2, 2);
    }

    public static function subtraktionPreis($wert1, $wert2): string
    {
        return bcsub($wert1, $wert2, 2);
    }

    public static function multiplierPreis($wert1, $wert2): string
    {
        return bcmul($wert1, $wert2, 2);
    }

    public static function prozentPreis($wert, $prozentsatz): string
    {
        return bcdiv(Number::multiplierPreis($wert, $prozentsatz), '100', 2);
    }
}