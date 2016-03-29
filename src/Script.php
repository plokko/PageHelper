<?php
namespace plokko\PageHelper;

class Script
{
    protected
        $scripts=[];

    function __construct(array $cfg=[])
    {
    }

    function add($script,$opt=[])
    {
        $this->scripts[$script]=[
            'type'=>'script',
            'opt'=>$opt,
        ];
    }

    function render($deferred=null)
    {
        $txt='';
        foreach($this->scripts AS $name=>$script)
        {
            $opt=$script['opt'];
            $type=$script['type'];
            if( $deferred===null||!($deferred xor (isset($opt['deferred']) && $opt['deferred'])))
            {
                $url=(url($name[0]=='/'?'/':'js/'.$name));

                $tags='';

                foreach($opt AS $k=>$v){
                    switch($k){
                        case 'deferred':
                            if($deferred!==null)break;
                        case 'defer':
                            if($v)
                                $tags.='defer=defer ';
                            break;

                        default:
                            $tags.=$k.'="'.htmlspecialchars($v).'" ';break;

                    }
                }
                $txt.="\t".'<script src="'.htmlspecialchars($url).'" '.$tags.'></script>'."\n";
            }
        }
        return $txt;
    }

    function __toString()
    {
        return $this->render();
    }

}