<?php

declare(strict_types=1);

namespace Gonon\Core\Configuration;

enum Environment: string
{
    case Production = 'production';
    case Sandbox = 'sandbox';
    case Testing = 'testing';
}
