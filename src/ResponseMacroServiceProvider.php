<?php

namespace Giatechindo\HypervelResponseFormatter;

use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ContainerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Macroable\Macro;

class ResponseMacroServiceProvider
{
    public function __invoke(ContainerInterface $container): void
    {
        $response = $container->get(ResponseInterface::class);
        $formatter = new ResponseFormatter($response);

        Macro::mixin($response, new class($formatter) {
            public function __construct(private ResponseFormatter $formatter) {}

            public function success(): callable
            {
                return fn (mixed $data = null, string $message = 'Success', int $statusCode = 200) => 
                    $this->formatter->success($data, $message, $statusCode);
            }

            public function error(): callable
            {
                return fn (string $message = 'Error', mixed $errors = null, int $statusCode = 400) => 
                    $this->formatter->error($message, $errors, $statusCode);
            }
        });
    }
}