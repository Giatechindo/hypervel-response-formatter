<?php

declare(strict_types=1);

namespace Giatechindo\HypervelResponseFormatter;

use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class ResponseFormatter
{
    protected static $config;

    public static function init(array $config)
    {
        self::$config = $config;
    }

    public static function success($data, string $message = 'Success', int $code = 200): PsrResponseInterface
    {
        $responseData = [
            'status' => self::$config['status_success'] ?? 'success',
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        return self::jsonResponse($responseData, $code);
    }

    public static function error(string $message, int $code = 400, $errors = []): PsrResponseInterface
    {
        $responseData = [
            'status' => self::$config['status_error'] ?? 'error',
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
        ];

        return self::jsonResponse($responseData, $code);
    }

    protected static function jsonResponse(array $data, int $status): PsrResponseInterface
    {
        $response = ApplicationContext::getContainer()->get(ResponseInterface::class);
        return $response->json($data)->withStatus($status);
    }
}