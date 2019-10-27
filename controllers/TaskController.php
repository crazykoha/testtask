<?php


namespace controllers;


use controllers\base\Controller;
use models\Task;

class TaskController extends Controller
{
    public function actionCreate(){
        if($_POST['user_name'] && $_POST['email'] && $_POST['text']){
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                return $this->render('create', ['error'=>'Неверный email']);
            }
            $task = new Task();
            $task->attributes['email'] = $_POST['email'];
            $task->attributes['user_name'] = $_POST['user_name'];
            $task->attributes['text'] = $_POST['text'];
            $task->save();
            header('Location: http://'.$_SERVER['SERVER_NAME']."?text=Задача успешно создана");
        }
        return $this->render('create');
    }

    public function actionUpdate(){
        $user=\models\User::getCurrentUser();
        if(!$user){
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/auth/login');
            return false;
        }
        if($user->attributes['is_admin']==0){
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/auth/login');
        }
        if($_GET['id']){
            $task = Task::find()->where(["`id`=".$_GET['id']])->one();
            if($task)
                return $this->render('update', [
                    'task' => $task
                ]);
            else
                header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
        if($_POST['user_name'] && $_POST['email'] && $_POST['text'] && $_POST['id']){
            $task = Task::find()->where(["`id`=".$_POST['id']])->one();
            if($task->attributes['updated_by_admin']==0)
                $task->attributes['updated_by_admin']=$_POST['text'] === $task->attributes['text']?0:1;
            $task->attributes['email'] = $_POST['email'];
            $task->attributes['user_name'] = $_POST['user_name'];
            $task->attributes['text'] = $_POST['text'];
            if($_POST['status']==='on')
                $task->attributes['status'] = 1;
            else
                $task->attributes['status'] = 0;

            $task->save();
            header('Location: http://'.$_SERVER['SERVER_NAME']);
        }
        header('Location: http://'.$_SERVER['SERVER_NAME']);
    }
}