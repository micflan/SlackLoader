<?php

/*
 * Pages.
 * Defaults can be overwritten for urls you define.
 * This allows you to create the "pages" of your site.
 *
 * To create sub-directories, replace forward-slashes with full-stops.
 * e.g. http://mysite.com/path/to/page becomes 'path.to.page' => array();
 *
 * Nothing more is required and defaults are determined based on the uri.
 * Alternatively, the following options can be set manually:

        '_page'          => 'pages/<array-key>.php', // location of template file
        '_page_header'   => '<$config['tmpl']['_page_header']>, // location of template file
        '_page_footer'   => '<$config['tmpl']['_page_footer']>, // location of template file

        'page_title'       => '<Array Key>', // used in <head>
        'nav_page'         => '<array-key>', // e.g. for applying active class to navigation item.
        'page_id'          => 'page<ArrayKey>', // applied to <body>
        'page_class'       => 'pageDefault', // applied to <body>
        'css'              => '', // appended to <head>
        'javascript'       => '', // appended to <body>
        'pagination'       => true, // Required for pagination. Routes trafic from /page/<num> to page/home.php.
        'top_level'        => false, // this page is only used for pagination. No top-level.

 * These and any other variables you sent will be available in your templates within the $data array.
 *
*/

$pages = array(

    // The page at 'http://yoursite.com/'. This is required.
    '_' => array(
        '_page'          => 'pages/home.php',
        'nav_page'       => 'home',
        'page_id'        => 'pageHome',
        'page_title'     => 'Home',
    ),

    'page' => array(
        '_page'          => 'pages/home.php',
        'nav_page'       => 'home',
        'page_id'        => 'pageHome',
        'pagination'     => true, // Required for pagination. Routes trafic from /page/<num> to page/home.php.
        'top_level'      => false, // this page is only used for pagination. No top-level.
    ),

    // About page.
    'about' => array(),

    // A page which generates an rss feed
    'feed' => array(
        '_page_header' => false,
        '_page_footer' => false,
    ),

    // 404 Not Found page. This is required.
    '404' => array(
        '_page'      => 'pages/error404.php',
        'page_title' => 'Page Not Found – ' . $config['tmpl']['site_title'],
        '_page_header' => false,
    ),
);

