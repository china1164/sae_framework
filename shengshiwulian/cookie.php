<?php

namespace shengshiwulian;

class Cookie {

    /**
     * 验证cookie是否存在
     * @param type $key
     * @return type
     */
    public static function is_exist($key) {
        return static::filter_cookie($key) ? true : false;
    }

    /**
     * 获取cookie值
     * @param type $key
     * @return type
     */
    public static function filter_cookie($key) {
        return filter_input(INPUT_COOKIE, $key);
    }

    /**
     * set cookie
     * @param type $name
     * @param type $val
     * @param type $expire
     * @param type $path
     * @param type $domain
     * @return type
     */
    public static function set($name, $val, $expire = 0, $path = '/', $domain = null) {
        return setcookie($name, $val, $expire, $path, $domain);
    }

    /**
     * get cookie
     * @param type $name
     * @return type
     */
    public static function get($name) {
        return static::filter_cookie($key);
    }

    /**
     * 批量设置
     * @param type $array
     * @return boolean
     */
    public static function batch($array = array()) {
        if (!count($array)) {
            return true;
        }
        foreach ($array as $name => $val) {
            static::set($name, $val);
        }
        return true;
    }

    /**
     * 清除cookie
     * @param type $name
     * @return type
     */
    public static function clear($name) {
        return setcookie($name, NULL, time() - 3600);
    }

}
