<?php
namespace plokko\PageHelper;


class Links
{
    protected
        $links=[];
    /*
    function __construct(array $cfg=[])
    {
    }
    */


    function add($rel,$value)
    {
        $this->links[$rel][]=is_string($value)?['href'=>$value]:$value;
    }

    function set($rel,$value)
    {
        if($value==null)
            unset($this->links[$rel]);
        else
            $this->links[$rel]=is_array($value)?$value:[is_string($value)?['href'=>$value]:$value];
    }


    function __get($k)
    {
        return isset($this->links[$k])?$this->links[$k]:null;
    }

    function render()
    {
        $txt='';
        foreach($this->links AS $rel=>$list)
        {
            foreach($list AS $tags)
            {

                $txt.="\t".'<link rel="'.$rel.'" ';
                if($tags)
                    foreach($tags AS $k=>$v)
                        $txt.=$k.'="'.htmlspecialchars($v).'" ';
                $txt.="/>\n";
            }
        }
        return $txt;
    }

    function __toString()
    {
        return $this->render();
    }

}