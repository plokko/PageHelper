<?php
namespace plokko\PageHelper\ViewComposers;
use App;
use Illuminate\View\View;
use plokko\PageHelper\ViewBlock;
use plokko\PageHelper\Page;

class PageComposer
{

    public function __construct()
    {

    }

    public function compose(View $view)
    {
        $page=app('Page');
        /** @var $page Page */
        $view->with('page',$page);
        $factory=$view->getFactory();

        $deferredScripts=null;
        // Add deferred scripts to page footer //
        if($page->section('footerScripts'))
        {
            $deferredScripts=false;
            $factory->startSection($page->section('footerScripts'),
                new ViewBlock(function() use ($page){
                    return $page->script()->render(true);
                })
            );
        }
        
        $factory->startSection($page->section('htmlTagAttributes'),$page->htmlTagAttributes());
        $factory->startSection($page->section('bodyTagAttributes'),$page->bodyTagAttributes());

        //--Page head--//
        $factory->startSection($page->section('head'),
            new ViewBlock(function() use ($page,$deferredScripts)
            {
                return
                    "\t".$page->meta()->charset->render()."\n".
                    "\t<title>".htmlspecialchars($page->title)."</title>\n".
                    $page->meta()->render().
                    $page->links()->render().
                    $page->style()->render().
                    $page->script()->render($deferredScripts);
            })
        );


    }
}