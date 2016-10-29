<?php
class Customer extends Common{
   /* <option value="api101">客户列表[全部数据]接口地址[/api/v1/customer/list.do]</option>
    <option value="api102">客户列表[简要数据]接口地址[/api/v1/customer/simpleList.do]</option>
    <option value="api103">新建客户接口地址[/api/v1/customer/add.do]</option>
    <option value="api104">修改客户接口地址[/api/v1/customer/update.do]</option>
    <option value="api105">获取客户详情接口地址[/api/v1/customer/get.do]</option>
    <option value="api106">客户删除接口地址[/api/v1/customer/delete.do]</option>
    <option value="api107">客户关联联系人列表接口地址[/api/v1/customer/contact.do]</option>
    <option value="api108">客户关联合同列表接口地址[/api/v1/customer/contract.do]</option>*/
    
    
    
    public static  function largelist($page=1,$pagesize=15) {
        $data =json_encode(["corpid"=>CORPID , "page"=>$page, "pageSize"=>$pagesize ]);
        $SigningKey = hash('sha256',$data.TOKEN);
        $request = Requests::post(URL.'/customer/list.do',['sign'=>$SigningKey],['data'=>$data]);
        return self::request($request);
    }
    
    
    public static  function simpleList($page=1,$pagesize=15){
        $data =json_encode(["corpid"=>CORPID, "page"=>$page, "pageSize"=>$pagesize ]);
        $SigningKey = hash('sha256',$data.TOKEN);
        $request = Requests::post(URL.'/customer/simpleList.do',['sign'=>$SigningKey],['data'=>$data]);
        return self::request($request);
    }
    
    
    
}