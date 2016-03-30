<?php
namespace plokko\PageHelper;

use \Exception;

/**
 * Wrapper class to defer the execution of some content in the view (allows the modification of page attributes and render thems only when casted to string in the final view rendering)
 * @package plokko\PageHelper
 */
class ViewBlock
{
    protected
        $content;

    function __construct($content)
    {
        $this->content=$content;
    }

    function render()
    {
        $content=$this->content;
        try{
            if(is_callable($content))
                return ''.$content();
            return ''.$content;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    function __toString()
    {
        return $this->render();
    }
}