<?php
/**
 * api接口设计
 * 
 * 入口文件： www/api.php
 * 传参方式eg：
 *     get: m=test-t1&key=val
 *     post | ajax: data="{json string}"
 *     注：参数m必选，m=serveice-method，具体可看app/conf/callpath.php说明
 * 返回格式化json数据：
            成功：
            {
                "data": {
                    "return": "test-result"
                },
                "msg": "success",
                "status": "1"
            }
             失败：
            {
                "data": {},
                "msg": "访问接口不存在",
                "status": "0"
            }
 * 
 * 
 * 说明：
 * 1、只有一个入口：xxx.com/api.php
 * 2、传过来的参数用作api service层的类的方法参数
 * 3、service层的类配置在callpath.php文件，配置文件可控制访问，另起别名，接口说明，扩展版本模块等
 *    结合配置可统一做版本控制、流量监控、流量控制等
 * 4、controller类可添加token，做鉴权
 * 5、错误代号配置文件可统一API错误代号、错误识别等
 * 
 * 另：
 * 1、参数没经安全处理，谨慎使用
 * 
 *  author：nk
 *  email:1257746805@qq.com
 */
include '../app/init.php';
