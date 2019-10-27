<?php


namespace models\base;


class Query
{
    public $where;
    public $attributes;
    public $order_by;
    public $limit;
    public $modelClass;
    public $offset;


    public function where($where){
        $this->where=$where;
        return $this;
    }

    public function orderBy($order_by){
        $this->order_by=$order_by;
        return $this;
    }

    public function limit($limit){
        $this->limit=$limit;
        return $this;
    }

    public function offset($offset){
        $this->offset=$offset;
        return $this;
    }

    public function one(){
        return $this->get(true);
    }

    public function all(){
        return $this->get();
    }

    public function count(){
        return $this->get(false, true);
    }

    public static function getDBConnection(){
        $config = require 'config.php';
        return mysqli_connect($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['dbname']);
    }

    public function get($is_one=false, $is_count=false){
        $connection = self::getDBConnection();
        $sql = "SELECT";
        if($is_count)
            $sql .= " COUNT(".$this->modelClass::$primary_key.")";
        else
            $sql .= " * ";
        $sql .= "FROM `".$this->modelClass::tableName()."`";
        if($this->where){
            $sql .= " WHERE ";
            $first = true;
            foreach ($this->where as $where) {
                if($first){
                    $sql .= "$where";
                    $first=false;
                } else {
                    $sql .= " AND $where";
                }
            }
        }
        if($this->order_by) {
            $sql .= " ORDER BY ";
            $first = true;
            foreach ($this->order_by as $order_by){
                if($first){
                    $sql.=$order_by;
                    $first=false;
                } else {
                    $sql.=",$order_by";
                }
            }
        }
        if($this->limit) {
            $sql .= " LIMIT $this->limit";
        }
        if($this->offset) {
            $sql .= " OFFSET $this->offset";
        }
        $query = $connection->query($sql);
        $result = [];
        if(!$query)
            return false;
        while ($item = $query->fetch_assoc()) {
            if($is_count)
                return $item["COUNT(".$this->modelClass::$primary_key.")"];
            foreach ($item as $key=>$value){
                if (is_numeric($value))
                    $item[$key] = $value + 0;
            }
            $model = new $this->modelClass;
            $model->attributes = $item;
            if($is_one)
                return $model;
            $result[] = $model;
        }
        return $result;
    }

    public function create(){
        $connection = self::getDBConnection();
        $sql = "INSERT INTO `".$this->modelClass::tableName()."` (";
        $first = true;
        foreach ($this->attributes as $attribute=>$value){
            if($first){
                $sql.="`$attribute`";
                $first=false;
            } else {
                $sql.=",`$attribute`";
            }
        }
        $sql .= ") VALUES (";
        $first = true;
        foreach ($this->attributes as $attribute=>$value){
            if($first){
                $sql.=gettype($value)==='string'?"'$value'":"$value";
                $first=false;
            } else {
                $sql.=",".(gettype($value)==='string'?"'$value'":"$value");
            }
        }
        $sql.=")";
        $connection->query($sql);
        $this->order_by=['id desc'];
        $this->limit=1;
        if($this->modelClass){
            return $this->get()[0];
        }
        return $this->get()[0];
    }

    public function update(){
        $connection = self::getDBConnection();
        $tablename = $this->modelClass::tableName();
        $sql = "UPDATE `$tablename` SET ";
        $first = true;
        foreach ($this->attributes as $attribute=>$value) {
            if ($first) {
                $sql .= "`$attribute` = " . (gettype($value) === 'string' ? "'$value'" : "$value");
                $first = false;
            } else {
                $sql .= ", `$attribute` = " . (gettype($value) === 'string' ? "'$value'" : "$value");
            }
        }
        if($this->where){
            $sql .= " WHERE ";
            $first = true;
            foreach ($this->where as $where) {
                if($first){
                    $sql .= "$where";
                    $first=false;
                } else {
                    $sql .= " AND $where";
                }
            }
        }
        $connection->query($sql);
        $this->order_by=['id desc'];
        $this->limit=1;
        if($this->modelClass){
            return $this->get()[0];
        }
        return $this->get()[0];
    }
}