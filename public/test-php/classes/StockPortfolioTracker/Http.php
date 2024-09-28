<?php


namespace StockPortfolioTracker;

class Http
{
    protected $url;
    protected $options;
    protected $response;
    protected $headers = [];

    public function __construct($url, $options = [])
    {
        $this->url = $url;
        $this->options = $options;
    }

    protected function request($method)
    {
        if (function_exists('wp_remote_get')) {
            $options = array_merge(['method' => $method], $this->options);

            if (isset($options['cookies'])) {
                $cookies = [];

                foreach ($options['cookies'] as $name => $value) {
                    $cookies[] = new \WP_Http_Cookie(compact('name', 'value'));
                }

                $options['cookies'] = $cookies;
            }

            $this->response = wp_remote_request($this->url, $options);

            if (is_wp_error($this->response)) {
                Helper::log(sprintf('WP Remote Error: %s', $this->response->get_error_message()));
            }

            return wp_remote_retrieve_body($this->response) ?: NULL;
        } elseif (ini_get('allow_url_fopen')) {
            $header = [];

            if (isset($this->options['headers'])) {
                foreach ($this->options['headers'] as $name => $value) {
                    $header[] = $name . ': ' . $value;
                }
            }

            if (isset($this->options['cookies'])) {
                $cookie = 'Cookie: ';
                foreach ($this->options['cookies'] as $name => $value) {
                    $cookie .= $name . '=' . $value . ';';
                }
                $header[] = $cookie;
            }

            $follow_location = isset($this->options['redirection']) && $this->options['redirection'] > 0 ? TRUE : FALSE;

            $content = NULL;
            if ($method == 'POST' && isset($this->options['body'])) {
                $content = http_build_query($this->options['body']);
            }

            $context = stream_context_create(['http' => compact('method', 'follow_location', 'header', 'content')]);
            $this->response = @file_get_contents($this->url, FALSE, $context);

            if (isset($http_response_header)) {
                $this->headers = $http_response_header;
            }

            return $this->response;
        } else {
            return [
                'error' => 'Please set allow_url_fopen = On in PHP settings.'
            ];
        }
    }

    public function get()
    {
        return $this->request('GET');
    }

    public function post()
    {
        return $this->request('POST');
    }

    public function getHeaders()
    {
        return function_exists('wp_remote_retrieve_headers') ? wp_remote_retrieve_headers($this->response) : $this->headers;
    }

    public function getHeader($name)
    {
        if (function_exists('wp_remote_retrieve_header')) {
            return wp_remote_retrieve_header($this->response, $name) ?: NULL;
        } else {
            foreach ($this->headers as $header) {
                $pos = strpos(strtolower($header), strtolower($name) . ':');
                if ($pos === 0) {
                    return trim(substr($header, strlen($name) + 1));
                }
            }

            return NULL;
        }
    }

    public function getCookie($name)
    {
        if (function_exists('wp_remote_retrieve_cookie_value')) {
            return wp_remote_retrieve_cookie_value($this->response, $name);
        } else {
            $cookieHeaderName = 'set-cookie:';

            foreach ($this->headers as $header) {
                if (strpos(strtolower($header), $cookieHeaderName) === 0) {
                    $cookie = trim(substr($header, strlen($cookieHeaderName) + 1));
                    if (strpos($cookie, $name) === 0) {
                        $length = strlen($name);
                        return trim(substr($cookie, $length + 1, strpos($cookie, ';') - $length - 1));
                    }
                }
            }

            return NULL;
        }
    }
}
