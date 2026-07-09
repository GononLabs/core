<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Http;

use Gonon\Core\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function test_it_creates_response(): void
    {
        $response = new Response(201, ['Content-Type' => ['application/json']], '{"id":1}');

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame(['Content-Type' => ['application/json']], $response->getHeaders());
        $this->assertSame('{"id":1}', $response->getBody());
    }
}
