<?php

namespace app\models;


class Captcha
{
    private static int $challenge;

    public static function generateChallenge(){
        self::$challenge = random_int(10000,99999);

        return self::$challenge;
    }

    public static function getChallenge(){
        return self::$challenge;
    }
}