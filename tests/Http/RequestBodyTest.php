<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Http;

use Gonon\Core\Http\RequestBody;
use PHPUnit\Framework\TestCase;

class RequestBodyTest extends TestCase
{
    public function test_it_stores_body(): void
    {
        $body = new RequestBody('content');
        $this->assertSame('content', $body->getContents());

        $empty = new RequestBody();
        $this->assertNull($empty->getContents());
    }
}
