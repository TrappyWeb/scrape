<?php

namespace App\Http;

class Response
{
    public static function json(array $value, int $status): never
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

        http_response_code($status);

        exit(json_encode($value));
    }
}