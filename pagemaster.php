<?php

/*
 * Pages.
 * Defaults can be overwritten for urls you define.
 * This allows you to create the "pages" of your site.
 *
 * To create sub-directories, replace forward-slashes with full-stops.
 * e.g. http://mysite.com/path/to/page becomes 'path.to.page' => array(...);
*/

$pages = array(

    // The page at 'http://yoursite.com/'. This is required.
    '_' => array(
        '_page'          => '../content/pages/home.php'
    ),

    // About page.
    'about' => array(
        '_page'      => '../content/pages/about.php',
        'page_title' => 'About',
        'nav_page'   => 'about',
        'page_id'    => 'pageAbout',
    ),

    // A page which generates an rss feed
    'feed' => array(
        '_page'      => '../content/pages/feed.php',
        '_page_header' => false,
        '_page_footer' => false,
    ),

    // 404 Not Found page. This is required.
    '_404' => array(
        '_page'      => '../content/pages/error404.php',
        'page_title' => 'Page Not Found – ' . $config['tmpl']['site_title'],
        'nav_page'   => 'error404',
        'page_id'    => 'pageError404',
    ),
);