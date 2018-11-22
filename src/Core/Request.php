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
     * @return Request
     */
    public static function createFromGlobals(): Request
    {
        $request = new self();

        $request->method = $_SERVER['REQUEST_METHOD'];
        $request->uri = $_SERVER['REQUEST_URI'];

        $queryString = $_SERVER['QUERY_STRING'];
        parse_str($queryString, $request->queryParams);

        if ($request->method == 'POST' || $request->method == 'PUT') {
            $content = file_get_contents('php://input');
            $request->body = $content;
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
     * @return string
     */
    public function getRequestUri()
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
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
}