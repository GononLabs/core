<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Http;

use Gonon\Core\Http\QueryParameters;
use PHPUnit\Framework\TestCase;

class QueryParametersTest extends TestCase
{
    public function test_it_stores_and_retrieves_query_parameters(): void
    {
        $params = new QueryParameters([
            'page' => 1,
            'search' => 'test',
            'active' => true,
        ]);

        $this->assertSame([
            'page' => 1,
            'search' => 'test',
            'active' => true,
        ], $params->all());

        $this->assertSame(1, $params->get('page'));
        $this->assertNull($params->get('missing'));
    }
}
