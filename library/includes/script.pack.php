<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.5.3/modernizr.min.js"></script>

<script type="text/javascript" src="/library/scripts/scripts.js"></script>

<!--[if lt IE 9]>
   <script>
      document.createElement('header');
      document.createElement('nav');
      document.createElement('section');
      document.createElement('article');
      document.createElement('figure');
      document.createElement('figcaption');
      document.createElement('aside');
      document.createElement('footer');
   </script>
   <style>
       header, nav, section, article, aside, footer {
           display:block;
        }
   </style>
<![endif]-->
    
<script>
    $(function(){
        
        
        jQuery('a').removeAttr('title');
        jQuery('.at').empty().text('@');
        //$('img.replace').svgmagic();

        setNav();
        fullheight('body-height');
        
        $('.lightbox').on('click', function(){
            var src = $(this).siblings('img').attr('src');
            
            lightbox(src);
        });
        
        
    });
    $(window).resize(function(){
        fullheight('body-height');
    });
    
</script>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33217095-2', 'auto');
  ga('send', 'pageview');

</script>