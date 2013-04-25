<?php

// The home page displays a list of recent blog posts.

if (!$posts = json_decode(file_get_contents(DIR . 'postmaster.json'))) {
    $posts = array();
}
$post_count = count($posts);
$tmpl = $slack->getTemplateVars();

// Configure Pagination
if ($per_page = $slack->config('posts_per_page')) {
    $posts = array_reverse($posts);
    $last_page = (int)ceil($post_count/$per_page);
    $uri = $slack->uri;

    if (strpos($uri, 'page.', 0) === 0) {
        $pagenum = (int)array_pop(explode('.', $uri));
    } else {
        $pagenum = $last_page;
    }

    $posts = array_slice($posts, ($pagenum-1)*$per_page, $slack->config('posts_per_page'));
    $posts = array_reverse($posts);
}

if (empty($posts)) {
    header('Location: /404');
}


// Display Pagination
?>
<ul class="pagination">
    <?php
        if (1 === $pagenum) {
            echo '<li class="previous disabled"><a href="/">&laquo;</a></li>';
        } else {
            echo '<li class="previous"><a href="/page/'.($pagenum-1).'">&laquo;</a></li>';
        }

        $i = 1;
        while ($i <= $last_page) {
            echo '<li'.($i === $pagenum ? ' class="active"' : '').'><a href="/page/'.$i.'">'.$i.'</a></li>';
            $i++;
        }

        if ($last_page === $pagenum) {
            echo '<li class="next disabled"><a href="/">&raquo;</a></li>';
        } else {
            echo '<li class="next"><a href="/page/'.($pagenum+1).'">&raquo;</a></li>';
        }
    ?>
</ul>

<?php
// Show Posts
$i = count($posts)-1;
foreach($posts AS $key => $row) {
    if ($post = $slack->getArticle($row->uid)) {
        $data = $post['data'];
        $data['postnum'] = (string)((((int)$pagenum-1)*(int)$slack->config('posts_per_page')) + (int)$i+1);
        $data['nav_page'] = 'home';
        if ($i === count($posts)-1) {
            // die("$(document).ready(function() { $('#post-" . $post['data']['uid'] . "').addClass('active'); });");
            $toppost = $post['data'];
        }
        include(DIR . $tmpl['_post_template']);

        $i--;
    }
}

if ($pagenum === $last_page) {
    $data['javascript'] .= "$(document).ready(function() { $('#post-" . $toppost['uid'] . "').addClass('active'); });";
}