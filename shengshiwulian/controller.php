<?php

namespace shengshiwulian;

class Controller {

    public $assign = array();

    /**
     * 加载模板
     * @param type $data
     * @return type
     */
    public function display() {
        return \shengshiwulian\View::display("{$this->name_controller()}.{$this->name_action()}", $this->assign);
    }

    /**
     * controller名称
     */
    public function name_controller() {
        return strtolower(arr_select('_', get_class($this), 0));
    }

    /**
     * action名称
     * @return type
     */
    public function name_action() {
        $method = get_class_methods($this);
        return strtolower(arr_select('_', $method[0], 1));
    }

    /**
     * __call
     * @param type $name
     * @param type $arguments
     */
    public function __call($name, $arguments) {
        \shengshiwulian\Error::show('不存在的控制器', __FILE__);
    }

}

?>