<?php $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    userAgent($_SERVER['HTTP_USER_AGENT']);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E&amp;H Construction | Contact Us</title>
    
    <meta name="description" content="Contact E&amp;H Construction for more details about projects and pricing">
    <?php include($path.'/library/includes/style.pack.php'); ?>  
</head>
<body>
    <div class="container_12">
        <?php include($path.'/library/includes/framework/head.inc.php'); ?>
        
        <h1 class="grid_9 page-header">Contact E&amp;H Construction</h1>
            
        <article>    
            <div class="grid_9 hero mb-40" style="min-height:300px;background:url(/images/brent.jpg)top center no-repeat;background-size:cover;">
                &nbsp;
            </div>
            <div class="grid_1">&nbsp;</div>
            <div class="grid_4">
                <div id="note"></div>
                <form id="form" action="/library/include/mailer.inc.php" method="post">
                
                    <input class="floatlabel ipt" name="contact-name" id="contact-name" type="text" placeholder="Your name" tabindex="1">
                    <input class="floatlabel ipt" name="contact-email" id="contact-email" type="email" placeholder="Email Address" tabindex="2">
                    <input autocomplete="off" class="floatlabel" name="contact-url" id="contact-url" type="url">
                    <textarea class="floatlabel ipt" name="contact-msg" id="contact-msg" rows="10" placeholder="Send us a message"></textarea>
                    <div id="load"></div>

                    <button id="form-submit" type="submit" class="btn anim" tabindex="5"><span class="d-ib" style="width:19px;text-align: center;"><i class="fa fa-envelope-o" style="margin-right: 5px;font-size: 1em;"></i></span> Send</button>
                </form>
            </div>
            <div class="grid_3" itemscope itemtype="http://schema.org/Person">
                <h2 class="little-line mb-0 mt-0" itemprop="name">Brent Heath</h2>
                <p class="mt-0">
                    <span itemprop="email">info<span class="at">{at}</span>ehconstructionco.com</span><br><br>
                    <span itemprop="telephone">phone: +1 425 486 4049</span><br>
                    <span itemprop="telephone">mobile: +1 206 234 1932</span>
                </p>
            </div>
        </article>
    </div>
    
    <?php include($path.'/library/includes/framework/foot.inc.php'); ?>

    <?php include($path.'/library/includes/script.pack.php'); ?>
    <script type="text/javascript" src="/library/scripts/floatlabels.min.js"></script>

    <!--[if lte IE 9]>
        <script>
            $(function(){
                $('input.ipt, textarea.ipt').each(function(){
                    var txt = $(this).attr('placeholder');
                    $(this).before(txt);
                });
            });
        </script>
    <![endif]-->



    <script>

    $(function(){

        $('input.floatlabel').floatlabel();

        $("#form-submit").on('click', function() {
            $('#form-submit span').empty().append('<img src="/images/ajax-loader.gif" alt="Currently Loading" id="loading" />');

            var note = $('#note'),
                n = $('#contact-name').val(),
                e = $('#contact-email').val(),
                u = $('#contact-url').val(),
                m = $('#contact-msg').val();

            $.ajax({
                type: "POST",
                url: "/library/includes/config/mail.inc.php",
                data: {n:n,e:e,u:u,m:m},
                success: function(msg) {
                    if ( note.height() ) {			
                        note.slideUp(250, function() { $(this).hide(); });

                    } 
                    else {
                        note.hide();

                    }

                    $('#form-submit span').empty().append('<i class="fa fa-envelope-o" style="margin-right: 5px;font-size: 1em;"></i>');

                    result = '<h1 class="mt-0" style="font-size:2em;">'+msg+'</h1>';

                    var i = setInterval(function() {
                        if ( !note.is(':visible') ) {
                            note.html(result).slideDown(250);
                            clearInterval(i);
                        }
                    }, 40);
                }
            });

            return false;
        });
    });
    </script>
</body>
</html>