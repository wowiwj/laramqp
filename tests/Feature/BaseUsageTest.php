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
        $config = require_once '../../config/amqp.php';
        $amq = new Amq($config);

        $amq->listen('test_key', function () {
            dump("listen in");
            return true;
        });
    }
}