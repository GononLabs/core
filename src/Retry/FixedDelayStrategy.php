<?php

declare(strict_types=1);

namespace Gonon\Core\Retry;

final readonly class FixedDelayStrategy extends RetryStrategy
{
    /**
     * @param  array<int>  $retryableStatusCodes
     */
    public function __construct(
        int $maxAttempts = 3,
        array $retryableStatusCodes = [429, 500, 502, 503, 504],
        private int $delayMs = 1000,
    ) {
        parent::__construct($maxAttempts, $retryableStatusCodes);
    }

    public function getDelay(int $attempts): int
    {
        return $this->delayMs;
    }
}
