<?php

namespace shengshiwulian;

class Model {

    public static $table;
    public static $key;

    public function __construct() {
        
    }

    /**
     * 获取表名
     * @return type
     */
    public function table_get() {
        return !static::$table ? \shengshiwulian\Error::show('模型缺少静态属性table', __FILE__) : static::$table;
    }

    /**
     * 获取主键
     * @return type
     */
    public function key_get() {
        return !static::$key ? \shengshiwulian\Error::show('模型缺少静态属性key', __FILE__) : static::$key;
    }

    /**
     * attribute_set
     * @param type $data
     * @return \static
     */
    public function attribute_set($data) {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        $std = new static();
        if (is_array($data) && count($data)) {
            foreach ($data as $key => $val) {
                $std->{$key} = $val;
            }
        }
        return $std;
    }

    /**
     * confident
     * @param type $attribute
     * @return type
     */
    public function confident($attribute = array()) {
        if (!count($attribute)) {
            return $this;
        }
        foreach ($attribute as $key => $val) {
            if ($key == static::key_get()) {
                continue;
            }
            $this->{$key} = $val;
        }
        return $this;
    }

    /**
     * __call
     * @param type $name
     * @param type $arguments
     * @return type
     */
    public function __call($name, $arguments) {
        $instance = \shengshiwulian\database\Mysql::getinstance(new static());
        switch ($name) {
            case 'save':
                return $instance->save($this);
            case 'confident':
                return $instance->confident($this);
            default :
                return static::__callStatic($name, $arguments);
        }
        return $instance;
    }

    /**
     * __callStatic
     * @param type $name
     * @param type $arguments
     * @return type
     */
    public static function __callStatic($name, $arguments = array()) {
        $instance = \shengshiwulian\database\Mysql::getinstance(new static());
        switch ($name) {
            case 'where':
                return $instance->where(current($arguments));
            case 'select':
                return $instance->select($arguments);
            case 'count':
                return $instance->count($arguments);
            case 'order_by':
                return $instance->order_by(current($arguments));
            case 'limit':
                return $instance->limit(current($arguments));
            case 'one':
                return $instance->one($arguments);
            case 'find':
                return $instance->find(current($arguments));
            case 'insert':
                return $instance->insert(current($arguments));
            case 'create':
                return $instance->create(current($arguments));
            case 'update':
                return $instance->update(current($arguments));
            case 'affected_rows':
                return $instance->affected_rows();
            case 'delete':
                return $instance->delete();
            case 'debug':
                return $instance->debug();
        }
        return $instance;
    }

}
