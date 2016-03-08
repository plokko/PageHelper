<?php
namespace plokko\PageHelper;


class OGMetaTag
{

    protected
        $property,
        $content;

    /**
     * OpenGraph MetaTag constructor.
     * @param string $property
     * @param string|array $content
     */
    function __construct($property, $content)
    {
        $this->property = $property;
        $this->content = $content;
    }

    function render()
    {
        $txt='';
        $property=htmlspecialchars($this->property);

        foreach(is_array($this->content)?$this->content:[$this->content] as $v)
        {
            $txt.='<meta property="'.$property.'" content="'.htmlspecialchars($v).'" />'."\n";
        }

        return $txt;
    }

    function __toString()
    {
        return $this->render();
    }

}