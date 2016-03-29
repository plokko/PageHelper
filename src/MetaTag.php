<?php
namespace plokko\PageHelper;


class MetaTag
{

    protected
        $attr=[];

    function __construct(array $attr=[])
    {
        $this->attr=$attr;
    }

    function render()
    {
        $txt='';
        foreach($this->attr AS $k=>$v)
        {
            if($v!==null)
            {
                switch(gettype($v))
                {
                    case 'object':
                        if(is_callable($v))
                        {
                            $v=$v();
                            break;
                        }
                        $v=(array)$v;
                    case 'array':
                        $v=implode(',',$v);
                        break;
                    default:
                }

                $txt.=' '.$k.'="'.htmlspecialchars($v).'"';
            }
        }
        return '<meta '.$txt.'/>';
    }

    function __toString()
    {
        return $this->render();
    }

    function __get($k)
    {
        return isset($this->attr[$k])?$this->attr[$k]:null;
    }

}