<?php

namespace shengshiwulian\database;

class Query extends \shengshiwulian\database\Create {

    /**
     * 受影响的行
     * @var type 
     */
    public $affected_rows = false;

    /**
     * debug
     * @var type 
     */
    public $debug = false;

    /**
     * query
     * @param type $query
     * @return type
     */
    public function query($query = '') {
        if ($this->debug) {
            echo ($this->operate ? $this->create_sql() : $query) . "\n";
        }
        return ($this->query = mysql_query($this->operate ? $this->create_sql() : $query));
    }

    /**
     * attribute_set
     * @param type $attribute
     * @return type
     */
    public function attribute_set($attribute = array()) {
        if (!count($attribute)) {
            return;
        }
        foreach ($attribute as $key => $val) {
            $this->{$key} = $val;
        }
        return $this;
    }

    /**
     * table
     * @param type $table
     */
    public function table($table = null) {
        //return
    }

    /**
     * select
     * @param type $field
     * @return type
     */
    public function select($field = array('*')) {
        $this->attribute_set(array(
            'operate' => 'select',
            'field' => $field
        ));
        $this->query();
        $data = array();
        while (($row = mysql_fetch_object($this->query))) {
            $data[] = $this->model->attribute_set($row);
        }
        return $data;
    }

    /**
     * one
     * @param type $field
     * @return type
     */
    public function one($field = array('*')) {
//        $this->operate = 'one';
//        $this->field = $field;
//        $this->limit = 'limit 1 ';
        $this->attribute_set(array(
            'operate' => 'one',
            'field' => $field,
            'limit' => 'limit 1 '
        ));
        return $this->model->attribute_set(mysql_fetch_object($this->query()));
    }

    /**
     * where
     * @param type $where
     * @return \shengshiwulian\database\Query
     */
    public function where($where) {
        if (is_array($where)) {
            foreach ($where as $key => $val) {
                $this->where[] = '`' . $key . '`=\'' . $val . '\'';
            }
        } else {
            $this->where[] = $where;
        }
        return $this;
    }

    /**
     * order_by
     * @param type $field
     * @param type $order_by
     * @return \shengshiwulian\database\Query
     */
    public function order_by($order_by) {
//        $this->order_by = " order by {$order_by} ";
        return $this->attribute_set(array(
            'order_by' => " order by {$order_by} "
        ));
    }

    /**
     * limit
     * @param type $limit
     * @return \shengshiwulian\database\Query
     */
    public function limit($limit) {
//        $this->limit = "limit {$limit} ";
        return $this->attribute_set(array(
            'limit' => "limit {$limit} "
        ));
    }

    /**
     * count
     * @param type $field
     * @return type
     */
    public function count($field = array('*')) {
//        $this->operate = 'count';
//        $this->field = $field;
        $this->attribute_set(array(
            'operate' => 'count',
            'field' => $field
        ));
        $row = mysql_fetch_row($this->query());
        return isset($row[0]) ? $row[0] : \shengshiwulian\Error::show('获取count记录失败', __FILE__);
    }

    /**
     * find
     * @param type $key
     * @return type
     */
    public function find($field) {
        return $this->where($this->model->key_get() . "={$field}")->one();
    }

    /**
     * insert
     * @param type $insert
     * @return type
     */
    public function insert($insert = array()) {
        if (!count($insert)) {
            \shengshiwulian\Error::show('请传入insert参数数组', __FILE__);
        }
//        $this->operate = 'insert';
//        $this->field = $insert;
        $this->attribute_set(array(
            'operate' => 'insert',
            'field' => $insert
        ));
        $this->query();
        return mysql_insert_id();
    }

    /**
     * create
     * @param type $insert
     * @return type
     */
    public function create($insert = array()) {
        $id = $this->insert($insert);
        if (!$id) {
            return \shengshiwulian\Error::show('insert失败', __FILE__);
        }
        return $this->find($id);
    }

    /**
     * update
     * @param type $update
     * @return type
     */
    public function update($update = array()) {
//        $this->operate = 'update';
//        $this->field = $update;
        $this->attribute_set(array(
            'operate' => 'update',
            'field' => $update
        ));
        $this->query();
        return $this->affected_rows ? mysql_affected_rows() : $this->query;
    }

    /**
     * affected_rows
     * @return type
     */
    public function affected_rows() {
        $this->affected_rows = true;
        return $this;
    }

    /**
     * delete
     * @return type
     */
    public function delete() {
//        $this->operate = 'delete';
        $this->attribute_set(array(
            'operate' => 'delete'
        ));
        $this->query();
        return $this->affected_rows ? mysql_affected_rows() : $this->query;
    }

    /**
     * debug
     * @return \shengshiwulian\database\Query
     */
    public function debug() {
//        $this->debug = true;
//        return $this;
        return $this->attribute_set(array(
            'debug' => true
        ));
    }

    /**
     * save
     * @param type $obj
     * @return type
     */
    public function save($original) {
        if (!is_object($original)) {
            \shengshiwulian\Error::show('操作数据类型不是对象', __FILE__);
        }
        $set = array();
        foreach (\shengshiwulian\Iterator::make($original) as $key => $val) {
            $set[$key] = $val;
        }
        if (!count($set)) {
            \shengshiwulian\Error::show('操作数据类型没有属性', __FILE__);
        }
        return $original->find($original->{$original->key_get()})->update($set);
    }

}
