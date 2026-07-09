<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Retry;

use Gonon\Core\Retry\FixedDelayStrategy;
use PHPUnit\Framework\TestCase;

class FixedDelayStrategyTest extends TestCase
{
    public function test_it_returns_fixed_delay(): void
    {
        $strategy = new FixedDelayStrategy(delayMs: 1500);

        $this->assertSame(1500, $strategy->getDelay(1));
        $this->assertSame(1500, $strategy->getDelay(2));
        $this->assertSame(1500, $strategy->getDelay(5));
    }
}
