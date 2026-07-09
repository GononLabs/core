<?php

declare(strict_types=1);

namespace Gonon\Core\Testing;

use Gonon\Core\Contracts\RequestInterface;

class RequestRecorder
{
    /**
     * @var array<int, RequestInterface>
     */
    private array $requests = [];

    public function record(RequestInterface $request): void
    {
        $this->requests[] = $request;
    }

    /**
     * @return array<int, RequestInterface>
     */
    public function all(): array
    {
        return $this->requests;
    }

    public function first(): ?RequestInterface
    {
        return $this->requests[0] ?? null;
    }

    public function last(): ?RequestInterface
    {
        $count = count($this->requests);

        return $count > 0 ? $this->requests[$count - 1] : null;
    }

    public function count(): int
    {
        return count($this->requests);
    }
}
