<?php
namespace plokko\PageHelper;


class Meta implements \ArrayAccess
{
    private
        $charset,
        $metatags=[];

    function __construct($cfg=[])
    {
        $this->charset();//default charset
        if(isset($cfg['meta']['tags']))
        {
            foreach($cfg['meta']['tags'] AS $k=>$v)
            {
                $opt=[];
                if(is_array($v))
                {
                    $opt=$v;
                    $v=isset($v['content'])?$v['content']:null;
                }
                $this->add($k,$v,$opt);
            }
        }
        if(isset($cfg['meta']['http-equiv']))
        {
            foreach($cfg['meta']['http-equiv'] AS $k=>$v){
                $opt=[];
                if(is_array($v))
                {
                    $opt=$v;
                    $v=isset($v['content'])?$v['content']:null;
                }
                $this->httpEquiv($k,$v,$opt);
            }
        }
        if(isset($cfg['meta']['og']))
        {
            foreach($cfg['meta']['og'] AS $k=>$v){
                $this->og($k,$v);
            }
        }
    }

    function getInstance()
    {
        return $this;
    }

    function charset($charset='utf-8',array $opt=[])
    {

        $this->charset=new MetaTag(
            [
                'charset'=>$charset,
            ]+$opt
        );
    }

    function add($name,$value=null,array $opt=[])
    {
        if($name=='charset')
            $this->charset($value,$opt);
        else
            $this->metatags[$name]=new MetaTag(
                [
                    'name'=>$name,
                    'content'=>$value,
                ]+$opt
            );
    }

    function httpEquiv($name,$value,array $opt=[])
    {
        $this->metatags[$name]=new MetaTag(
            [
                'http-equiv'=>$name,
                'content'=>$value,
            ]+$opt
        );
    }

    function og($property, $content)
    {
        $this->metatags[$property]=new OGMetaTag($property, $content);
    }

    function render()
    {
        return "\t".implode("\n\t",$this->metatags)."\n";
    }

    function __toString()
    {
        return $this->render();
    }


    function __get($k)
    {
        if($k=='charset')return $this->charset;
        return isset($this->metatags[$k])?$this->metatags[$k]:null;
    }

    function __set($k,$v)
    {
        $this->add($k,$v);
    }

    public function offsetExists($offset)
    {
        return isset($this->metatags[$offset]);
    }

    /**
     * @param string $offset
     * @return MetaTag|OGMetaTag
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    public function offsetSet($k, $v)
    {
        $this->add($k,$v);
    }

    public function offsetUnset($offset)
    {
        unset($this->metatags[$offset]);
    }
}