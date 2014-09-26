<?php

namespace shengshiwulian;

class View {

    public $view;
    public $data = array();
    public $content;

    /**
     * 构造函数
     * @param type $view
     * @param type $data
     */
    public function __construct($view, $data = array()) {
        $this->view = $view;
        $this->data = $data;
        if ($this->file_exists() == false) {
            \shengshiwulian\Error::show('模板不存在', $this->view);
        }
        $this->content = file_get_contents($this->file_path());
    }

    /**
     * 创建模板对象
     * @param type $view
     * @param type $data
     */
    public static function make($view, $data = array()) {
        return new static($view, $data);
    }

    /**
     * 模板路径
     */
    public function file_path() {
        return APP_BASE_PATH . '/application/view/' . str_replace('.', '/', $this->view) . EXT;
    }

    /**
     * 判断文件存在
     * @return boolean
     */
    public function file_exists() {
        return file_exists($this->file_path());
    }

    /**
     * 模板内容
     * @return type
     */
    public function content() {
        return $this->content;
    }

    /**
     * 输出内容
     * @return type
     */
    public function out() {
        return $this->setvar()->content();
    }

    /**
     * 注册变量
     * @return \shengshiwulian\View
     */
    private function setvar() {
        if (count($this->data)) {
            foreach ($this->data as $key => $val) {
                $$key = $val;
            }
        }
        $this->content = eval(' ?>' . $this->content() . '<?php ');
        return $this;
    }

    /**
     * 输出模板
     */
    public static function display($view, $data = array()) {
        return static::make($view, $data)->out();
    }

}
