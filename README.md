# Gonon Core

[![Build](https://img.shields.io/github/actions/workflow/status/GononLabs/core/ci.yml?branch=main)](https://github.com/GononLabs/core/actions)
[![Coverage](https://img.shields.io/codecov/c/github/GononLabs/core)](https://codecov.io/gh/GononLabs/core)
[![PHP Version](https://img.shields.io/packagist/php-v/gonon/core)](https://packagist.org/packages/gonon/core)
[![License](https://img.shields.io/packagist/l/gonon/core)](https://packagist.org/packages/gonon/core)
[![Latest Version](https://img.shields.io/packagist/v/gonon/core)](https://packagist.org/packages/gonon/core)
[![Downloads](https://img.shields.io/packagist/dt/gonon/core)](https://packagist.org/packages/gonon/core)

## Introduction

Gonon Core is the foundation package for the entire Gonon ecosystem. It provides reusable, vendor-agnostic, and framework-agnostic infrastructure shared by every Gonon SDK.

## Features

- HTTP Abstraction via PSR interfaces
- Configuration management
- Unified Exception hierarchy
- Retry mechanisms (Exponential Backoff, Fixed Delay)
- Collections and DTO foundations
- Authentication contracts
- Testing utilities

## Requirements

- PHP 8.2 or higher

## Installation

You can install the package via composer:

```bash
composer require gonon/core
```

## Configuration

Gonon Core uses immutable configuration objects.

```php
use Gonon\Core\Configuration\Config;
use Gonon\Core\Configuration\Environment;

$config = new Config(
    environment: Environment::Production,
    timeout: 30,
);
```

## Quick Start

Core is primarily used by SDKs to build robust HTTP integrations.

```php
// 1. Choose your transport adapter (e.g. from gonon/http-symfony)
$adapter = new \Gonon\Http\Symfony\SymfonyHttpClient();

// 2. (Optional) Configure a retry strategy
$retry = new \Gonon\Core\Retry\ExponentialBackoffStrategy(maxAttempts: 3, baseDelayMs: 500);

// 3. Initialize the Orchestrator
$client = new \Gonon\Core\Http\Client(
    adapter: $adapter,
    retryStrategy: $retry,
    defaultHeaders: ['User-Agent' => 'Gonon-SDK/1.0']
);

// 4. Send Request (Middlewares, Retries, and Logging run automatically!)
$response = $client->sendRequest($request);
```

## Examples

Check the `examples/` directory for full usage examples.

## API Reference

The full API reference is available within the source code via PHPDoc annotations.

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
