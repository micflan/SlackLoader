
<article class="post-<?=$data['uid'];?> post status-publish" id="post-<?=$data['uid'];?>">

    <?php if ($data['nav_page'] === 'home'): ?>
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
        <?php if ($data['nav_page'] === 'home'): ?>
            <!-- <div class="article-link"><a href="/<?=$data['uid'];?>">Read More &amp; Comment</a></div> -->
        <?php endif; ?>
    </footer>

</article>


<div id="comments">

    <?php
    if ($data['disqus_shortname'] and $data['enable_disqus']) { ?>
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = '<?=$data['disqus_shortname'];?>'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
    <?php
    } ?>

</div>