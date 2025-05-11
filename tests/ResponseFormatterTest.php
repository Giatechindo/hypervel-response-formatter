<?php

declare(strict_types=1);

namespace Giatechindo\HypervelResponseFormatter\Tests;

use Giatechindo\HypervelResponseFormatter\ResponseFormatter;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\ApplicationContext;
use PHPUnit\Framework\TestCase;
use Mockery;

class ResponseFormatterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ResponseFormatter::init(['status_success' => 'ok', 'status_error' => 'fail']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testSuccessResponse()
    {
        $mockResponse = Mockery::mock(ResponseInterface::class);
        $mockResponse->shouldReceive('json')
            ->with([
                'status' => 'ok',
                'code' => 200,
                'message' => 'Data retrieved',
                'data' => ['id' => 1],
            ])
            ->andReturnSelf();
        $mockResponse->shouldReceive('withStatus')->with(200)->andReturnSelf();

        $container = Mockery::mock('Hyperf\Contract\ContainerInterface');
        $container->shouldReceive('get')->with(ResponseInterface::class)->andReturn($mockResponse);
        ApplicationContext::setContainer($container);

        $response = ResponseFormatter::success(['id' => 1], 'Data retrieved', 200);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testErrorResponse()
    {
        $mockResponse = Mockery::mock(ResponseInterface::class);
        $mockResponse->shouldReceive('json')
            ->with([
                'status' => 'fail',
                'code' => 400,
                'message' => 'Invalid input',
                'errors' => ['field' => 'required'],
            ])
            ->andReturnSelf();
        $mockResponse->shouldReceive('withStatus')->with(400)->andReturnSelf();

        $container = Mockery::mock('Hyperf\Contract\ContainerInterface');
        $container->shouldReceive('get')->with(ResponseInterface::class)->andReturn($mockResponse);
        ApplicationContext::setContainer($container);

        $response = ResponseFormatter::error('Invalid input', 400, ['field' => 'required']);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}