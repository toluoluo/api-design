<?php
// 自动加载命名空间类
spl_autoload_register(function ($name){
    $file = NAMESPACE_PATH.'/'.$name.'.php';
    if(file_exists($file)){
        include $file;
    }else{
        die('class is not exits! class name is : '.$name);
    }
}, true, true);

// 加载帮助函数
foreach(glob(APP_PATH.'/func/*.php') as $file){
    include $file;
}
