<?php

return [
    'title'=>'My default page title',
    'description'=>'My default page description',
    'keywords'=>['Laravel','PageHelper','default','keywords'],//Array or string

    //Set sections//
    'sections'=>[
        'htmlTagAttributes'=>'html.attributes',
        'bodyTagAttributes'=>'html.attributes',
        'head'=>'page.head',
        'footerScripts'=>null,
    ],

    'charset'=>'utf-8',

    //'icon'=>'favicon.ico',
    // OR as an array:
    // icon'=>['icon.png','icon.ico',],

    'meta'=>[
        'tags'=>[
            //'tag-name'=>'value',
            // OR for custom tag attributes
            //'tag-name1'=>['content'=>'value','attr'=>'attr-value'],
        ],
        'http-equiv'=>[
            //'tag-name'=>'value',
            // OR for custom tag attributes
            // 'tag-name1'=>['content'=>'value','attr'=>'attr-value'],
        ],
        'og'=>[
            //'og:propriety'=>'value',
            // OR for multiple values
            //'og:propriety'=>['value1','value2']
        ],
    ],
    'script'=>[
        'required'=>['app.js'],
    ],
    'style'=>[
        'required'=>['app.css'],
    ],
];