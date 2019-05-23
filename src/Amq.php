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
        $listener = new Listener($this->config, $key);
        $listener->listen($callback);
    }

    public function add($key, $message)
    {
        $publisher = new Publisher($this->config, $key);
        return $publisher->add($message);
    }
}