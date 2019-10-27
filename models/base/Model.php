<?php


namespace models\base;

include "models/base/Query.php";

class Model
{
    public static $attribute_names;
    public $attributes;
    public static $primary_key = 'id';

    public static function tableName(){
        $namespace = explode("\\", static::class);
        return strtolower($namespace[count($namespace)-1]);
    }

    public function loadAttributes($attributes){
        if(!is_array($attributes))
            return false;
        foreach ($attributes as $attribute=>$value){
            if(array_search($attribute, self::$attribute_names)){
                $this->attributes[$attribute] = $value;
            }
        }
    }


    static function init(){
        $config = require 'config.php';
        $connect = Query::getDBConnection();
        $query = $connect->query('SELECT `COLUMN_NAME` 
            FROM `INFORMATION_SCHEMA`.`COLUMNS` 
            WHERE `TABLE_SCHEMA`=\''.$config['db']['dbname'].'\' 
            AND `TABLE_NAME`=\''.self::tableName().'\';');
        $result = [];
        while ($item = $query->fetch_assoc()) {
            $result[] = $item['COLUMN_NAME'];
        }
        self::$attribute_names = $result;
    }

    public function save(){
        $query = new Query();
        $query->attributes = $this->attributes;
        $query->modelClass = get_called_class();
        if($this->attributes[self::$primary_key]){
            $query->where = ["`".self::$primary_key."`=".$this->attributes[self::$primary_key]];
            $query->update();
        } else {
            $this->attributes=$query->create()->attributes;
        }
    }

    public function delete(){
        $connection = Query::getDBConnection();
        $connection->query("DELETE FROM `".self::tableName()."` WHERE ".self::$primary_key."=".$this->attributes[self::$primary_key]);
    }

    public static function find(){
        $query = new Query();
        $query->modelClass=get_called_class();
        return $query;
    }
}
Model::init();