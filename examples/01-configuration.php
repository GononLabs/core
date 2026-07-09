<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use Gonon\Core\Configuration\Config;
use Gonon\Core\Configuration\Environment;

// Create an immutable Config instance
$config = new Config(
    environment: Environment::Production,
    baseUrl: 'https://api.example.com/v1',
    timeout: 30,
);

echo 'Environment: '.$config->getEnvironment().PHP_EOL;
echo 'Base URL: '.$config->getBaseUrl().PHP_EOL;
echo 'Timeout: '.$config->getTimeout().' seconds'.PHP_EOL;
