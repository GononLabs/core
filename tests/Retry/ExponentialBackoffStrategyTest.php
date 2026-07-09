<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Retry;

use Gonon\Core\Retry\ExponentialBackoffStrategy;
use PHPUnit\Framework\TestCase;

class ExponentialBackoffStrategyTest extends TestCase
{
    public function test_it_calculates_delay(): void
    {
        $strategy = new ExponentialBackoffStrategy(baseDelayMs: 1000, maxDelayMs: 5000);

        $this->assertSame(1000, $strategy->getDelay(1));
        $this->assertSame(2000, $strategy->getDelay(2));
        $this->assertSame(4000, $strategy->getDelay(3));
        $this->assertSame(5000, $strategy->getDelay(4)); // capped at max
    }
}
