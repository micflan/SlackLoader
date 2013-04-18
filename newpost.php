<?php

/*
 * Fill this out and open or run (command line: 'php newpost.php') this file to create a new blog post.
 * To edit a post, enter that posts uid in the $post['uid'] field.
 *
*/

   $post['uid']           = "my-new-post";
   $post['content']       = '
This is the content of my blog post.

It has <a href="http://example.com">a link</a> in it.
';
   $post['date']          = "April 16, 2013 09:39";
   $post['title']         = "My New Post";
   $post['article_css']   = "";
   $post['template_file'] = false;
   $post['author']        = "John Smith";
   $post['categories']    = array(
      "Meaningful",
      "Categories"
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

