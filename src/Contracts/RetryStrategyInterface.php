<?php

declare(strict_types=1);

namespace Gonon\Core\Contracts;

interface RetryStrategyInterface
{
    public function shouldRetry(int $attempts, ?ResponseInterface $response, ?\Throwable $exception = null): bool;

    public function getDelay(int $attempts): int;
}
