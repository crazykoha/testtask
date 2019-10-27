<?php


namespace controllers;


use controllers\base\Controller;
use models\User;

include_once "models/User.php";

class AuthController extends Controller
{
    public function actionLogin() {
        if($_POST['name'] && $_POST['password']) {
            $password = md5($_POST['password']);
            $user = User::find()->where(["`name`='".$_POST['name']."'", "`password`='$password'"])->one();
            if($user){
                setcookie('user', json_encode($user->attributes), time()+3600, '/');
                header('Location: http://'.$_SERVER['SERVER_NAME']);
            } else {
                return $this->render('login', ['error'=>'Неверный логин или пароль']);
            }
        }
        return $this->render('login');
    }

    public function actionRegister() {
        if($_POST['name'] && $_POST['password']) {
            $user = User::find()->where(["`name`='".$_POST['name']."'"])->one();
            if($user){
                return $this->render('register', ['error'=>'Пользователь с таким именем уже существует']);
            }
            if(strlen($_POST['password']) < 3){
                return $this->render('register', ['error'=>'Пароль не должен быть короче 3 символов']);
            }
            $password = md5($_POST['password']);
            $user = new User();
            $user->loadAttributes([
                'name' => $_POST['name'],
                'password' => $password
            ]);
            $user->save();
            setcookie('user', json_encode($user->attributes), time()+3600, '/');
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
        return $this->render('register');
    }

    public function actionLogout() {
        setcookie('user', null, time()-1, '/');
        header('Location: http://'.$_SERVER['SERVER_NAME']);
    }
}