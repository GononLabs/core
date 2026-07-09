<?php

declare(strict_types=1);

namespace Gonon\Core\Configuration;

use Gonon\Core\Contracts\ConfigInterface;
use Psr\Log\LoggerInterface;

final readonly class Config implements ConfigInterface
{
    public function __construct(
        private Environment $environment = Environment::Production,
        private ?string $baseUrl = null,
        private int $timeout = 30,
        private ?LoggerInterface $logger = null,
    ) {}

    public function getEnvironment(): string
    {
        return $this->environment->value;
    }

    public function getBaseUrl(): ?string
    {
        return $this->baseUrl;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }
}
