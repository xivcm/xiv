# xiv
#Thinkphp6.0中文繁简体切换

#composer require xiv/language

#use Xiv\xiv;

#vendor/topthink/src/think/Response.php

#/*

#*getContent方法返回值之前添加

#*$xiv=new xiv();

#*$this->content=$xiv->zh_auto($this->content);

#*/


#Thinkphp6.0所有程序返回结果皆会被转换，

#但是不包含半路打印的print_r echo exit输出等等。

#  public function getContent(): string

    {
        if (null == $this->content) {
        
            $content = $this->output($this->data);

            if (null !== $content && !is_string($content) && !is_numeric($content) && !is_callable([
                $content,
                '__toString',
            ])
            ) {
            
                throw new \InvalidArgumentException(sprintf('variable type error： %s', gettype($content)));
                
            }

            $this->content = (string) $content;
            
        }
        
        return $this->content;
        
    }
   public function getContent(): string
   
    {
    
        if (null == $this->content) {
        
            $content = $this->output($this->data);

            if (null !== $content && !is_string($content) && !is_numeric($content) && !is_callable([
                $content,
                '__toString',
            ])
            ) {
            
                throw new \InvalidArgumentException(sprintf('variable type error： %s', gettype($content)));
                
            }

            $this->content = (string) $content;
            
        }
        
        $xiv=new xiv();
        
        $this->content=$xiv->change($this->content);
        
        return $this->content;
        
    }
以Thinkphp默认页做Demo

thinkphp/app/controller/index.php

测试内容如下

访问 http://localhost/index.php/index/language/la/J/to/F 简体转换为繁体

访问 http://localhost/index.php/index/language/la/zh/to/en 简体中文转换为英文

其他语言支持正在扩展中

------------------------------------------------------------

namespace app\controller;

use app\BaseController;

use think\Request;

class Index extends BaseController

{

    public function index()
    
    {
    
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) 2020新春快乐</h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">14载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
        
    }

    public function hello($name = 'ThinkPHP6')
    
    {
    
        return 'hello,' . $name;
        
    }
    
    public function language(){
    
    	$la=$this->request->param('la');
        
    	$to=$this->request->param('to');
        
    	\think\facade\Session::set('Translate_from',$la);
        
    	\think\facade\Session::set('Translate_to',$to);
        
    	return $this->index();
        
    }
    
}
