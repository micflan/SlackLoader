<?php

// The home page displays a list of recent blog posts.

$posts = json_decode(file_get_contents(DIR . 'postmaster.json'));
$post_count = count($posts);
$tmpl = $slack->getTemplateVars();

include(DIR . "system/vendor/FeedWriter/FeedTypes.php");

//Creating an instance of RSS2FeedWriter class.
//The constant RSS2 is passed to mention the version
$feed = new RSS2FeedWriter();

//Setting the channel elements
//Use wrapper functions for common channel elements
$feed->setTitle($tmpl['site_title']);
$feed->setLink($tmpl['site_address']);
$feed->setDescription($tmpl['site_description']);

//Image title and link must match with the 'title' and 'link' channel elements for RSS 2.0
// $feed->setImage('Testing the RSS writer class','http://www.ajaxray.com/projects/rss','http://www.rightbrainsolution.com/_resources/img/logo.png');

//Use core setChannelElement() function for other optional channels
$feed->setChannelElement('language', 'en-us');
$feed->setChannelElement('pubDate', date(DATE_RSS, time()));

foreach ($posts as $row) {
    if ($post = $slack->getArticle($row->uid)) {
        $post = $post['data'];

        //Create an empty FeedItem
        $newItem = $feed->createNewItem();

        //Add elements to the feed item
        //Use wrapper functions to add common feed elements
        $newItem->setTitle($post['title']);
        $newItem->setLink($tmpl['site_address'] . $slack->config('posts_url_prefix') . $post['uid']);
        //The parameter is a timestamp for setDate() function
        $newItem->setDate(strtotime($post['date']));
        $newItem->setDescription($post['content']);
        $newItem->addElement('author', $post['Michael Flanagan']);
        //Attributes have to passed as array in 3rd parameter
        $newItem->addElement('guid', $tmpl['site_address'] . $slack->config('posts_url_prefix') . $post['uid'], array('isPermaLink'=>'true'));

        //Now add the feed item
        $feed->addItem($newItem);
    }
}

//OK. Everything is done. Now genarate the feed.
$feed->generateFeed();
