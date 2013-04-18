<?php

/*
 * Review these configuration and default settings and edit them to your liking.
 */

$config =  array(
    'posts_dir'         => 'posts/', // The location of the post json files, relative to public/index..php
    'posts_url_prefix'  => 'post/', // e.g. 'posts/' for urls like http://mywebsite.com/posts/my-article
    'posts_per_page'    => '10', // The number of posts displayed on the home page before pagination

    // Template settings
    'tmpl'            => array(
        // File locations, relative to public/index.php
        '_post_template' => 'system/template/post.php',
        '_page_header'   => 'system/template/header.php',
        '_page_footer'   => 'system/template/footer.php',

        // Default template variables.
        'site_title'       => 'Michael Flanagan', // used in <head>
        'site_address'     => 'http://micflan.com/', // used in feed and some links
        'site_description' => 'Personal blog.', // used in feed
        'site_author'      => 'Michael Flanagan', // your name.
        'page_title'       => 'Home', // used in <head>
        'nav_page'         => 'home', // e.g. for applying active class to navigation item.
        'page_id'          => 'pageHome', // applied to <body>
        'page_class'       => 'pageDefault', // applied to <body>
        'css'              => '', // appended to <head>
        'javascript'       => '', // appended to <body>
        'enable_disqus'    => false, // set to true on any page or post to dispaly comments from Disqus.com
        'disqus_shortname' => 'michaelflanagan', // your disqus.com shortname. Required for comments.
    )
);




/*
 * NO NEED TO EDIT BELOW THIS LINE
 */


define('DIR', dirname(__FILE__) . '/');
require_once(DIR . 'system/vendor/autoload.php');
require_once(DIR . 'system/SlackLoader.php');
$slack = new SlackLoader($config);


/**
 * Start.
 * This loads the view.
 *
 * @return void
 * @author Michael Flanagan (michael@flanagan.ie)
 **/
function start($slack)
{
    $data = $slack->getPageData();

    if ($slack->getTemplateHeader()) include(DIR . $slack->getTemplateHeader());
    include(DIR . $slack->getTemplateBody());
    if ($slack->getTemplateFooter()) include(DIR . $slack->getTemplateFooter());
}