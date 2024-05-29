<?php

namespace app\bases;

class ThrowClass
{

    public $message;

    public function __construct(string $message, int $code = 200)
    {
        $this->message = $message;
    }
}