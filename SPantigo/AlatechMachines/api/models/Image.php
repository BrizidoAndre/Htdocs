<?php

namespace app\models;

class Image
{
    public static function getImage($imagename){
        $baseFile = "images/";
        return base64_encode(file_get_contents($imagename));
    }
}