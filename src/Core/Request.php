<?php

namespace App\Core;

class Request
{
    /**
     * @var array
     */
    protected $queryParams = [];

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $routePath;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $post = [];

    /**
     * @return Request
     */
    public static function createFromGlobals(): Request
    {
        $request = new self();

        $request->method = $_SERVER['REQUEST_METHOD'];
        $request->uri = $_SERVER['REQUEST_URI'];
        $request->routePath = self::extractRoutePathFromUri($_SERVER['REQUEST_URI']);

        $queryString = $_SERVER['QUERY_STRING'];
        parse_str($queryString, $request->queryParams);

        if ($request->method == 'POST' || $request->method == 'PUT') {
            $content = file_get_contents('php://input');
            $request->body = $content;
            parse_str($content, $request->post);
        }

        return $request;
    }

    /**
     * @param $key
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return array_key_exists($key, $this->queryParams) ? $this->queryParams[$key] : null;
    }

    /**
     * @param string $key
     * @return null|string
     */
    public function post(string $key): ?string
    {
        return array_key_exists($key, $this->post) ? $this->post[$key] : null;
    }

    /**
     * @return array
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return string
     */
    public function getRequestUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getRoutePath()
    {
        return $this->routePath;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array $paramsArray
     * @return string
     */
    public function getQueryStringFromParams(array $paramsArray): string
    {
        $queryString = '';

        foreach ($paramsArray as $key => $value) {
            if ($queryString) {
                $queryString .= '&';
            }
            $queryString .= $key . '=' . $value;
        }

        return $queryString;
    }

    /**
     * @param string $uri
     * @return string
     */
    public static function extractRoutePathFromUri(string $uri): string
    {
        // Just removing root slash
        $uri = substr($uri, 1);

        if (preg_match('~(.*)\?.*~', $uri, $match)) {
            return $match[1];
        }

        return $uri;
    }
}