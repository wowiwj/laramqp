<?php

namespace Laramqp\Tests\Feature;

use Laramqp\Amq;
use Laramqp\Tests\TestCase;

class BaseUsageTest extends TestCase
{
    public function test_base_usage()
    {
        $this->assertTrue(true);
    }

    public function test_base_consume()
    {
        $amq = new Amq([
            'host'                => 'localhost',
            'port'                => 5672,
            'username'            => 'guest',
            'password'            => 'guest',
            'vhost'               => '/',
            'ssl_context_options' => null,
            'connection_timeout'  => 3.0,
            'read_write_timeout'  => 3.0,
            'keepalive'           => false,
            'heartbeat'           => 0,
            'exchange'            => 'amq.direct',
            'consumer_tag'        => 'consumer',
            'exchange_type'       => 'direct',
            'content_type'        => 'text/plain',
        ]);

        $amq->listen('test_key', function () {
            dump("listen in");
            return true;
        });
    }
}