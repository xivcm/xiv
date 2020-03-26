<?php
namespace Xiv;
/* 繁体简体切换 思路 字典 互相替换比如 载=>載 或者反过来。
 * 支持多语言转换
 * 2020-03-22
 */
//$funs=get_class_methods("xiv");
class xiv
{

    /* *
     * 中文简繁体切换
     * J为简体中文 F为繁体中文
     * $input 需要转换的文本
     * $from 当前语言代码
     * $to 目标语言代码
     * */
    private $list;
    private $ak='YOUR AK';
    private $sk='YOUR SK';// https://xiv.cm 免费获取
    function __construct(){
        //获取所有支持的转换
        $list=get_class_methods("Xiv\xiv");
        foreach ($list as $key => $value) {
            if(strpos($value, '2')){
                $this->list[]=$value;
            }
        }
    }
    public static function change($input,$from=false,$to=false){
        if(empty($from)){
            $from=\think\facade\Session::get('Translate_from');
        }
        if(empty($to)){
            $to=\think\facade\Session::get('Translate_to');
        }
        $headers=array('User-Agent: '.self::getUa());
        $sign=md5($this->ak.$from.base64_encode($input).$to.$this->sk);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://xiv.cm/translate.html');
        curl_setopt($curl, CURLOPT_HTTP_VERSION, '1.0');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, ['info'=>$input,'from'=>$from,'to'=>$to,'sign'=>$sign,'appid'=>$this->ak]); // Post提交的数据包
        $resp_json = curl_exec($curl);
        curl_close($curl);
        $resp = json_decode($resp_json, true);
        return $resp['msg']=='ok'?$resp['info']:$input;
        
    }
    private static function getUa(){
        $agentArray=[
        //PC端的UserAgent
        "safari 5.1 – MAC"=>"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
        "safari 5.1 – Windows"=>"Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
        "Firefox 38esr"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
        "IE 11"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
        "IE 9.0"=>"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0",
        "IE 8.0"=>"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
        "IE 7.0"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)",
        "IE 6.0"=>"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)",
        "Firefox 4.0.1 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
        "Firefox 4.0.1 – Windows"=>"Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
        "Opera 11.11 – MAC"=>"Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11",
        "Opera 11.11 – Windows"=>"Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11",
        "Chrome 17.0 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
        "傲游（Maxthon）"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)",
        "腾讯TT"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; TencentTraveler 4.0)",
        "世界之窗（The World） 2.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
        "世界之窗（The World） 3.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; The World)",
        "360浏览器"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; 360SE)",
        "搜狗浏览器 1.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SE 2.X MetaSr 1.0; SE 2.X MetaSr 1.0; .NET CLR 2.0.50727; SE 2.X MetaSr 1.0)",
        "Avant"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Avant Browser)",
        "Green Browser"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
    ];
    $userAgent=$agentArray[array_rand($agentArray,1)];  //随机浏览器userAgent
    return $userAgent;
    }


}
?>
