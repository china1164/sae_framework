<?php

namespace shengshiwulian;

class Iterator implements \Iterator {

    private $attribute = array();

    /**
     * __construct
     */
    public function __construct($iterator) {
        $this->attribute = $this->attribute($iterator);
    }
    
    /**
     * 实例化迭代对象
     * @param type $iterator
     * @return \static
     */
    public static function make($iterator){
        return new static($iterator);
    }

    /**
     * 属性
     * @return type
     */
    public function attribute($iterator) {
        return get_object_vars($iterator);
    }

    /**
     * rewind
     */
    public function rewind() {
        reset($this->attribute);
    }

    /**
     * current
     * @return type
     */
    public function current() {
        return current($this->attribute);
    }

    /**
     * key
     * @return type
     */
    public function key() {
        return key($this->attribute);
    }

    /**
     * next
     * @return type
     */
    public function next() {
        return next($this->attribute);
    }

    /**
     * valid
     * @return type
     */
    public function valid() {
        return ($this->current() !== false);
    }

}
