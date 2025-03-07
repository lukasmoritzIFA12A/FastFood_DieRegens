<?php

namespace App\utils;

use App\datenbank\Entitaeten\Bild;
use finfo;

class ImageLoader
{
    static function getImageHTMLSrc(Bild $image): string {
        $rawData = $image->getBild();
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($rawData);
        $base64Image = base64_encode($rawData);
        return 'data:' . $mimeType . ';base64,' . $base64Image;
    }
}