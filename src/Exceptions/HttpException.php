<?php

declare(strict_types=1);

namespace Gonon\Core\Exceptions;

use Gonon\Core\Contracts\RequestInterface;
use Gonon\Core\Contracts\ResponseInterface;

class HttpException extends RuntimeException
{
    public function __construct(
        string $message,
        private readonly ?RequestInterface $request = null,
        private readonly ?ResponseInterface $response = null,
        ?\Throwable $previous = null
    ) {
        $code = $response ? $response->getStatusCode() : 0;
        parent::__construct($message, $code, $previous);
    }

    public function getRequest(): ?RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
