<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use Gonon\Core\Exceptions\NetworkException;
use Gonon\Core\Http\Request;
use Gonon\Core\Testing\FakeHttpClient;
use Gonon\Core\Testing\ResponseFactory;

// 1. Setup the Fake HTTP Client
$client = new FakeHttpClient();

// 2. Queue multiple mock responses
$client->queueResponse(ResponseFactory::create(201, [], '{"status": "created"}'));
$client->queueException(new NetworkException('Connection timeout'));

// 3. First request -> returns the 201 response
$request1 = new Request('POST', '/api/users');
$response = $client->sendRequest($request1);

echo 'First request status: '.$response->getStatusCode().PHP_EOL;
echo 'First request body: '.$response->getBody().PHP_EOL;

// 4. Second request -> throws the queued exception
$request2 = new Request('GET', '/api/users/1');
try {
    $client->sendRequest($request2);
} catch (NetworkException $e) {
    echo 'Second request caught exception: '.$e->getMessage().PHP_EOL;
}

// 5. Assert the requests using the recorder
$recorder = $client->getRecorder();

echo 'Total requests made: '.$recorder->count().PHP_EOL;
echo 'First request URI: '.$recorder->first()->getUri().PHP_EOL;
echo 'Last request URI: '.$recorder->last()->getUri().PHP_EOL;
