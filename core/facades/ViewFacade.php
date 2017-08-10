<?php

namespace Core\Facades;

use Core\Mvc\View;

class ViewFacade
{
    public static function __callStatic($method, $args)
    {
        $instance = new View();
        return $instance->$method(...$args);
    }
}