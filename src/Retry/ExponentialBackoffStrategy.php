<?php

declare(strict_types=1);

namespace Gonon\Core\Retry;

final readonly class ExponentialBackoffStrategy extends RetryStrategy
{
    /**
     * @param  array<int>  $retryableStatusCodes
     */
    public function __construct(
        int $maxAttempts = 3,
        array $retryableStatusCodes = [429, 500, 502, 503, 504],
        private int $baseDelayMs = 1000,
        private int $maxDelayMs = 30000,
    ) {
        parent::__construct($maxAttempts, $retryableStatusCodes);
    }

    public function getDelay(int $attempts): int
    {
        $delay = $this->baseDelayMs * (2 ** ($attempts - 1));

        return min($delay, $this->maxDelayMs);
    }
}
