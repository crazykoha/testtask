<?php


namespace controllers\base;


class Controller
{
    public function getViewPath() {
        $name = get_called_class();
        $array = explode('\\', $name);
        $name = $array[count($array)-1];
        $name = str_replace('Controller', '', $name);
        $name = strtolower($name);
        return "views/$name";
    }

    public function getLayout() {
        return "views/layouts/main.php";
    }

    public function render($view, $params=null) {
        $viewFile = $this->getViewPath()."/".$view.'.php';
        include $this->getLayout();
        return true;
    }
}