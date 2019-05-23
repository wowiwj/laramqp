<?php

namespace Laramqp;

use Closure;

class Amq
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function listen($key, Closure $callback)
    {
        $keyValue = Parser::getKeyValue($this->config,$key);
        $connect = Connection::connect($this->config,$keyValue);
        $listener = new Listener($connect, $keyValue);
        $listener->listen($callback);
    }
}