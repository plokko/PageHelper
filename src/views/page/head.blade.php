<?$page=App::make('Page');?>
    {!!$page->meta()->charset->render()!!}
    <title>{{$page->title}}</title>

<?=$page->meta()->render()?>
<?=$page->links()->render()?>
<?=$page->style()->render()?>
<?=$page->script()->render()?>