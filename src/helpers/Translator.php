<?php

namespace Src\Helpers;

class Translator
{
    public static function trans($key, ...$values): string
    {
        return sprintf($key, ...$values);
    }
}