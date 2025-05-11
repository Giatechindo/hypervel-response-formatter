<?php

namespace Giatechindo\HypervelResponseFormatter\Tests;

use PHPUnit\Framework\TestCase;
use Giatechindo\HypervelResponseFormatter\ResponseFormatter;

class ResponseFormatterTest extends TestCase
{
    public function testSuccessResponse()
    {
        ResponseFormatter::init(['status_success' => 'ok']);
        $response = ResponseFormatter::success(['id' => 1], 'Data retrieved', 200);

        $this->assertEquals([
            'status' => 'ok',
            'code' => 200,
            'message' => 'Data retrieved',
            'data' => ['id' => 1],
        ], $response);
    }

    public function testErrorResponse()
    {
        ResponseFormatter::init(['status_error' => 'fail']);
        $response = ResponseFormatter::error('Invalid input', 400, ['field' => 'required']);

        $this->assertEquals([
            'status' => 'fail',
            'code' => 400,
            'message' => 'Invalid input',
            'errors' => ['field' => 'required'],
        ], $response);
    }
}