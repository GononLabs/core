<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Exceptions;

use Gonon\Core\Exceptions\AuthenticationException;
use Gonon\Core\Exceptions\ConfigException;
use Gonon\Core\Exceptions\HttpException;
use Gonon\Core\Exceptions\NetworkException;
use Gonon\Core\Exceptions\RateLimitException;
use Gonon\Core\Exceptions\RuntimeException;
use Gonon\Core\Exceptions\SerializationException;
use Gonon\Core\Exceptions\ValidationException;
use Gonon\Core\Http\Request;
use Gonon\Core\Http\Response;
use PHPUnit\Framework\TestCase;

class ExceptionsTest extends TestCase
{
    public function test_http_exception_stores_request_response(): void
    {
        $request = new Request('GET', '/');
        $response = new Response(404);

        $exception = new HttpException('Not found', $request, $response);

        $this->assertSame('Not found', $exception->getMessage());
        $this->assertSame(404, $exception->getCode());
        $this->assertSame($request, $exception->getRequest());
        $this->assertSame($response, $exception->getResponse());

        $baseException = new HttpException('Base', null, null);
        $this->assertNull($baseException->getRequest());
        $this->assertNull($baseException->getResponse());
        $this->assertSame(0, $baseException->getCode());
    }

    public function test_all_exceptions_instantiate(): void
    {
        $this->assertInstanceOf(\Exception::class, new RuntimeException());
        $this->assertInstanceOf(RuntimeException::class, new ConfigException());
        $this->assertInstanceOf(HttpException::class, new AuthenticationException(''));
        $this->assertInstanceOf(HttpException::class, new ValidationException(''));
        $this->assertInstanceOf(HttpException::class, new NetworkException(''));
        $this->assertInstanceOf(HttpException::class, new RateLimitException(''));
        $this->assertInstanceOf(HttpException::class, new SerializationException(''));
    }
}
