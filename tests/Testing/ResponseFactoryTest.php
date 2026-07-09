<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Testing;

use Gonon\Core\Testing\ResponseFactory;
use PHPUnit\Framework\TestCase;

class ResponseFactoryTest extends TestCase
{
    public function test_create(): void
    {
        $response = ResponseFactory::create(201, ['X-Test' => ['value']], 'body');

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame(['X-Test' => ['value']], $response->getHeaders());
        $this->assertSame('body', $response->getBody());
    }

    public function test_json(): void
    {
        $response = ResponseFactory::json(['id' => 1], 200, ['X-Test' => ['value']]);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'X-Test' => ['value'],
            'Content-Type' => ['application/json'],
        ], $response->getHeaders());
        $this->assertSame('{"id":1}', $response->getBody());
    }
}
