<?php

namespace Giatechindo\HypervelResponseFormatter;

class ResponseFormatter
{
    protected static $config;

    public static function init(array $config)
    {
        self::$config = $config;
    }

    public static function success($data, string $message = 'Success', int $code = 200)
    {
        return [
            'status' => self::$config['status_success'] ?? 'success',
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
    }

    public static function error(string $message, int $code = 400, $errors = [])
    {
        return [
            'status' => self::$config['status_error'] ?? 'error',
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
        ];
    }
}