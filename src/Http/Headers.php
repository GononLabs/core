<?php

declare(strict_types=1);

namespace Gonon\Core\Http;

final readonly class Headers
{
    /**
     * @param  array<string, array<int, string>>  $headers
     */
    public function __construct(
        private array $headers = [],
    ) {}

    /**
     * @return array<string, array<int, string>>
     */
    public function all(): array
    {
        return $this->headers;
    }

    /**
     * @return array<int, string>
     */
    public function get(string $name): array
    {
        $name = strtolower($name);

        foreach ($this->headers as $key => $values) {
            if (strtolower($key) === $name) {
                return $values;
            }
        }

        return [];
    }

    public function getFirst(string $name): ?string
    {
        $values = $this->get($name);

        return $values[0] ?? null;
    }
}
