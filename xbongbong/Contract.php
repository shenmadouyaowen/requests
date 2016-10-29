<?php
class Contract extends Common{
    
    //contract/simpleList.do
    
    public static function simpleList($page=1,$pagesize=15){
        $data =json_encode(["corpid"=>CORPID , "page"=>$page, "pageSize"=>$pagesize ]);
        return self::req_post('/contract/simpleList.do', $data);
    }
    
    
    
    public static  function largelist($page=1,$pagesize=15) {
        $data =json_encode(["corpid"=>CORPID , "page"=>$page, "pageSize"=>$pagesize ]);
        return self::req_post('/contract/list.do', $data);
    }
    
    
    public static function get_info($contractId){
        $data =json_encode(["corpid"=>CORPID ,'contractId'=>$contractId]);
        return self::req_post('/contract/get.do', $data);
    }
    
}