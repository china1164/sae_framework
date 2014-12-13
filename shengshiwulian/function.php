<?php

function __autoload($classname) {
    if (file_exists(($file = APP_BASE_PATH . '/' . str_replace('\\', '/', strtolower($classname)) . EXT))) {
        require_once $file;
    }
    if (file_exists(($file = APP_BASE_PATH . '/application/controller/' . strtolower($classname) . EXT))) {
        require_once $file;
    }
    if (file_exists(($file = APP_BASE_PATH . '/application/model/' . strtolower($classname) . EXT))) {
        require_once $file;
    }
}

function get($param = null, $default = null) {
    return !isset($_GET[$param]) ? $default : trim($_GET[$param]);
}

function post($param = null, $default = null) {
    return !isset($_GET[$param]) ? $default : trim($_POST[$param]);
}

function gets() {
    return $_GET;
}

function dd($str) {
    print_r($str);
    die();
}

function db($config = array()) {
    return new \shengshiwulian\database\Mysql($config);
}

function arr_select($mark, $string, $index) {
    $arr = explode($mark, $string);
    return $arr[$index];
}
