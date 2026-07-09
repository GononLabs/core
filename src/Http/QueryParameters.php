<?php

declare(strict_types=1);

namespace Gonon\Core\Http;

final readonly class QueryParameters
{
    /**
     * @param  array<string, string|int|float|bool|null>  $parameters
     */
    public function __construct(
        private array $parameters = [],
    ) {}

    /**
     * @return array<string, string|int|float|bool|null>
     */
    public function all(): array
    {
        return $this->parameters;
    }

    public function get(string $name): string|int|float|bool|null
    {
        return $this->parameters[$name] ?? null;
    }
}
