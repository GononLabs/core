<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Testing;

use Gonon\Core\Http\Request;
use Gonon\Core\Http\Response;
use Gonon\Core\Testing\FakeHttpClient;
use PHPUnit\Framework\TestCase;

class FakeHttpClientTest extends TestCase
{
    public function test_it_returns_queued_responses(): void
    {
        $client = new FakeHttpClient();

        $client->queueResponse(new Response(201))
            ->queueResponse(new Response(404));

        $req1 = new Request('GET', '/1');
        $req2 = new Request('GET', '/2');

        $res1 = $client->sendRequest($req1);
        $res2 = $client->sendRequest($req2);

        $this->assertSame(201, $res1->getStatusCode());
        $this->assertSame(404, $res2->getStatusCode());

        $this->assertCount(2, $client->getRecorder()->all());
        $this->assertSame($req1, $client->getRecorder()->first());
        $this->assertSame($req2, $client->getRecorder()->last());
    }

    public function test_it_returns_default_200_if_empty(): void
    {
        $client = new FakeHttpClient();
        $res = $client->sendRequest(new Request('GET', '/'));

        $this->assertSame(200, $res->getStatusCode());
    }

    public function test_it_throws_queued_exceptions(): void
    {
        $client = new FakeHttpClient();
        $client->queueException(new \RuntimeException('Test error'));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Test error');

        $client->sendRequest(new Request('GET', '/'));
    }
}
