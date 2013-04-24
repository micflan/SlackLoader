


    </div>
    <footer id="footer">
        <small>&copy; <?=date('Y');?> Michael Flanagan.</small>
    </footer>

    <?php if ($data['jquery'] === true) { ?>
        <script src="/vendor/jquery-2.0.0.min.js"></script>
    <?php } ?>

    <?php foreach ($data['include_js'] as $row) { ?>
        <script src="<?=$row;?>"></script>
    <?php } ?>

    <script>

    (function($) {
      var atTop = true;
        $(window).scroll(function(){
            // get the height of #wrap
            var h = $('body').height();
            var y = $(window).scrollTop();
            if( y > 209 && atTop == true){
                $('#stickyTop').slideDown('slow');
                console.log('top');
                atTop = false;
            } else if ( y < 209) {
                $('#stickyTop').slideUp('fast');
                atTop = true;
            }
        });
      })(jQuery);

        <?=$data['javascript'];?>
    </script>

    <script>

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-29694003-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>

</body>

</html>
