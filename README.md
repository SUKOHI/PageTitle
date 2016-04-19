# PageTitle
A Laravel package to manage page title based on route name.  
(This is for Laravel 5+. [For Laravel 4.2](https://github.com/SUKOHI/PageTitle/tree/1.0))

# Installation

Execute composer command.

    composer require sukohi/page-title:2.*

Register the service provider in app.php

    'providers' => [
        ...Others...,  
        Sukohi\PageTitle\PageTitleServiceProvider::class,
    ]

Also alias

    'aliases' => [
        ...Others...,  
        'PageTitle' => Sukohi\PageTitle\Facades\PageTitle::class,
    ]
    
And then  execute the next command to publish the view

    php artisan vendor:publish

# Preparation

Set configuration values in config/page-title.php.

e.g)

    return [
    	'patterns' => [
    		'key.mode' => '{key} - {mode}',
    		'mode.key' => '{mode} - {key}',
    	],
    	'replacements' => [
    		'key' => [
    			'item' => 'Item',
    			'address' => 'Address',
    			'user' => 'User'
    		],
    		'mode' => [
    			'index' => 'List',
    			'create' => 'Insert',
    			'edit' => 'Update',
    			'show' => 'Confirmation'
    		]
    	]
    ];
    
In this case, for instance, if current route is `item.index` the page title you will get is `Item - List`.


# Usage

    $page_title = PageTitle::get();

You can specify `pattern name` like this.

    $page_title = PageTitle::get('mode.key');

You also can set specific route name.

    $page_title = PageTitle::get('mode.key', 'address.create');


# License

This package is licensed under the MIT License.

Copyright 2016 Sukohi Kuhoh