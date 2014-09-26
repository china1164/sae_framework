<?php

namespace shengshiwulian;

class Request {

    /**
     * 请求方式
     * @return type
     */
    public static function method(){
        if (($method = filter_input(INPUT_SERVER, 'REQUEST_METHOD')) == false) {
            $method = $_SERVER['REQUEST_METHOD'];
        }
        return $method;
    }
}
