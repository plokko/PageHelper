<?php
namespace plokko\PageHelper;


class Page
{
    protected
        $title,
        $lang=null,

        $htmlTags=['html'=>[],'body'=>[]],

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

        foreach(['title','description','keywords','lang'] AS $k)
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

        ///- Style -///
        echo $this->style->render();

        ///- Js -///
        echo $this->script->render(false);



    }
    function renderFooter()
    {
        echo $this->script->render(true);
    }

}