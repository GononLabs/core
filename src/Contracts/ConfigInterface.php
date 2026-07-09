<?php

declare(strict_types=1);

namespace Gonon\Core\Contracts;

use Psr\Log\LoggerInterface;

interface ConfigInterface
{
    public function getEnvironment(): string;

    public function getBaseUrl(): ?string;

    public function getTimeout(): int;

    public function getLogger(): ?LoggerInterface;
}
