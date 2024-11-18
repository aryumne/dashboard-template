<?php

namespace App\Helpers;

class CustomHelpers
{
    public static function nameToSlug($name)
    {
        return strtolower(preg_replace('/\s+/', '-', $name));
    }
}
