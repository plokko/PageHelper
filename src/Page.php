<?php
namespace plokko\PageHelper;


class Page
{
    protected
        $title,
        $lang=null,

        $htmlTags=['html'=>[],'body'=>[]],
        $links=[],

        /**@var \plokko\PageHelper\Meta **/
        $meta,
        /**@var \plokko\PageHelper\Script **/
        $script,
        /**@var \plokko\PageHelper\Style **/
        $style;

    function __construct(array $cfg=[])
    {
        $this->meta   = \App::make('Meta');
        $this->script = \App::make('Script');
        $this->style  = \App::make('Style');

        foreach(['title','description','keywords','lang','icon'] AS $k)
        {
            if(isset($cfg[$k]))
                $this->{$k}($cfg[$k]);
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



    function getHtmlTags()
    {
        $tags=$this->htmlTags['html'];
        $tags['lang']=$this->lang();
        return $tags;
    }

    function getBodyTags()
    {
        return $this->htmlTags['body'];
    }

    /**
     * Set a <html> tag, if null it will be unset
     * @param string $key
     * @param string|null $value
     */
    function setHtmlTag($key, $value)
    {
        $this->setTag('html',$key,$value);
    }

    /**
     * Set a <body> tag, if null it will be unset
     * @param string $key
     * @param string|null $value
     */
    function setBodyTag($key,$value)
    {
        $this->setTag('body',$key,$value);
    }

    private function setTag($section, $key, $value)
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

    function renderHead()
    {

        ///- Charset & title -///
        echo "\t",$this->meta->charset->render(),"\n";
        echo "\t"?><title><?=htmlspecialchars($this->title)?></title><?echo "\n";

        ///- Meta tags -///
        unset($this->meta['charset']);//remove charset
        echo $this->meta->render();

        $this->renderLinks();

        ///- Style -///
        echo $this->style->render();

        ///- Js -///
        echo $this->script->render(false);



    }
    function renderFooter()
    {
        echo $this->script->render(true);
    }

    protected function renderLinks()
    {
        foreach($this->links AS $name=>$link)
        {
            foreach($link AS $tags)
            {
                if(!is_array($tags))
                    $tags=['href'=>$tags];

                echo "\t";?><link rel="<?=$name?>" <?foreach($tags AS $k=>$v){echo $k,'="',htmlspecialchars($v),'" ';}?>/><?echo "\n";
            }
        }
    }


    function link($rel,$href)
    {
        if($href==null){
            unset($this->links[$rel]);
        }else{
            $links=is_array($href)?
                (isset($href['href'])?[$href]:$href)
                :[['href'=>$href]];
            $this->links[$rel]=$links;
        }
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

        $this->link('alternate',$alt);
    }

    function prev($url)
    {
        $this->link('prev',$url);
    }

    function next($url)
    {
        $this->link('next',$url);
    }

    /**
     * Set the page icon
     * @param string|array|null $icon url or array of urls of page icons (es. 'icon.ico' or ['icon.png','ico.ico'] )
     */
    function icon($icon)
    {
        $this->link('icon',$icon);
    }


}