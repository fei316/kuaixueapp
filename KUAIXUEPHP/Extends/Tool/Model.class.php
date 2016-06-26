<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-06-26
 * Time: 12:31
 */
class Model
{
    //保存连接信息
    public static $link = null;

    //保存表名
    protected $table = null;

    //初始化表信息
    private $opt;

    //记录发送的sql
    public static $sqls = array();

    public function __construct($table = null){
        $this->table = is_null($table) ? C('DB_PREFIX') . $this->table : C('DB_PREFIX') . $table;
        //连接数据库
        $this->_connect();
        //初始化sql信息
        $this->_opt();
    }

    public function query($sql){
        self::$sqls[] = $sql;
        $link = self::$link;
        $result = $link->query($sql);
        if ($link->errno) halt('mysql错误：' . $link->error . '<br />SQL：' . $sql);
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $result->free();
        $this->_opt();
        return $rows;
    }

    public function one(){
        return $this->find();
    }

    public function find(){
        $data = $this->limit(1)->all();
        $data = current($data);
        return $data;
    }

    public function limit($limit){
        $this->opt['limit'] = " limit " . $limit;
        return $this;
    }


    public function order($order){
        $this->opt['order'] = " order by " . $order;
        return $this;
    }

    public function where($where){
        $this->opt['where'] = " where " . $where;
        return $this;
    }

    public function field($field){
        $this->opt['field'] = $field;
        return $this;
    }

    public function findAll(){
        return $this->all();
    }

    public function all(){
        $sql = "select " . $this->opt['field'] . " from " . $this->table . $this->opt['where'] . $this->opt['group'] . $this->opt['having'] . $this->opt['order'] . $this->opt['limit'];
        return $this->query($sql);
    }

    private function _opt(){
        $this->opt = array(
            'field'     => '*',
            'where'     => '',
            'group'     => '',
            'having'    => '',
            'order'     => '',
            'limit'     => ''
        );
    }

    /**
     * 数据库连接
     */
    private function _connect(){
        if (is_null(self::$link)) {
            $db = C('DB_DATABASE');
            if (empty($db)) halt('请先配置数据库');
            $link = new Mysqli(C('DB_HOST'), C('DB_USER'), C('DB_PASSWORD'), $db, C('DB_PORT'));
            if ($link->connect_error) halt("数据库连接错误，请检查配置项");

            $link->set_charset(C('DB_CHARSET'));
            self::$link = $link;
        }
    }


    public function exe($sql){
        self::$sqls[] = $sql;
        $link = self::$link;
        $bool = $link->query($sql);
        $this->_opt();
        if (is_object($bool)) {
            halt("请用query方法发送查询sql");
        }

        if ($bool) {
            return $link->insert_id ? $link->insert_id : $link->affected_rows;
        } else {
            halt('mysql错误：' . $link->error . '<br />SQL：' . $sql);
        }
    }

    public function delete(){
        if (empty($this->opt['where'])) {
            halt("删除必须有where条件");
        }
        $sql = "delete from " . $this->table . $this->opt['where'];
        return $this->exe($sql);
    }

    public function update($data=null){
        if (empty($this->opt['where'])) {
            halt("更新必须有where条件");
        }
        if (is_null($data)) $data = $_POST;

        $values = '';
        foreach ($data as $f => $v) {
            $values .= "`" . $this->_safe_str($f) . "`='" . $this->_safe_str($v) . "',";
        }
        $values = trim($values, ',');
        $sql = "update " . $this->table . " set " . $values . $this->opt['where'];
        self::$sqls[] = $sql;
        return $this->exe($sql);
    }

    public function add($data=null){
        if (is_null($data)) $data = $_POST;
        $fields = '';
        $values = '';

        foreach ($data as $f => $v) {
            $fields .= "`" . $this->_safe_str($f) . "`,";
            $values .= "'" . $this->_safe_str($v) . "',";
        }

        $fields = trim($fields, ',');
        $values = trim($values, ',');

        $sql = "insert into " . $this->table . '(' . $fields . ') values (' . $values . ')';
        self::$sqls[] = $sql;
        return $this->exe($sql);
    }

    private function _safe_str($str){
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }

        return self::$link->real_escape_string($str);
    }
















}