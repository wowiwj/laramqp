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

    /**
     * listen message
     * @param $key
     * @param Closure $callback
     * @param array $options
     * @author wangju 19-5-23 下午3:20
     */
    public function listen($key, Closure $callback, $options = [])
    {
        $listener = new Listener($this->config, $key, $options);
        $listener->listen($callback);
    }

    /**
     * add message
     * @param $key
     * @param $message
     * @param array $options
     * @return bool
     * @throws \Exception
     * @author wangju 19-5-23 下午3:20
     */
    public function add($key, $message, $options = [])
    {
        $publisher = new Publisher($this->config, $key, $options);
        return $publisher->add($message);
    }
}