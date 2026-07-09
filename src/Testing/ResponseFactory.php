<?php

declare(strict_types=1);

namespace Gonon\Core\Testing;

use Gonon\Core\Contracts\ResponseInterface;
use Gonon\Core\Http\Response;

class ResponseFactory
{
    /**
     * @param  array<string, array<int, string>>  $headers
     */
    public static function create(int $statusCode = 200, array $headers = [], string $body = ''): ResponseInterface
    {
        return new Response($statusCode, $headers, $body);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, array<int, string>>  $headers
     */
    public static function json(array $data, int $statusCode = 200, array $headers = []): ResponseInterface
    {
        $headers['Content-Type'] = ['application/json'];

        return self::create($statusCode, $headers, json_encode($data, JSON_THROW_ON_ERROR));
    }
}
