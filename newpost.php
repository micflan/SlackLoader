<?php

/*
 * Fill this out and open or run (command line: 'php newpost.php') this file to create a new blog post.
 * To edit a post, enter that posts uid in the $post['uid'] field.
 *
*/

   $post['uid']           = "four-tet-twitter-remix-playlist";
   $post['content']       = '<p>Four Tet tweeted the tracks he\'d put on a 2nd remixes CD <a href="https://twitter.com/fourtet">over on Twitter</a>.</p><blockquote class="twitter-tweet"><p>people asking if there\'s going to be a 2nd remixes comp... I can\'t see it happening I\'m afraid...</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327152972121387008">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>I\'ll give you the tracklist and you can burn your own copy though.</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327153049523068928">April 24, 2013</a></blockquote><p>These are the tracks:</p><blockquote class="twitter-tweet"><p>1. Thom Yorke - Atoms for peace (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327153280394334210">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>2. The xx - VCR (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327153332475027457">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>3. Caribou - Melody day (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327153416428195841">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>4. Neneh Cherry + The Thing - Dream baby dream (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327153557423923200">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>5. Roger O\'Donnell - Truth in you (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327153670837919744">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>6. RocketNumberNine - Matthew and Toby (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327153783220084738">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>7. Eluvium - The motion makes me last (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327153889495371776">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>8. Born Ruffians - I need a life (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327154005077803014">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>9. Bob Holroyd - African drug (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327154134404968448">April 24, 2013</a></blockquote><blockquote class="twitter-tweet"><p>10. Nathan Fake - You are here (Four Tet remix)</p>&mdash; Four Tet (@FourTet) <a href="https://twitter.com/FourTet/status/327154211064270848">April 24, 2013</a></blockquote><p>And here\'s a YouTube playlist of it all I put together:</p><iframe width="853" height="480" src="http://www.youtube.com/embed/TdyiZrVXa2M?list=PLZsMeHwq0hwOJj6oyUzx3uv8Wj6LLEKTP" frameborder="0" allowfullscreen></iframe>';
   $post['date']          = "April 24, 2013 22:08";
   $post['title']         = "Four Tet Twitter re-mix palylist";
   $post['article_css']   = "";
   $post['template_file'] = false;
   $post['author']        = "Michael Flanagan";
   $post['categories']    = array(
      "Music"
   );


/*
 * No need to edit below, but feel free to tinker :) – this is a very stop-gap solution.
*/


// Save json
file_put_contents('posts/'.$post['uid'].'.json', json_encode($post));


// Short data for postmaster file
$post_short = array (
    'uid'        => $post['uid'],
    'title'      => $post['title'],
    'date'       => $post['date'],
    'categories' => $post['categories'],
    'author'     => $post['author']
);

// Load existing postmaster data
$postmaster = json_decode(file_get_contents('postmaster.json'), true);

// Find existing post based on uid and update
$found = false;
foreach($postmaster as $key => $row) {
    if ($row['uid'] === $post['uid']) {
        $postmaster[$key] = $post;
        $found = true;
    }
}

// If not found, add to top of the list.
if ($found === false) {
    array_unshift($postmaster, $post_short);
}

// Save postmaster json
file_put_contents('postmaster.json', json_encode($postmaster));

// Print the post, just because.
print_r($post);

