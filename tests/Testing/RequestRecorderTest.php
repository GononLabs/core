<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Testing;

use Gonon\Core\Http\Request;
use Gonon\Core\Testing\RequestRecorder;
use PHPUnit\Framework\TestCase;

class RequestRecorderTest extends TestCase
{
    public function test_it_records_requests(): void
    {
        $recorder = new RequestRecorder();

        $this->assertNull($recorder->first());
        $this->assertNull($recorder->last());
        $this->assertSame(0, $recorder->count());
        $this->assertSame([], $recorder->all());

        $req1 = new Request('GET', '/1');
        $req2 = new Request('GET', '/2');

        $recorder->record($req1);
        $recorder->record($req2);

        $this->assertSame(2, $recorder->count());
        $this->assertSame([$req1, $req2], $recorder->all());
        $this->assertSame($req1, $recorder->first());
        $this->assertSame($req2, $recorder->last());
    }
}
