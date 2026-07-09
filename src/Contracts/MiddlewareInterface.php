<?php

declare(strict_types=1);

namespace Gonon\Core\Contracts;

/**
 * Interface for intercepting and mutating HTTP requests and responses
 * within the Core orchestration pipeline.
 */
interface MiddlewareInterface
{
    /**
     * Handle the request and return a response.
     *
     * @param  RequestInterface  $request  The outgoing HTTP request.
     * @param  callable(RequestInterface): ResponseInterface  $next  The next middleware in the pipeline, or the final transport adapter.
     */
    public function handle(RequestInterface $request, callable $next): ResponseInterface;
}
