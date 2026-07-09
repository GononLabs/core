<?php

declare(strict_types=1);

namespace Gonon\Core\Contracts;

interface AuthenticatorInterface
{
    public function authenticate(RequestInterface $request): RequestInterface;
}
