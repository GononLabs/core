# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-07-09

### Added
- Initial scaffold of the package.
- Implemented `Configuration` module with immutable `Config` and `Environment` objects.
- Defined all base `Contracts` for the entire Gonon ecosystem.
- Implemented complete `Exceptions` hierarchy aligned with architectural guidelines.
- Created `Http` abstraction layer including `Request`, `Response`, `Headers`.
- Refactored `Client` into a central HTTP Orchestration Engine supporting Middleware pipelines, automated Retries, PSR-3 Logging, and Default Headers.
- Decoupled concrete HTTP clients (Symfony/Guzzle) into external adapter packages (`HttpClientInterface`).
- Decoupled `Client` orchestrator from `ConfigInterface` allowing cleaner instantiation.
- Added foundational classes for `DTO` and `Collections`.
- Built `Serialization` components (`JsonSerializer`, `ArraySerializer`).
- Implemented `Retry` mechanisms (`ExponentialBackoffStrategy`, `FixedDelayStrategy`).
- Created robust `Testing` utilities including `FakeHttpClient`, `MockResponse`, and `RequestRecorder` for SDK testing.
