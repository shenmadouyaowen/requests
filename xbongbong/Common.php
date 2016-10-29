<?php
class Common{
    
    
    protected static function req_post($url,$data){
        $SigningKey = hash('sha256',$data.TOKEN);
        $request = Requests::post(URL.$url,['sign'=>$SigningKey],['data'=>$data]);
        return self::request($request);
    }
    
    
    protected static  function request($request){
        if($request->status_code != 200){
            throw new Requests_Exception('访问出错', 'Customer');
        }
        $body = json_decode($request->body,true);
        if(!self::is_json()){
            throw new Requests_Exception(self::error_json_msg(), 'Customer');
        }
        if($body['errorCode']){
            throw new Requests_Exception($body['msg'], 'Customer');
        }
         
        return $body;
    }
    
    protected static  function is_json() {
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    protected static function error_json_msg(){
        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                return  ' - 到达了最大堆栈深度';
            case JSON_ERROR_STATE_MISMATCH:
                return ' - 无效或异常的 JSON';
    
            case JSON_ERROR_CTRL_CHAR:
                return ' - 控制字符错误，可能是编码不对';
    
            case JSON_ERROR_SYNTAX:
                return ' - 语法错误';
    
            case JSON_ERROR_UTF8:
                return ' - 异常的 UTF-8 字符，也许是因为不正确的编码。';
            case JSON_ERROR_RECURSION:
                return ' - 要编码的值中的一个或多个递归引用';
            case JSON_ERROR_INF_OR_NAN:
                return ' - 要编码的值中的一个或多个NAN或INF值';
            case JSON_ERROR_UNSUPPORTED_TYPE:
                return ' - 给出了不能编码的类型的值';
    
            default:
                return ' - Unknown error';
        }
    
    }
    
}