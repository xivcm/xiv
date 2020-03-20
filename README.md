# xiv
#Thinkphp6.0中文繁简体切换

#composer require xiv/language

#use Xiv\xiv;

#vendor/topthink/src/think/Response.php

#/*

#*getContent方法返回值之前添加

#*$xiv=new xiv();

#*$this->content=$xiv->zh_auto($this->content,'J');

#*/

#J表示当前语言为简体中文 F表示当前语言为繁体中文  

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
        
        $this->content=$xiv->zh_auto($this->content,'J');
        
        return $this->content;
        
    }

