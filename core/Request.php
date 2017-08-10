<?php

namespace Core;


class Request
{
    private $REQUEST;
    private $SERVER;
    private $INPUT_DATA;

    public function __construct()
    {
        $this->REQUEST = $_REQUEST;
        $this->SERVER = $_SERVER;
        $inputData = file_get_contents('php://input');
        $this->INPUT_DATA = json_decode($inputData , true);
    }


    public function getRequestData()
    {
        return $this->REQUEST;
    }

    public function getInputData()
    {
        return $this->INPUT_DATA;
    }


    public function get($key)
    {
        return ($this->has($key)) ? $this->REQUEST[$key] : null;
    }

    public function input($key)
    {
        return (isset($this->INPUT_DATA[$key])) ? $this->INPUT_DATA[$key] : null;
    }

    public function isPost()
    {
        return $this->SERVER['REQUEST_METHOD'] === "POST";
    }

    public function isGet()
    {
        return $this->SERVER['REQUEST_METHOD'] === "GET";
    }

    public function isPut()
    {
        return $this->SERVER['REQUEST_METHOD'] === "PUT";
    }

    public function isDelete()
    {
        return $this->SERVER['REQUEST_METHOD'] === "DELETE";
    }

    public function method()
    {
        return $this->SERVER['REQUEST_METHOD'];
    }


    public function has($key)
    {
        return isset($this->REQUEST[$key]);
    }


}