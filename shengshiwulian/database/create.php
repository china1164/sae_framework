<?php

namespace shengshiwulian\database;

class Create {
    
    /**
     * 查询字段
     * @var type 
     */
    public $field = array();

    /**
     * 查询条件
     * @var type 
     */
    public $where = array();

    /**
     * 查询限制
     * @var type 
     */
    public $limit;

    /**
     * 查询排序
     * @var type 
     */
    public $order_by;

    /**
     * query sql
     * @var type 
     */
    public $query;

    /**
     * 执行操作类型 select/insert/update/delete
     * @var type 
     */
    public $operate;

    /**
     * 模型
     * @var type 
     */
    public $model;

    /**
     * createsql
     * @return type
     */
    public function create_sql() {
        switch ($this->operate) {
            case 'select':
                return $this->sql_select();
            case 'one':
                return $this->sql_one();
            case 'count':
                return $this->sql_count();
            case 'insert':
                return $this->sql_insert();
            case 'update':
                return $this->sql_update();
            case 'delete':
                return $this->sql_delete();
            default :
                \shengshiwulian\Error::show('不存在的操作类型', __FILE__);
                break;
        }
    }

    /**
     * sqlselect
     * @return type
     */
    public function sql_select() {
        $sql = 'select ';
        if (current($this->field) == '*') {
            $sql .= '* ';
        } else {
            $temp = array();
            foreach ($this->field as $val) {
                $temp[] = '`' . $val . '` ';
            }
            $sql .= implode(',', $temp);
        }
        $sql .= 'from ' . $this->model->table_get() . ' where 1=1 ';
        if (count($this->where)) {
            foreach ($this->where as $val) {
                $sql .= 'and ' . $val . ' ';
            }
        }
        if ($this->order_by) {
            $sql.= $this->order_by;
        }
        if ($this->limit) {
            $sql .= $this->limit;
        }
        return $sql . ';';
    }

    /**
     * sqlone
     * @return type
     */
    public function sql_one() {
        return $this->sql_select();
    }

    /**
     * sqlcount
     * @return string
     */
    public function sql_count() {
        $sql = 'select count(' . current($this->field) . ') from ' . $this->model->table_get() . ' where 1=1 ';
        if (count($this->where)) {
            foreach ($this->where as $val) {
                $sql .= 'and ' . $val . ' ';
            }
        }
        return $sql;
    }

    /**
     * sqlinsert
     * @return type
     */
    public function sql_insert() {
        $field = $values = array();
        foreach ($this->field as $key => $val) {
            $field[] = '`' . $key . '`';
            $values[] = '\'' . $val . '\'';
        }
        return 'insert into ' . $this->model->table_get() . ' (' . implode(',', $field) . ') values (' . implode(',', $values) . ');';
    }

    /**
     * sqlupdate
     * @return type
     */
    public function sql_update() {
        $field = array();
        if (count($this->field)) {
            foreach ($this->field as $key => $val) {
                $field[] = '`' . $key . '`=' . '\'' . $val . '\'';
            }
        }
        $field_str = count($field) ? implode(',', $field) : '';
        $where = '';
        if (count($this->where)) {
            foreach ($this->where as $val) {
                $where .= 'and ' . $val . ' ';
            }
        }
        return 'update ' . $this->model->table_get() . ' set ' . $field_str . ' where 1=1 ' . $where . ';';
    }

    /**
     * sqldelete
     * @return type
     */
    public function sql_delete() {
        $where = '';
        if (count($this->where)) {
            foreach ($this->where as $val) {
                $where .= 'and ' . $val . ' ';
            }
        }
        return 'delete from ' . $this->model->table_get() . ' where 1=1 ' . $where . ';';
    }

}
