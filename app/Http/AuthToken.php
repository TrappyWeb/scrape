<?php

namespace App\Http;

class AuthToken
{
    public const string TOKEN = 'b0f2d07a-f50b-40eb-8d4b-44561b68287d';

    public static function validate(string|null $token): bool
    {
        if ($token === null) {
            return false;
        }

        if ($token === self::TOKEN) {
            return true;
        }

        return false;
    }
}