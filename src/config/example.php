<?php

return [
    'title'=>'My default page title',
    'description'=>'My default page description',
    'lang'=>'en',
    'charset'=>'utf-8',
    //'icon'=>'favicon.ico', /*or as array: ['icon.png','icon.ico',..]*/
    'meta'=>[
        'tags'=>[
            //'tag-name'=>'value', /*OR*/ 'tag-name1'=>['content'=>'value','attr'=>'attr-value'],
        ],
        'http-equiv'=>[
            //'tag-name'=>'value', /*OR*/ 'tag-name1'=>['content'=>'value','attr'=>'attr-value'],
        ],
        'og'=>[
            //'og:propriety'=>'value', /*OR*/ 'og:propriety'=>['value1','value2']
        ],
    ],
    'script'=>[
        'required'=>['app.js'],
    ],
    'style'=>[
        'required'=>['app.css'],
    ],
];