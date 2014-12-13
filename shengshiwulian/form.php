<?php

namespace shengshiwulian;

class Form {

    /**
     * 声明form
     * @param type $method
     * @param type $action
     * @param type $param
     * @return type
     */
    public static function open($method = 'POST', $action = '', $param = array()) {
        $data = array_merge(array("<form", "method={$method}", "action={$action}"), static::param($param), array(">"));
        return implode(' ', $data);
    }

    /**
     * 闭合标签
     * @return string
     */
    public static function close() {
        return '</form>';
    }

    /**
     * input
     * @param type $type
     * @param type $name
     * @param type $param
     * @return type
     */
    public static function input($type, $name, $value = '', $param = array()) {
        $data = array_merge(array("<input", "type=\"{$type}\"", "name=\"{$name}\"", "value=\"{$value}\""), static::param($param), array("/>"));
        return implode(' ', $data);
    }

    /**
     * redio
     * @param type $name
     * @param type $param
     * @return type
     */
    public static function redio($name, $value = '', $param = array()) {
        $data = array_merge(array("<input", "type=\"radio\"", "name=\"{$name}\"", "value=\"{$value}\""), static::param($param), array("/>"));
        return implode(' ', $data);
    }

    /**
     * checkbox
     * @param type $name
     * @param type $value
     * @param type $param
     * @return type
     */
    public static function checkbox($name, $value = '', $param = array()) {
        $data = array_merge(array("<input", "type=\"checkbox\"", "name=\"{$name}\"", "value=\"{$value}\""), static::param($param), array("/>"));
        return implode(' ', $data);
    }

    /**
     * hidden
     * @param type $name
     * @param type $value
     * @param type $param
     * @return type
     */
    public static function hidden($name, $value = '', $param = array()) {
        return static::input('hidden', $name, $value = '', $param);
    }

    /**
     * select
     * @param type $name
     * @param type $option
     * @param type $select
     * @param type $param
     * @return type
     */
    public static function select($name, $option = array(), $select = '', $param = array()) {
        $data = array("<select name=\"{$name}\"");
        if (count($param)) {
            foreach ($param as $key => $val) {
                array_push($data, "{$key}=\"{$val}\"");
            }
        }
        array_push($data, ">\n");
        $line = implode(' ', $data);
        if (count($option)) {
            foreach ($option as $name => $val) {
                if ($val == $select) {
                    $line .= "<option value=\"{$val}\" selected=\"selected\">{$name}</option>\n";
                } else {
                    $line .= "<option value=\"{$val}\">{$name}</option>\n";
                }
            }
        }
        return ($line .= "</select>\n");
    }
    
    /**
     * button
     * @param type $name
     * @param type $value
     * @param type $param
     * @return type
     */
    public static function button($name, $value='', $param=array()){
        return static::input('button', $name, $value, $param);
    }

    /**
     * 拼接字符串
     * @param type $param
     * @return array
     */
    public static function param($param = array()) {
        $data = array();
        if (count($param)) {
            foreach ($param as $key => $val) {
                array_push($data, "{$key}=\"{$val}\"");
            }
        }
        return $data;
    }

}
