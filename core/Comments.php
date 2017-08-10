<?php

namespace Core;

use Core\Router;
use Core\Support\Config;

class Comments
{
    /**
     * @var
     */
    protected static $instance;

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Fm constructor.
     */
    protected function __construct()
    {

    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     *
     */
    private function __wakeup()
    {
    }

    public static function run(){

        # Load user config
        Config::loadConfig();

        # Run router
        Router::getInstance()->_loadUserRoutes();
        Router::getInstance()->parse();

    }

}