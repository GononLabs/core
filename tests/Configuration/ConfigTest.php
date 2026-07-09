<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Configuration;

use Gonon\Core\Configuration\Config;
use Gonon\Core\Configuration\Environment;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ConfigTest extends TestCase
{
    public function test_it_creates_config_with_defaults(): void
    {
        $config = new Config();

        $this->assertSame(Environment::Production->value, $config->getEnvironment());
        $this->assertNull($config->getBaseUrl());
        $this->assertSame(30, $config->getTimeout());
        $this->assertNull($config->getLogger());
    }

    public function test_it_creates_config_with_custom_values(): void
    {
        $logger = new NullLogger();
        $config = new Config(
            environment: Environment::Sandbox,
            baseUrl: 'https://api.sandbox.example.com',
            timeout: 10,
            logger: $logger,
        );

        $this->assertSame(Environment::Sandbox->value, $config->getEnvironment());
        $this->assertSame('https://api.sandbox.example.com', $config->getBaseUrl());
        $this->assertSame(10, $config->getTimeout());
        $this->assertSame($logger, $config->getLogger());
    }
}
