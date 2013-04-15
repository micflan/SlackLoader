<?php

// The home page displays a list of recent blog posts.

if (!$posts = json_decode(file_get_contents(DIR . '../postmaster.json'))) {
    $posts = array();
}
$post_count = count($posts);
$tmpl = $wordrelease->getTemplateVars();

// Configure Pagination
if ($per_page = $wordrelease->config('posts_per_page')) {
    $posts = array_reverse($posts);
    $last_page = (int)ceil($post_count/$per_page);
    $uri = $wordrelease->parseUrl();

    if (strpos($uri, str_replace('/', '.', $wordrelease->config('posts_url_prefix')) . 'page.', 0) === 0) {
        $pagenum = (int)array_pop(explode('.', $uri));
    } else {
        $pagenum = $last_page;
    }

    $posts = array_slice($posts, ($pagenum-1)*$per_page, $wordrelease->config('posts_per_page'));
    $posts = array_reverse($posts);
}

// Display Pagination
?>
<ul class="pagination">
    <?php
        if (1 === $pagenum) {
            echo '<li class="previous disabled"><a href="/">&laquo;</a></li>';
        } else {
            echo '<li class="previous"><a href="/'.$wordrelease->config('posts_url_prefix').'page/'.($pagenum-1).'">&laquo;</a></li>';
        }

        $i = 1;
        while ($i <= $last_page) {
            echo '<li'.($i === $pagenum ? ' class="active"' : '').'><a href="/'.$wordrelease->config('posts_url_prefix').'page/'.$i.'">'.$i.'</a></li>';
            $i++;
        }

        if ($last_page === $pagenum) {
            echo '<li class="next disabled"><a href="/">&raquo;</a></li>';
        } else {
            echo '<li class="next"><a href="/'.$wordrelease->config('posts_url_prefix').'page/'.($pagenum+1).'">&raquo;</a></li>';
        }
    ?>
</ul>

<?php
// Show Posts
foreach($posts AS $row) {
    if ($post = $wordrelease->getArticle($row->uid)) {
        $data = $post['data'];
        include(DIR . $tmpl['_post_template']);
    }
}
