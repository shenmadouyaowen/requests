<?php
class Contact extends Common{

    //contract/simpleList.do

    public static function simpleList($page=1,$pagesize=15){
        $data =json_encode(["corpid"=>CORPID , "page"=>$page, "pageSize"=>$pagesize ]);
        return self::req_post('/contact/simpleList.do', $data);
    }



    public static  function largelist($page=1,$pagesize=15) {
        $data =json_encode(["corpid"=>CORPID , "page"=>$page, "pageSize"=>$pagesize ]);
        return self::req_post('/contact/list.do', $data);
    }


    public static function get_info($contractId){
        $data =json_encode(["corpid"=>CORPID ,'contractId'=>$contractId]);
        return self::req_post('/contact/get.do', $data);
    }

}