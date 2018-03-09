<?php
namespace app;
// 直接使用控制器,这里可以处理成路由
use app\controller\Index;
class App{
    public static function run(){
        $controller = new Index();
        $controller->index();
    }
}