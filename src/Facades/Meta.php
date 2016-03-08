<?php
namespace plokko\PageHelper\Facades;

use Illuminate\Support\Facades\Facade;

class Meta extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Meta';
    }
}