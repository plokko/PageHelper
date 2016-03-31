<?php
namespace plokko\PageHelper;


use Symfony\Component\DomCrawler\Link;

class Page
{
    protected
        $sections=[
            'htmlTagAttributes'=>'html.attributes',
            'bodyTagAttributes'=>'html.attributes',
            'head'=>'page.head',
            'footerScripts'=>null,
        ],

        $title,
        $lang=null,

        $htmlTags=['html'=>[],'body'=>[]],
        /**@var \plokko\PageHelper\Links **/
        $links,

        /**@var \plokko\PageHelper\Meta **/
        $meta,
        /**@var \plokko\PageHelper\Script **/
        $script,
        /**@var \plokko\PageHelper\Style **/
        $style;

    function __construct(array $cfg=[])
    {
        $this->meta   = app('Meta');
        $this->script = app('Script');
        $this->style  = app('Style');
        $this->links  =  new Links();

        foreach(['title','description','keywords','icon',] AS $k)
        {
            if(isset($cfg[$k]))
                $this->{$k}($cfg[$k]);
        }

        if(isset($cfg['sections']))
        {
            foreach($cfg['sections'] AS $k=>$v){
                if(isset($this->sections[$k]))
                    $this->sections[$k]=$v;
            }
        }
    }


    function __get($k)
    {
        switch($k)
        {
            case 'title':
                return $this->title;
            case 'charset':
            case 'description':
                $meta=$this->meta->{$k};
                return $meta?$meta->content:null;

            case 'keywords':
                $meta=$this->meta->{$k};
                return $meta?(is_array($meta->content)?implode(',',$meta->content):$meta->content):null;

            case 'lang':return $this->lang();

            default:
                return null;
        }
    }
    function __set($k,$v)
    {
        switch($k)
        {
            case 'title':
                $this->title($v);
            case 'keywords':
            case 'description':
                $this->meta->{$k}=$v;


            case 'lang':return $this->lang();

            default:
                return null;
        }
    }

    function title($title)
    {
        $this->title=$title;
    }

    function charset($charset='utf-8')
    {
        $this->meta->charset($charset);
    }


    function author($author)
    {
        $this->meta->add('author',$author);
    }

    function description($description)
    {
        $this->meta->add('description',$description);
    }

    function keywords($keywords)
    {
        $this->meta->add('keywords',$keywords);
    }

    function get($property, $content)
    {
        return $this;
    }

    function lang($locale=null)
    {
        if($locale)
            \App::setLocale($locale);

        return \App::getLocale();
    }

    /**
     * @return Meta
     */
    function meta()
    {
        return $this->meta;
    }
    /**
     * @return Script
     */
    function script()
    {
        return $this->script;
    }
    /**
     * @return Style
     */
    function style()
    {
        return $this->style;
    }

    /**
     * @return Links
     */
    function links()
    {
        return $this->links;
    }


    function getHtmlTagAttributes()
    {
        $tags=$this->htmlTags['html'];
        $tags['lang']=$this->lang();
        return $tags;
    }

    function getBodyTagAttributes()
    {
        return $this->htmlTags['body'];
    }

    function bodyTagAttributes()
    {
        $txt='';
        foreach($this->htmlTags['body'] AS $k=>$v)
            $txt.=$k.'="'.htmlspecialchars($v).'" ';
        return $txt;
    }
    function htmlTagAttributes()
    {
        $txt='';
        $attr=$this->htmlTags['html'];
        $attr['lang']=$this->lang();//automaticall adds lang attribute
        foreach($attr AS $k=>$v)
            $txt.=$k.'="'.htmlspecialchars($v).'" ';
        return $txt;
    }

    /**
     * Set a <html> tag, if null it will be unset
     * @param string $key
     * @param string|null $value
     */
    function setHtmlTagAttribute($key, $value)
    {
        $this->setTagAttribute('html',$key,$value);
    }

    /**
     * Set a <body> tag, if null it will be unset
     * @param string $key
     * @param string|null $value
     */
    function setBodyTagAttribute($key,$value)
    {
        $this->setTagAttribute('body',$key,$value);
    }

    private function setTagAttribute($section, $key, $value)
    {
        switch($section){
            case 'html':
            case 'body':
                if($value!==null)
                    $this->htmlTags[$section][$key]=$value;
                else
                    unset($this->htmlTags[$section][$key]);
            default:
        }
    }

    /**
     * @return array
     */
    public function sections($sections=null)
    {
        if($sections)
        {
            foreach($this->sections AS $k=>&$v)
            {
                if(isset($sections[$k]))
                    $v=$sections[$k];
            }
        }
        return $this->sections;
    }

    public function section($name,$value=null)
    {
        if($value)
        {
            if(isset($this->sections[$name]))
                $this->sections[$name]=$value;
        }
        return isset($this->sections[$name])?$this->sections[$name]:null;
    }



    function robots($robots=['index','follow'])
    {
        $this->meta->add('robots',$robots);
    }

    /**
     * Set alternate pages as lang=>url
     * @param array $alternate array of urls as lang=>url (es. [ 'en'=>'en.site.url','it'=>'it.site.url','es'=>'es.site.url',])
     */
    function alternate(array $alternate=[])
    {
        $alt=null;

        if(count($alternate)>0){
            $alt=[];
            foreach($alternate AS $lang=>$url)
                $alt[]=['href'=>$url,'hreflang'=>$lang];
        }

        $this->links->set('alternate',$alt);
    }

    function prev($url)
    {
        $this->links->set('prev',$url);
    }

    function next($url)
    {
        $this->links->set('next',$url);
    }

    /**
     * Set the page icon
     * @param string|array|null $icon url or array of urls of page icons (es. 'icon.ico' or ['icon.png','ico.ico'] )
     */
    function icon($icon)
    {
        $this->links->set('icon',$icon);
    }


}