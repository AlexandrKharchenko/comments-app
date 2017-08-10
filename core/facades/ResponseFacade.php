<?php


namespace Core\Facades;



use Core\Response;

class ResponseFacade
{

    public static function __callStatic($method, $args)
    {
        $instance = new Response();
        return $instance->$method(...$args);
    }


}