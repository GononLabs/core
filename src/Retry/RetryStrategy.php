<?php

declare(strict_types=1);

namespace Gonon\Core\Retry;

use Gonon\Core\Contracts\ResponseInterface;
use Gonon\Core\Contracts\RetryStrategyInterface;
use Throwable;

abstract readonly class RetryStrategy implements RetryStrategyInterface
{
    /**
     * @param  array<int>  $retryableStatusCodes
     */
    public function __construct(
        protected int $maxAttempts = 3,
        protected array $retryableStatusCodes = [429, 500, 502, 503, 504],
    ) {}

    public function shouldRetry(int $attempts, ?ResponseInterface $response, ?Throwable $exception = null): bool
    {
        if ($attempts >= $this->maxAttempts) {
            return false;
        }

        if ($exception !== null) {
            return true;
        }

        if ($response !== null) {
            return in_array($response->getStatusCode(), $this->retryableStatusCodes, true);
        }

        return false;
    }
}
