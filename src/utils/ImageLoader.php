<?php

namespace App\utils;

use App\datenbank\Entitaeten\Bild;
use finfo;

class ImageLoader
{
    static function getImageHTMLSrc(Bild $image): string {
        //error_log($image->getBild());

        $rawData = $image->getBild();

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($rawData);

        //error_log($mimeType);

        $base64Image = base64_encode($rawData);

        return 'data:' . $mimeType . ';base64,' . $base64Image;
    }
}