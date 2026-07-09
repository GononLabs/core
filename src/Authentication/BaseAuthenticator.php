<?php

declare(strict_types=1);

namespace Gonon\Core\Authentication;

use Gonon\Core\Contracts\AuthenticatorInterface;
use Gonon\Core\Contracts\RequestInterface;

abstract readonly class BaseAuthenticator implements AuthenticatorInterface
{
    abstract public function authenticate(RequestInterface $request): RequestInterface;
}
