<?php

namespace shengshiwulian\database;

class Mysql extends \shengshiwulian\database\Query{

    public static $instance;
    

    /**
     * __construct
     */
    public function __construct($config = array()) {
        $config = count($config) ? $config : \shengshiwulian\Config::get('database.db_config');
        $connect = null;
        try {
            $connect = mysql_connect($config['host'] . ':' . $config['port'], $config['user'], $config['password']);
            mysql_select_db($config['dbname'], $connect);
        } catch (\Exception $e) {
            \shengshiwulian\Error::show($e->getMessage(), __FILE__);
        }
        mysql_query("set names {$config['charset']}");
    }

    /**
     * 获取实例
     * @return type
     */
    public static function getinstance($model) {
        if (!(static::$instance instanceof static)) {
            static::$instance = new static();
            static::$instance->model = $model;
        }
        return static::$instance;
    }
    
    public function __call($name, $arguments) {
        dd(222);
    }
    
    /**
     * delete
     * @return array
     */
    public function getfield(){
        $result = mysql_query('show columns from '.static::$table);
        $field = array();
        if(!$result){
            return $field;
        }
        while(($row=mysql_fetch_array($result))){
            $field[] = $row['Field'];
        }
        return $field;
    }
    
    /**
     * __destruct
     */
    public function __destruct() {
        mysql_close();
    }
    


}
