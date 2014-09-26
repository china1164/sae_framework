<?php

namespace shengshiwulian;

class Session {

    /**
     * 开启session
     */
    public static function session_open() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * 判断session是否存在
     * @param type $key
     * @return type
     */
    public static function is_exist($key) {
        return isset($_SESSION[trim($key)]);
    }

    /**
     * set session
     * @param type $key
     * @param type $val
     * @return type
     */
    public static function set($key, $val = null) {
        return ($_SESSION[trim($key)] = $val);
    }

    /**
     * get session
     * @param type $key
     * @return type
     */
    public static function get($key) {
        return static::is_exist($key) ? $_SESSION[trim($key)] : null;
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
     * 销毁session
     * @param type $key
     * @return type
     */
    public static function clear($key) {
        return uset($_SESSION[trim($key)]);
    }

}
