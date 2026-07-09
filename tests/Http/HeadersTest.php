<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Http;

use Gonon\Core\Http\Headers;
use PHPUnit\Framework\TestCase;

class HeadersTest extends TestCase
{
    public function test_it_stores_and_retrieves_headers(): void
    {
        $headers = new Headers([
            'Content-Type' => ['application/json'],
            'Accept' => ['application/json', 'text/html'],
        ]);

        $this->assertSame([
            'Content-Type' => ['application/json'],
            'Accept' => ['application/json', 'text/html'],
        ], $headers->all());

        $this->assertSame(['application/json'], $headers->get('Content-Type'));
        $this->assertSame(['application/json'], $headers->get('content-type')); // Case insensitive
        $this->assertSame('application/json', $headers->getFirst('Accept'));

        $this->assertSame([], $headers->get('Missing'));
        $this->assertNull($headers->getFirst('Missing'));
    }
}
