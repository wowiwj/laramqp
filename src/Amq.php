<?php

namespace Laramqp;

use Closure;

class Amq
{

    public function listen($key, Closure $callback)
    {
        dd("listen mq");
    }
}