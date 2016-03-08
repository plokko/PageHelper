<?php
namespace plokko\PageHelper;


class Style
{
    protected
        $styles=[];

    function __construct(array $cfg=[])
    {
        if(isset($cfg['style']['required']))
        {
            foreach($cfg['style']['required'] AS $name=>$opt)
            {
                $this->styles[$name]=is_array($opt)?$opt:[];
            }
        }
    }

    function render()
    {
        $txt='';
        foreach($this->styles AS $name=>$opt)
        {
                //Auto prepent css folder if the filename does not start with /
                $url= url($name[0]=='/'?'/':'css/'.$name);

                $txt.="\t".'<link type="text/css" rel="stylesheet" href="'.htmlspecialchars($url).'" media="'.(isset($opt['media'])?$opt['media']:'all').'" />'."\n";
        }
        return $txt;
    }


}