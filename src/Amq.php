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
        $connect = Connection::connect($key, $this->config);
        echo "dsdsd";
        //
    }
}