<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Retry;

use Gonon\Core\Http\Response;
use Gonon\Core\Retry\FixedDelayStrategy;
use PHPUnit\Framework\TestCase;

class RetryStrategyTest extends TestCase
{
    public function test_should_retry_logic(): void
    {
        $strategy = new FixedDelayStrategy(maxAttempts: 3, retryableStatusCodes: [500]);

        // Exceeds max attempts
        $this->assertFalse($strategy->shouldRetry(3, null, null));

        // Exception should retry
        $this->assertTrue($strategy->shouldRetry(1, null, new \Exception()));

        // Status code matches
        $this->assertTrue($strategy->shouldRetry(1, new Response(500), null));

        // Status code does not match
        $this->assertFalse($strategy->shouldRetry(1, new Response(400), null));

        // Both null
        $this->assertFalse($strategy->shouldRetry(1, null, null));
    }
}
