<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Http;

use Gonon\Core\Http\ResponseBody;
use PHPUnit\Framework\TestCase;

class ResponseBodyTest extends TestCase
{
    public function test_it_stores_body(): void
    {
        $body = new ResponseBody('content');
        $this->assertSame('content', $body->getContents());

        $empty = new ResponseBody();
        $this->assertSame('', $empty->getContents());
    }
}
