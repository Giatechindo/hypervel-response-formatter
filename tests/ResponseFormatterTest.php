<?php

namespace Giatechindo\HypervelResponseFormatter\Tests;

use Giatechindo\HypervelResponseFormatter\ResponseFormatter;
use Hyperf\HttpServer\Contract\ResponseInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class ResponseFormatterTest extends TestCase
{
    public function testSuccessResponse()
    {
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockPsrResponse = $this->createMock(PsrResponseInterface::class);

        $expectedResponse = [
            'success' => true,
            'message' => 'Test success',
            'data' => ['key' => 'value'],
        ];

        $mockResponse->expects($this->once())
            ->method('json')
            ->with($expectedResponse)
            ->willReturn($mockPsrResponse);

        $mockPsrResponse->expects($this->once())
            ->method('withStatus')
            ->with(200)
            ->willReturnSelf();

        $formatter = new ResponseFormatter($mockResponse);
        $result = $formatter->success(['key' => 'value'], 'Test success');

        $this->assertInstanceOf(PsrResponseInterface::class, $result);
    }

    public function testErrorResponse()
    {
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockPsrResponse = $this->createMock(PsrResponseInterface::class);

        $expectedResponse = [
            'success' => false,
            'message' => 'Test error',
            'errors' => ['field' => 'Error message'],
        ];

        $mockResponse->expects($this->once())
            ->method('json')
            ->with($expectedResponse)
            ->willReturn($mockPsrResponse);

        $mockPsrResponse->expects($this->once())
            ->method('withStatus')
            ->with(400)
            ->willReturnSelf();

        $formatter = new ResponseFormatter($mockResponse);
        $result = $formatter->error('Test error', ['field' => 'Error message']);

        $this->assertInstanceOf(PsrResponseInterface::class, $result);
    }

    public function testErrorResponseWithoutErrors()
    {
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockPsrResponse = $this->createMock(PsrResponseInterface::class);
    
        $mockResponse->expects($this->once())
            ->method('json')
            ->with([
                'success' => false,
                'message' => 'Test error',
            ])
            ->willReturn($mockPsrResponse);
    
        $mockPsrResponse->expects($this->once())
            ->method('withStatus')
            ->with(400)
            ->willReturnSelf();
    
        $formatter = new ResponseFormatter($mockResponse);
        $result = $formatter->error('Test error');
    
        $this->assertInstanceOf(PsrResponseInterface::class, $result);
        $this->assertSame($mockPsrResponse, $result);
    }
}