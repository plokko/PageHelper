<?php

return [
    'title'=>'My default page title',
    'description'=>'My default page description',
    //Set sections//
    'sections'=>[
        'htmlTagAttributes'=>'html.attributes',
        'bodyTagAttributes'=>'html.attributes',
        'head'=>'page.head',
        'footerScripts'=>null,
    ],

    //'icon'=>'icon_url.png',

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