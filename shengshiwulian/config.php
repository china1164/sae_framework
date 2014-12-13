<?php

namespace shengshiwulian;

class Config {

    public static $set = array();

    /**
     * 查询配置存在
     * @param type $key
     * @return type
     */
    public static function has($key) {
        return !is_null(static::get($key));
    }

    /**
     * 获取配置
     * @return \static
     */
    public static function get($key) {
        return static::parse(static::load(static::path($key)), $key);
    }

    /**
     * 获取加载路径
     * @param type $config
     */
    public static function path($key) {
        if (strpos($key, ':') !== false) {
            $arr1 = explode(':', $key);
            $arr2 = explode('.', $arr1[1]);
            return dirname(dirname(__FILE__)) . "/application/config/{$arr1[0]}/{$arr2[0]}" . EXT;
        }
        $arr = explode('.', $key);
        return dirname(dirname(__FILE__)) . "/application/config/{$arr[0]}" . EXT;
    }

    /**
     * 解析配置
     */
    public static function parse($conf, $key) {
        $handle = explode('.', $key);
        foreach ($handle as $key => $val) {
            if ($key == 0) {
                continue;
            }
            $conf = &$conf[$val];
        }
        return $conf;
    }

    /**
     * 加载配置
     * @param type $path
     * @return type
     */
    public static function load($path) {
        if (!isset(static::$set[$path])) {
            static::$set[$path] = require_once $path;
        }
        return static::$set[$path];
    }

}
