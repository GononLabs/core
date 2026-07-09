<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use Gonon\Core\Http\Client;
use Gonon\Core\Http\Request;
use Gonon\Core\Testing\FakeHttpClient;
use Gonon\Core\Testing\ResponseFactory;

// 1. Create your transport adapter
// For this example, we use the FakeHttpClient which implements HttpClientInterface.
// In a real SDK, you would use an external adapter like \Gonon\Http\Symfony\SymfonyHttpClient
$adapter = new FakeHttpClient();

// 2. Initialize the Orchestrator
$httpClient = new Client(adapter: $adapter);

// Queue a fake successful response
$adapter->queueResponse(ResponseFactory::json([
    'status' => 'success',
    'data' => [
        'id' => 123,
        'message' => 'Hello World',
    ],
], 200));

// Create an immutable Request object
$request = new Request(
    method: 'POST',
    uri: 'https://api.example.com/messages',
    headers: [
        'Accept' => ['application/json'],
        'Authorization' => ['Bearer secret-token'],
    ],
    body: json_encode(['text' => 'Hello'])
);

// Add a header immutably
$request = $request->withHeader('X-Custom-Header', 'CustomValue');

// Send the request
$response = $httpClient->sendRequest($request);

echo 'Status Code: '.$response->getStatusCode().PHP_EOL;
echo 'Response Body: '.$response->getBody().PHP_EOL;
