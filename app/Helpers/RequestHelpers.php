<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class RequestHelpers
{
    /**
     * Transforms array data to snake_case.
     */
    public static function snakeKeys(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = self::snakeKeys($value);
            }
            $result[Str::snake($key)] = $value;
        }

        return $result;
    }
}