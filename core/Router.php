<?php


namespace Core;

use Core\Exception\RouterException;
use Core\Facades\ResponseFacade;
use Core\Request;
use Core\Response;


class Router
{

    protected static $instance;

    public $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function resource($name , $controller)
    {
        array_push(self::getInstance()->routes['GET'], [
            'url' => $name . '/index',
            'param' => [
                'action' => $controller. '@index',
                'name' => $name . '.index',
            ]
        ]);

        array_push(self::getInstance()->routes['GET'], [
            'url' => $name . '/create',
            'param' => [
                'action' => $controller. '@create',
                'name' => $name . '.create',
            ]
        ]);

        array_push(self::getInstance()->routes['POST'], [
            'url' => $name . '/store',
            'param' => [
                'action' => $controller. '@store',
                'name' => $name . '.store',
            ]
        ]);

        array_push(self::getInstance()->routes['GET'], [
            'url' => $name . '/edit',
            'param' => [
                'action' => $controller. '@edit',
                'name' => $name . '.edit',
            ]
        ]);

        array_push(self::getInstance()->routes['GET'], [
            'url' => $name . "/edit/{{$name}}",
            'param' => [
                'action' => $controller. '@edit',
                'name' => $name . '.edit',
            ]
        ]);

        array_push(self::getInstance()->routes['PUT'], [
            'url' => $name . "/update/{{$name}}",
            'param' => [
                'action' => $controller. '@update',
                'name' => $name . '.update',
            ]
        ]);

        array_push(self::getInstance()->routes['DELETE'], [
            'url' => $name . "/delete/{{$name}}",
            'param' => [
                'action' => $controller. '@delete',
                'name' => $name . '.delete',
            ]
        ]);



    }

    /**
     * Register GET routes
     * @param       $name
     * @param array $config
     */
    public function get($name, array $config)
    {
        array_push(self::getInstance()->routes['GET'], ['url' => $name, 'param' => $config]);
    }

    /**
     * Register POST routes
     * @param       $name
     * @param array $config
     */
    public function post($name, array $config)
    {
        array_push(self::getInstance()->routes['POST'], ['url' => $name, 'param' => $config]);
    }


    /**
     *  Load user routes
     */
    public function _loadUserRoutes()
    {
        if (file_exists(APP_PATH . '/routes.php')) {
            require_once(APP_PATH . '/routes.php');
        }
    }


    public function parse()
    {
        $request = new Request();
        $urlData = parse_url($_SERVER['REQUEST_URI']);

        $uri = $urlData['path'];


        $clearUri = $this->clearStartEndSlash($uri);



        if(!array_key_exists($request->method() , $this->routes)){
            throw new RouterException("Request method {$request->method()} not supported");
        }

        $routesForMethod = $this->routes[$request->method()];

        // Если 0 маршрутов для метода
        if(!$routesForMethod){
            $this->notFoundRoute($uri);
        }


        $findRoute = false;
        foreach ($this->routes[$request->method()] as $route){
            // Сравнить URI приведенные к одному виду
            if($this->clearStartEndSlash($route['url']) !== $clearUri)
                continue;

            // TODO: Check route valid params
            $findRoute = $route;
            break;
        }

        if(!$findRoute){
            $this->notFoundRoute($uri);
        }

        // Create controller and call method
        $controllerData = explode('@' , $findRoute['param']['action']);
        $controllerNameSpacePath = '\App\Controllers\\' . $controllerData[0];

        // If controller not found
        if (!class_exists($controllerNameSpacePath)) {
            throw  new RouterException("Controller {$controllerData[0]} not found");
        }

        $args = [];
        $controller = new $controllerNameSpacePath;
        $controllerResponse = $controller->{$controllerData[1]}($request , ...$args);

        // If controller return Response object - send to client response
        if($controllerResponse instanceof Response){
            $controllerResponse->send();
            exit;
        }




        // If controller return not Response object, create Response, set status and send to Client
        $response = new Response($controllerResponse);
        $response->send();



    }

    private function notFoundRoute($route) {
        //TODO: If exist 404 file show View
        throw new RouterException("Route {$route} not found");
    }

    private  function clearStartEndSlash($str)
    {
        return preg_replace("/^\\/|\\/?$/i", "", $str);
    }

    public static function getUrlByName($name)
    {
        $routesData = self::getInstance()->routes;
        foreach ($routesData as $route){
            if(empty($route))
                continue;

            foreach ($route as $routeData){
                if(isset($routeData['param']['name']) && $routeData['param']['name'] == $name){
                    return $routeData['url'];
                }


            }

        }

        return NULL;
    }


    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

}