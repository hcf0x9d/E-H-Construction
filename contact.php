<?php

include 'models/config.model.php';

// Currently just userAgent
include BASE_URI.'/library/includes/config/functions.inc.php';

// Return the data

// Page Variables
$metaTitle = 'Sustainable custom home builders and craftsmen | E&amp;H Construction Projects';
$metaDescr = 'About Brent Heath and the E&amp;H Construction crew\'s 20 years of experience building sustainable custom homes.';
$metaImage = 'IMAGE';

// HTML DocHead
include BASE_URI.'/partials/dochead.inc.php';

?>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include BASE_URI.'/library/includes/framework/head.inc.php'; ?>
            </div>

            <h1 class="col-md-9 page-header visible-md visible-lg">Contact E&amp;H Construction</h1>

        <article>
            <div class="col-md-9 hero mb-40 main" style="min-height:300px;background:url(/images/brent.jpg)top center no-repeat;background-size:cover;">
                &nbsp;
            </div>
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-4">
                <div id="note"></div>
                <form class="visible-md visible-lg" id="form" action="/library/include/mailer.inc.php" method="post">

                    <input class="floatlabel ipt input" name="contact-name" id="contact-name" type="text" placeholder="Your name" tabindex="1">
                    <input class="floatlabel ipt input" name="contact-email" id="contact-email" type="email" placeholder="Email Address" tabindex="2">
                    <input autocomplete="off" class="floatlabel input" name="contact-url" id="contact-url" type="url">
                    <textarea class="floatlabel ipt input" name="contact-msg" id="contact-msg" rows="10" placeholder="Send us a message"></textarea>
                    <div id="load"></div>

                    <button id="form-submit" type="submit" class="btn anim" tabindex="5"><span class="d-ib" style="width:19px;text-align: center;"><i class="fa fa-envelope-o" style="margin-right: 5px;font-size: 1em;"></i></span> Send</button>
                </form>
            </div>
            <div class="col-md-3" itemscope itemtype="http://schema.org/Person">
                <h2 class="subheadline little-line" itemprop="name">Brent Heath</h2>
                <!-- TODO: This should be a ul/li set instead of p/span -->
                <p class="mt-0">
                    <span itemprop="email">info<span class="at">{at}</span>ehconstructionco.com</span><br><br>
                    <span itemprop="telephone">phone: +1 425 486 4049</span><br>
                    <span itemprop="telephone">mobile: +1 206 234 1932</span>
                </p>
                <ul class="social">
                    <li class="social-item">
                        <a href="https://www.instagram.com/ehconstructionco/" class="social-target" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="social-icon">
                                <path d="M256 49.47c67.266 0 75.233.258 101.8 1.47 24.562 1.12 37.9 5.224 46.778 8.674a78.052 78.052 0 0 1 28.966 18.845 78.052 78.052 0 0 1 18.845 28.965c3.45 8.877 7.553 22.216 8.673 46.778 1.212 26.565 1.47 34.532 1.47 101.8s-.258 75.233-1.47 101.8c-1.12 24.562-5.225 37.9-8.674 46.778a83.427 83.427 0 0 1-47.812 47.812c-8.877 3.45-22.216 7.554-46.778 8.674-26.56 1.212-34.527 1.47-101.8 1.47s-75.237-.258-101.8-1.47c-24.562-1.12-37.9-5.225-46.778-8.674a78.05 78.05 0 0 1-28.966-18.845A78.053 78.053 0 0 1 59.61 404.58c-3.45-8.876-7.553-22.215-8.673-46.777-1.212-26.564-1.47-34.532-1.47-101.8s.258-75.233 1.47-101.8c1.12-24.562 5.224-37.9 8.674-46.778A78.052 78.052 0 0 1 78.46 78.458a78.053 78.053 0 0 1 28.966-18.845c8.877-3.45 22.216-7.554 46.778-8.674 26.565-1.213 34.532-1.47 101.8-1.47m0-45.39c-68.418 0-77 .29-103.866 1.515-26.815 1.224-45.127 5.482-61.15 11.71a123.488 123.488 0 0 0-44.62 29.057A123.488 123.488 0 0 0 17.3 90.982c-6.223 16.025-10.48 34.337-11.7 61.152C4.37 179 4.08 187.582 4.08 256s.29 77 1.52 103.866c1.224 26.815 5.482 45.127 11.71 61.15a123.49 123.49 0 0 0 29.057 44.62 123.486 123.486 0 0 0 44.62 29.058c16.025 6.228 34.337 10.486 61.15 11.71 26.87 1.226 35.45 1.516 103.867 1.516s77-.29 103.866-1.516c26.815-1.224 45.127-5.482 61.15-11.71a128.817 128.817 0 0 0 73.678-73.677c6.228-16.025 10.486-34.337 11.71-61.15 1.226-26.87 1.516-35.45 1.516-103.867s-.29-77-1.516-103.866c-1.224-26.815-5.482-45.127-11.71-61.15a123.486 123.486 0 0 0-29.057-44.62A123.487 123.487 0 0 0 421.02 17.3c-16.025-6.223-34.337-10.48-61.152-11.7C333 4.37 324.418 4.08 256 4.08z"/>
                                <path d="M256 126.635A129.365 129.365 0 1 0 385.365 256 129.365 129.365 0 0 0 256 126.635zm0 213.338A83.973 83.973 0 1 1 339.974 256 83.974 83.974 0 0 1 256 339.973z"/>
                                <circle cx="390.476" cy="121.524" r="30.23"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </article>

    </div>
    <!-- TODO: Fix this -->
        <br>
        <br>
        <br>
    <?php include BASE_URI.'/library/includes/framework/foot.inc.php'; ?>

    <?php include BASE_URI.'/library/includes/script.pack.php'; ?>
    <script src="/library/scripts/ehconstruction.js"></script>
    <!-- TODO: Replace this with my script that i wrote for Capital One -->
    <script src="/library/scripts/floatlabels.min.js"></script>

    <script>
        var mail = new FormMail('form');

    </script>
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

        // $("#form-submit").on('click', function() {
        //     $('#form-submit span').empty().append('<img src="/images/ajax-loader.gif" alt="Currently Loading" id="loading" />');

        //     var note = $('#note'),
        //         n = $('#contact-name').val(),
        //         e = $('#contact-email').val(),
        //         u = $('#contact-url').val(),
        //         m = $('#contact-msg').val();

        //     $.ajax({
        //         type: "POST",
        //         url: "/library/includes/config/mail.inc.php",
        //         data: {n:n,e:e,u:u,m:m},
        //         success: function(msg) {
        //             if ( note.height() ) {
        //                 note.slideUp(250, function() { $(this).hide(); });

        //             }
        //             else {
        //                 note.hide();

        //             }

        //             $('#form-submit span').empty().append('<i class="fa fa-envelope-o" style="margin-right: 5px;font-size: 1em;"></i>');

        //             result = '<h1 class="mt-0" style="font-size:2em;">'+msg+'</h1>';

        //             var i = setInterval(function() {
        //                 if ( !note.is(':visible') ) {
        //                     note.html(result).slideDown(250);
        //                     clearInterval(i);
        //                 }
        //             }, 40);
        //         }
        //     });

        //     return false;
        // });
    });
    </script>
</body>
</html>