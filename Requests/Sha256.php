<?php
class Sha256{
    protected $AK;
    protected $SK;
    protected $timestamp;
    protected $expirationPeriodInSeconds = "3600";
    protected $CanonicalString;
    protected $CanonicalURI;
    public function __construct($AK,$SK,$CanonicalURI,$exp='3600',$CanonicalString=''){
        $this->AK = $AK;
        $this->SK = $SK;
        $this->CanonicalString = $CanonicalString;
        $this->expirationPeriodInSeconds = $exp;
        $this->CanonicalURI=$CanonicalURI;
    }
    /*
     生成UTC时间，默认是当前时间。比如说现在北京时间是2015/10/23 16:48:00.
     那么对应的UTC时间就是当前时间减8小时，也就是2015/10/23 8:48:00
     这里最终时间的格式是：2015-10-23T08:48:00Z
     */
    private function utc(){
        date_default_timezone_set('UTC');
        $this->timestamp = date("Y-m-d")."T".date("H:i:s")."Z";
        
    }
    /*
     这里要生成signKey，生成signKey需要是将bce-auth-v1+AK+timestamp+过期时间拼接起来形成authStringPrefix.
     然后用签名中使用的HASH算法(HMAC SHA256)将刚才拼接的authStringPrefix和SK签一遍，打印出来signKey。
     */
    
    protected $SigningKey;
    private function signKey(){
       // $authStringPrefix = $this->AK.'+'.$this->timestamp;
        $this->SigningKey=hash_hmac('SHA256',$this->AK,$this->SK);
    }
    /*
     对于GET请求，建议header里只需要加入host；如果是PUT请求，建议header里添加host和x-bce-date.如果你的header
     里还要加Content-lenth,Content-Type等，要将得到的字符串组按照字典序排序用换行符\n连接起来。
     为了以后拼接方便，创建了header1，header2是将时间进行规范化字符串处理过的，这才是实际Canoncial
     中需要的。
     */
    protected $Signature,$CanonicalHeaders1 ;
    private function headers(){
        $this->CanonicalHeaders1 = "host;"."x-bce-date";
        $CanonicalHeaders2 = "host:bj.bcebos.com\n"."x-bce-date:".urlencode($this->timestamp);

        //可以没有CanoncialString，也就是这一项为空
        
        
        /*
              当请求是http://bj.bcebos.com/v1/zxdtestbae/image.jpg的时候，CanoncialURL就是下面的/v1/zxdtestbae/
         image.jpg
         */
        //$CanonicalURI = "/v1/zxdtestbae/image.jpg";
        
        /*CanoncialRequest由请求方法(GET，PUT或者POST), CanoncialURL,CanoncialHeaders组成。*/
        $CanonicalRequest = "POST\n".$this->CanonicalURI."\n".$this->CanonicalString."\n".$CanonicalHeaders2;    //第二步
       // print $CanonicalRequest."\n";
        
        /*使用 HMACSHA256 算法，SignKey，CanonicalRequest 生成最终签名*/
        $this->Signature = hash_hmac('SHA256',$CanonicalRequest,$this->SigningKey);
       // print $Signature."\n";
       
        
    }
    /*
     生成认证字符串，认证字符串的格式为：
     bce-auth-v1/{AK}/{timestamp}/{expirationPeriodInSeconds}/{CanonicalHeaders1}/{signature}
     */
    public function Authorization(){
        $this->utc();
        $this->signKey();
        $this->headers();
        $Authorization = "bce-auth-v1/{$this->AK}/".$this->timestamp."/{$this->expirationPeriodInSeconds}/{ $this->CanonicalHeaders1}/{ $this->Signature}";
        return $Authorization;
    }
    public function get_Signature(){
        return $this->Signature;
    }
    
    public function get_SigningKey(){
        return $this->SigningKey;
        
    }
    
    
}






//文／tanxiniao（简书作者）
//原文链接：http://www.jianshu.com/p/fed2b580db8e
//著作权归作者所有，转载请联系作者获得授权，并标注“简书作者”。