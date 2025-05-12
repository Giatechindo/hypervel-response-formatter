<?php
namespace Giatechindo\HypervelResponseFormatter;

use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class ResponseFormatter
{
    public function __construct(protected ResponseInterface $response)
    {}

    public function success(
        mixed $data = null,
        string $message = 'Success',
        int $statusCode = 200
    ): PsrResponseInterface {
        return $this->formatResponse([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }

    public function error(
        string $message = 'Error',
        mixed $errors = null,
        int $statusCode = 400
    ): PsrResponseInterface {
        $response = [
            'success' => false,
            'message' => $message,
        ];
    
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
    
        return $this->formatResponse($response, $statusCode);
    }

    protected function formatResponse(array $response, int $statusCode): PsrResponseInterface
    {
        // Remove null values from response
        $response = array_filter($response, fn($value) => $value !== null);
        return $this->response->json($response)->withStatus($statusCode);
    }
}
