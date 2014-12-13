<?php

namespace shengshiwulian;

class Application {

    public $route;
    public $controller;
    public $method;

    /**
     * __construct
     * @param array $arguments
     */
    public function __construct(array $arguments = array()) {
        if (!count($arguments)) {
            $this->route = \shengshiwulian\Route::make('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING']);
            $this->controller = $this->route->name_controller();
            $this->method = $this->route->name_method();
        } else {
            $this->controller = $arguments['controller'];
            $this->method = $arguments['method'];
        }
    }

    /**
     * 应用实例
     * @return \static
     */
    public static function start() {
        return new static();
    }

    /**
     * 反射控制器参数
     */
    public function parameters() {
        $class = new \ReflectionClass(ucfirst($this->controller));
        $parameters = $class->getMethod($this->method)->getParameters();
        $params = array();
        if (count($parameters)) {
            foreach ($parameters as $val) {
                array_push($params, $val->name);
            }
        }
        return $params;
    }

    /**
     * 应用执行
     */
    public function run() {
        if (!is_object(($app = new $this->controller()))) {
            \shengshiwulian\Error::show('请求的控制器不存在', __FILE__);
        }
        if (!method_exists($app, $this->method)) {
            \shengshiwulian\Error::show('请求的控制单元不存在', __FILE__);
        }
        if (method_exists($app, '__before')) {
            echo $app->__before();
        }
        echo call_user_func_array(array($app, $this->method), $this->route->query_get());
        if (method_exists($app, '__after')) {
            echo $app->__after();
        }
    }

}
