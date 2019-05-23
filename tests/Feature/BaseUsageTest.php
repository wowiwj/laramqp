<?php

namespace Laramqp\Tests\Feature;

use Laramqp\Amq;
use Laramqp\Tests\TestCase;
use PhpAmqpLib\Message\AMQPMessage;

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

        $amq->listen('test_key', function (AMQPMessage $message) {
            print_r($message->getBody());
            return true;
        });
    }
}