<?php
namespace app\controller;
use app\Conf;
class Base{
    
    private $_model   = '';
    private $_method  = '';
    private $_ver     = '0.0.0';
    private $_isAcc   = true;
    private $_param   = [];
    
    /**
     * 获取结果集
     */
    protected function getRst(){
        $this->_crossDomain();
        $this->_getParam();
        $obj = $this->_callController($this->_model, $this->_method, $this->_param);
        if($obj == false){
            $rst = $this->_empty();
        }else{
            $rst = call_user_func_array($obj, [$this->_param]);
        }
        return strval_array($this->_formatRst($rst));
    }
    
    /**
     * 生成对应的控制器类，不存在返回false
     * @param string $service
     * @param string $method
     * @param array $param
     * @return boolean|object
     */
    private function _callController($service, $method, $param){
        $list = Conf::get('callpath');
        if($method == '_class') return false;
        if(!isset($list[$service][$method]) || !$list[$service][$method][1]) return false;
        $cls = '\\app\\service\\'.$list[$service]['_class'];
        if(!class_exists($cls) || !method_exists($cls, $list[$service][$method][0])) return false;
        return [new $cls, $list[$service][$method][0]];
    }
    
    /**
     * 获取请求参数
     * 参数中m键值必须存在，用来在callpath文件中寻找对应的模块方法。
     */
    private function _getParam(){
        if(is_get()){
            $param = $_GET;
        }elseif(is_post()){
            // post或ajax请求必须是以data为键，json格式为值的数据
            $param = json_decode($_POST['data'], true);
        }elseif(is_ajax()){
            $param = json_decode($_POST['data'], true);
        }
        if(isset($param['m'])){
            $service_method = explode('-',$param['m']); //
            $this->_model = $service_method[0];
            $this->_method = $service_method[1];
            unset($param['m']);
        }
        $this->_param = $param;
        // ============================
        // ==== 此处的参数需安全过滤 ====
        // ============================
        
    }
    
    /**
     * 处理跨域
     */
    private  function _crossDomain(){
        // 测试域名，可以放在配置文件中动态添加
        $allow = [
            'http://127.0.0.1',
            'http://myapi.com'
        ];
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        if(in_array($origin, $allow)){
            header('Access-Control-Allow-Origin:' . $origin);
        }
        header('Access-Control-Allow-Credentials:true');
        header('Access-Control-Allow-Headers:Origin, No-Cache, X-Requested-With, If-Modified-Since, Pragma, Last-Modified, Cache-Control, Expires, Content-Type, X-E4M-With');
    }
    
    /**
     * 请求的模块或方法不存在
     */
    private function _empty(){
        return 404;
    }
    
    /**
     * 格式化结果集
     * @param array|number|string $data
     * @return array
     */
    private function _formatRst($data){
        $rst = [];
         
        if(!is_array($data)){
            $msg = Conf::get('errcode.'.$data) ? Conf::get('errcode.'.$data) : '';
            if($msg){
                return [
                    'data' => (object)[],
                    'msg'  => $msg,
                    'status' => '0',
                ];
            }
        }
        if(isset($data['data'])) $data = $data['data'];
        return [
            'data' => $data,
            'msg'  => 'success',
            'status' => '1',
        ];
    }
}