<?php

/*
 * Fill this out and open or run (command line: 'php newpost.php') this file to create a new blog post.
 * To edit a post, enter that posts uid in the $post['uid'] field.
 *
*/

   $post['uid']           = "podcasts-april2013";
   $post['content']       = '<p>Podcasts I\'ve been listening to recently. Links are direct to the feeds.</p><ul><li><h3>Talk</h3><ul><li><a href="http://feeds.wnyc.org/radiolab">Radiolab</a> – very enjoyable show from New York public radio. Each episode investigates a different topic, often science related.</li><li><a href="http://downloads.bbc.co.uk/podcasts/fivelive/kermode/rss.xml">Kermode & Mayo Film Reviews</a> – weekly film news and review podcast from Mark Kermode and Simon Mayo\'s BBC 5Live radio show.</li><li><a href="http://feeds.wnyc.org/onthemedia">On The Media</a> – looking at different aspects of the media.</li></ul></li><li><h3>Tech</h3><ul><li><a href="http://feeds.feedburner.com/devhell-podcast">/dev/hell</a> – web development (with a leaning towards PHP) talking and ranting from Chris \'Grumpy Programmer\' Hartjes and Ed \'Funkatron\' Finkler.</li><li><a href="http://phptownhall.com/itunes.rss">PHP Town Hall</a> – php related talk with Phil Sturgeon and guests.</li><li><a href="http://feeds.feedburner.com/the_talk_show">The Talk Show</a> – the Daring Fireball podcast.</li></ul></li><li><h3>Tunes</h3><ul><li><a href="http://feeds.feedburner.com/kenmc">Stereo Mixtape</a> – music compiled by Ken McGuire</li><li><a href="http://feeds.feedburner.com/nialler9podcast">Nialler9</a> – music compiled by Nialler9</li></ul></li></ul>';
   $post['date']          = "April 19, 2013 19:25";
   $post['title']         = "Podcasts";
   $post['article_css']   = "";
   $post['template_file'] = false;
   $post['author']        = "Michael Flanagan";
   $post['categories']    = array(
      "Music",
      "Technology",
      "Podcasts"
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

