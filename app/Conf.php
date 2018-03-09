<?php
namespace app;
class Conf{
    private static $_conf = [];
    
    /**
     * 根据key获取配置值
     * @param unknown $key
     * @return Ambigous <NULL, multitype:>|NULL
     */
    public static function get($key){
        self::_load();
        if(strpos($key,'.') === false){
            return isset(self::$_conf[$key]) ? self::$_conf[$key] : null;
        }
        $tmp = explode('.', $key);
        return isset(self::$_conf[$tmp[0]][$tmp[1]]) ? self::$_conf[$tmp[0]][$tmp[1]] : null;
    }
    
    /**
     * 加载配置文件
     */
    private static function _load(){
        foreach(glob(__DIR__.'/conf/*.php') as $file){
            $name = pathinfo($file, PATHINFO_FILENAME);
            if(isset(self::$_conf[$name])) continue;
            foreach(include $file as $k => $v){
                self::$_conf[$name][$k] = $v;
            }
        }
    }
}