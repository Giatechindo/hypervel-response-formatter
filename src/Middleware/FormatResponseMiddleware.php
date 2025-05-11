<?php

declare(strict_types=1);

namespace Giatechindo\HypervelResponseFormatter\Middleware;

use Giatechindo\HypervelResponseFormatter\ResponseFormatter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HyperfResponse;

class FormatResponseMiddleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        // Cek apakah respons sudah dalam format yang diinginkan
        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);

        if (!is_array($data) || !isset($data['status'])) {
            // Jika belum diformat, ubah ke format success
            return ResponseFormatter::success($data ?: [], 'Success', $response->getStatusCode());
        }

        return $response;
    }
}