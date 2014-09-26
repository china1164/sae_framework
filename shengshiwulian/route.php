<?php

namespace shengshiwulian;

class Route {

    public $parse;
    public $scheme;
    public $host;
    public $path = array();
    public $query = array();
    public $string;
    public $controller;
    public $method;

    /**
     * __construct
     * @param string $url
     */
    public function __construct($url) {
        if (strpos($url, '?') !== false) {
            $param = explode('?', $url);
            $this->parse(current($param));
            $this->string($param[1]);
        } else {
            $this->parse($url);
        }
    }

    /**
     * parse
     * @param type $url
     */
    public function parse($url) {
        $this->parse = parse_url($url);
        $this->scheme_set();
        $this->host_set();
        $this->path_set();
        $this->query_set();
        $this->controller_set();
        $this->method_set();
    }

    /**
     * scheme
     * @param type $set
     */
    public function scheme_set() {
        $this->scheme = isset($this->parse['scheme']) ? $this->parse['scheme'] : null;
    }

    /**
     * host
     * @param type $set
     */
    public function host_set() {
        $this->host = isset($this->parse['host']) ? $this->parse['host'] : null;
    }

    /**
     * path
     * @param type $set
     */
    public function path_set() {
        $this->path = isset($this->parse['path']) ? explode('/', $this->parse['path']) : array();
    }

    /**
     * query
     * @param type $set
     */
    public function query_set() {
        $this->query = array();
        if (count($this->path) <= 3) {
            return;
        }
        foreach ($this->path as $key => $val) {
            if ($key <= 2) {
                continue;
            }
            $this->query[] = $val;
        }
    }

    /**
     * get_query
     * @return type
     */
    public function query_get() {
        return $this->query;
    }

    /**
     * string
     * @param type $string
     * @return type
     */
    public function string($string = null) {
        if ($string == null) {
            return;
        }
        $param = $str_arr = array();
        $str_arr = explode('&', $string);
        if (!count($str_arr)) {
            return;
        }
        foreach ($str_arr as $val) {
            $temp = explode('=', $val);
            $param[] = $temp[1];
        }
        $this->query = array_merge($this->query, $param);
    }

    /**
     * controller
     * @return type
     */
    public function controller_set() {
        if (!count($this->path)) {
            return $this->controller = null;
        }
        $this->controller = $this->path[1];
    }

    /**
     * method
     * @return type
     */
    public function method_set() {
        if (!count($this->path)) {
            return $this->method = null;
        }
        $this->method = $this->path[2];
    }

    /**
     * make
     * @return \static
     */
    public static function make($url) {
        return new static($url);
    }

    /**
     * 控制器名
     * @return string
     */
    public function name_controller() {
        return ($this->controller == null ? 'home' : $this->controller) . '_Controller';
    }

    /**
     * action名
     * @return string
     */
    public function name_method() {
        if (!in_array(($method = \shengshiwulian\Request::method()), array('POST', 'GET'))) {
            \shengshiwulian\Error::show('暂不支持的请求', __FILE__);
            return;
        }
        return ($method == 'POST' ? 'post_' : 'get_') . ($this->method == null ? 'index' : $this->method);
    }

}
