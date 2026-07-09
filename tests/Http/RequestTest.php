<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Http;

use Gonon\Core\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function test_it_creates_request(): void
    {
        $request = new Request('GET', 'https://example.com', ['Accept' => ['application/json']], 'body');

        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('https://example.com', $request->getUri());
        $this->assertSame(['Accept' => ['application/json']], $request->getHeaders());
        $this->assertSame('body', $request->getBody());
    }

    public function test_it_adds_header_immutably(): void
    {
        $request = new Request('GET', 'https://example.com');
        $newRequest = $request->withHeader('Accept', 'application/json');

        $this->assertNotSame($request, $newRequest);
        $this->assertSame([], $request->getHeaders());
        $this->assertSame(['Accept' => ['application/json']], $newRequest->getHeaders());

        $newRequest2 = $newRequest->withHeader('Accept', 'text/html');
        $this->assertSame(['Accept' => ['application/json', 'text/html']], $newRequest2->getHeaders());
    }
}
