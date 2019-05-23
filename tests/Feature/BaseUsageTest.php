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

    /**
     * test base consumer
     * @author wangju 19-5-23 上午11:54
     */
    public function test_base_consume()
    {

        $config = require_once '../../config/amqp.php';
        $amq = new Amq($config);

        $amq->listen('test_key', function (AMQPMessage $message) {
            echo $message->getBody();
            return true;
        });
    }

    /**
     * test base set
     * @author wangju 19-5-23 上午11:54
     */
    public function test_base_set()
    {
        $config = require_once '../../config/amqp.php';
        $amq = new Amq($config);

        $amq->add('test_key', [
            'message' => 'sdsd',
            'name'    => 1213
        ], [
            'content_type' => "text/json"
        ]);
        $this->assertTrue(true);
    }
}