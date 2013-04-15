
<article class="post-<?=$data['uid'];?> post status-publish" id="post-<?=$data['uid'];?>">

    <?php if ($tmpl['nav_page'] === 'home'): ?>
        <h2><a href="/<?=$data['uid'];?>"><?=$data['title'];?></a></h2>
    <?php else: ?>
        <h2><?=$data['title'];?></h2>
    <?php endif; ?>

    <div class="meta">
        <time><?=$data['date'];?></time>
        <span class="category-list"><?=$data['category_text'];?></span>
    </div>

    <div class="entry">
        <?=nl2br($data['content']);?>
    </div>

    <footer class="postmetadata">
        <?php if ($tmpl['nav_page'] === 'home'): ?>
            <!-- <div class="article-link"><a href="/<?=$data['uid'];?>">Read More &amp; Comment</a></div> -->
        <?php endif; ?>
    </footer>

</article>


<div id="respond">

   <!-- -->

</div>