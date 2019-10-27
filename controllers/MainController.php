<?php

namespace controllers;

use controllers\base\Controller;
use models\Task;

include_once "controllers/base/Controller.php";
include_once "models/Task.php";

class MainController extends Controller
{
    public function actionIndex() {
        $page = (int)$_GET['page'];
        $tasks_count = Task::find()->count();
        $pages_count = ceil($tasks_count/3);
        if($tasks_count < 4)
            $pages_count = 0;
        $tasks = Task::find()->limit(3);
        if($page)
            $tasks->offset(($page-1)*3);
        if($_GET['sort'] && $_GET['order']){
            $tasks->orderBy([$_GET['sort'].' '.$_GET['order']]);
        }
        $tasks = $tasks->all();
        return $this->render('index', [
            'tasks' => $tasks,
            'pages_count' => $pages_count
        ]);
    }
    public function actionTest() {
        echo 'test';
    }
}