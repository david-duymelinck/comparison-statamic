<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sites
    |--------------------------------------------------------------------------
    |
    | Each site should have root URL that is either relative or absolute. Sites
    | are typically used for localization (eg. English/French) but may also
    | be used for related content (eg. different franchise locations).
    |
    */

    'sites' => [

        '1 en' => [
            'name' => '1 en',
            'locale' => 'en',
            'url' => env('APP_URL') . '/',
            'attributes' => [
                'group' => 1,
                ]
        ],

        '1 nl' => [
            'name' => '1 nl',
            'locale' => 'nl',
            'url' => env('APP_URL') . '/nl/',
            'attributes' => [
            'group' => 1,
                ]
        ],

        '1 fr' => [
            'name' => '1 fr',
            'locale' => 'fr',
            'url' => env('APP_URL') . '/fr/',
            'attributes' => [
                'group' => 1,
            ],
        ],

        '2 en' => [
            'name' => '2 en',
            'locale' => 'en',
            'url' => env('APP_URL2') . '/',
            'attributes' => [
            'group' => 2,
                ]
        ],

        '2 nl' => [
            'name' => '2 nl',
            'locale' => 'nl',
            'url' => env('APP_URL2') . '/nl/',
            'attributes' => [
            'group' => 2,
                ]
        ],

        '2 fr' => [
            'name' => '2 fr',
            'locale' => 'fr',
            'url' => env('APP_URL2') . '/fr/',
            'attributes' => [
            'group' => 2,
                ]
        ],

    ],
];
