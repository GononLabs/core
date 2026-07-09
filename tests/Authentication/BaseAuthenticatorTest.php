<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Authentication;

use Gonon\Core\Authentication\BaseAuthenticator;
use Gonon\Core\Contracts\RequestInterface;
use PHPUnit\Framework\TestCase;

readonly class DummyAuthenticator extends BaseAuthenticator
{
    public function authenticate(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Authorization', 'Bearer token');
    }
}

class BaseAuthenticatorTest extends TestCase
{
    public function test_authenticate(): void
    {
        $authenticator = new DummyAuthenticator();
        $request = $this->createMock(RequestInterface::class);

        $request->expects($this->once())
            ->method('withHeader')
            ->with('Authorization', 'Bearer token')
            ->willReturnSelf();

        $result = $authenticator->authenticate($request);
        $this->assertSame($request, $result);
    }
}
