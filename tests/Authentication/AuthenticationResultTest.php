<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Authentication;

use Gonon\Core\Authentication\AuthenticationResult;
use PHPUnit\Framework\TestCase;

class AuthenticationResultTest extends TestCase
{
    public function test_success(): void
    {
        $result = new AuthenticationResult(true);
        $this->assertTrue($result->isSuccess());
        $this->assertNull($result->getErrorMessage());
    }

    public function test_failure(): void
    {
        $result = new AuthenticationResult(false, 'Invalid token');
        $this->assertFalse($result->isSuccess());
        $this->assertSame('Invalid token', $result->getErrorMessage());
    }
}
