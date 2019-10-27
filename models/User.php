<?php


namespace models;


use models\base\Model;

class User extends Model
{
    public static function getCurrentUser() {
        $user_data = json_decode($_COOKIE['user']);
        $user = User::find()->where(["`id`=$user_data->id"])->one();
        return $user;
    }

    public static function isLoggedIn() {
        if($_COOKIE['user'])
            return true;
        return false;
    }
}
User::init();