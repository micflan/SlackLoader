<?php

$config =  array(
    'posts_dir'         => '../posts/', // The location of the post json files, relative to public/index..php
    'posts_url_prefix'  => '', // e.g. 'posts/' for urls like http://mywebsite.com/posts/my-article
    'posts_per_page'    => '5', // The number of posts displayed on the home page before pagination
    'pagination_prefix' => 'page/', // e.g. 'page/' for urls like http://mywebsite.com/posts/page/2

    // Template settings
    'tmpl'            => array(
        // File locations, relative to public/index.php
        '_post_template' => '../system/template/post.php',
        '_page_header'   => '../system/template/header.php',
        '_page_footer'   => '../system/template/footer.php',

        // Default template variables.
        'site_title'       => 'My Website', // used in <head>
        'site_address'     => 'http://mywebsite.com/', // used in feed and some links
        'site_description' => 'My personal website.', // used in feed
        'site_author'      => 'John Smith', // your name.
        'page_title'       => 'Home', // used in <head>
        'nav_page'         => 'home', // e.g. for applying active class to navigation item.
        'page_id'          => 'pageHome', // applied to <body>
        'page_class'       => 'pageDefault', // applied to <body>
        'css'              => '', // appended to <head>
        'javascript'       => '', // appended to <body>
    )
);
