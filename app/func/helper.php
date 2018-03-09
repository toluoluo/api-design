<?php

if(!function_exists('strval_array')){
    /**
     * 将数组的值转为字符串
     * @param array $arr
     * @return array
     */
    function strval_array($arr){
        if(is_array($arr) && !empty($arr)){
            foreach($arr as $n => $v){
                $b[$n] = strval_array($v);
            }
            return $b;
        }else{
            if (is_object($arr)) return $arr;
            if (is_array($arr) && empty($arr)) return array();
            return strval($arr);
        }
    }
}

if(!function_exists('is_get')){
    function is_get(){
        return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
    }
}

if(!function_exists('is_post')){
    function is_post(){
         return $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_SERVER['HTTP_REFERER']) ? true : false;
    }
}

if(!function_exists('is_ajax')){
    function is_ajax(){
       return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] == 'xmlhttprequest') ? true : false;
    }
   
}

   