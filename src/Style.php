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
                $this->add($name,isset($opt['media'])?$opt['media']:'all');
            }
        }
    }

    function add($href,$media='all')
    {
        if($href==null)
            unset($this->styles[$media.'@'.$href]);
        else{
            $this->styles[$media.'@'.$href]=['href'=>$href,'media'=>$media];
        }
    }

    function render()
    {
        $txt='';
        foreach($this->styles AS $el)
        {
                //Auto prepent css folder if the filename does not start with /
                $url= url($el['href'][0]=='/'?'/':'css/'.$el['href']);

                $txt.="\t".'<link type="text/css" rel="stylesheet" href="'.htmlspecialchars($url).'" media="'.$el['media'].'" />'."\n";
        }
        return $txt;
    }


    function __toString()
    {
        return $this->render();
    }
}