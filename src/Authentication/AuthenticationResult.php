<?php

declare(strict_types=1);

namespace Gonon\Core\Authentication;

final readonly class AuthenticationResult
{
    public function __construct(
        private bool $success,
        private ?string $errorMessage = null,
    ) {}

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}
