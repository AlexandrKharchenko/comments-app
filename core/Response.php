<?php


namespace Core;


class Response
{

    private $content;
    private $statusCode;
    private $statusMessage = [
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        404 => 'Not found',
    ];

    private $defaultHeaders = [
        'json' => 'Content-Type: application/json'
    ];

    private $headers = [];


    /**
     *
     *
     * @param string $content content response
     * @param integer $statusCode HTTP-status code
     * @param array $headers HTTP-headers
     */
    public function __construct($content = '', $statusCode = 200, $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setHeader($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


    public function json($content, $statusCode = 200)
    {
        $this->setHeader($this->defaultHeaders['json'])
            ->setStatusCode($statusCode)
            ->setContent(json_encode($content));

        return $this;
    }

    public function send()
    {
        // Send status http
        $statusMessage = (isset($this->statusMessage[$this->statusCode])) ? $this->statusMessage[$this->statusCode] : '';
        header('HTTP/1.1 ' . $this->statusCode . $statusMessage);

        // send http headers
        foreach ($this->headers as $header)
            header($header);


        // send content
        if(is_array($this->content) || gettype($this->content) === 'object'){
            header($this->defaultHeaders['json']);
            echo json_encode($this->content);
        } else {
            echo $this->content;
        }

        exit;
    }

}