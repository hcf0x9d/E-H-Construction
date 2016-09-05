<?php

include 'models/config.model.php';

// Currently just userAgent
include 'library/includes/config/functions.inc.php';

// HTML DocHead
include 'partials/dochead.inc.php';

$rotator = homeRotator();

?>

    <section class="container full-height">
        <div class="col-md-3">
            <?php include($path.'/library/includes/framework/head.inc.php'); ?>
        </div>

        <main class="col-md-3 col-md-push-6 full-height">
            <div class="rotator-controls">
                <div class="rotator-card mb-5 p-20">
                    <ul class="rotator-card-captions">

                        <?php echo $rotator['captions']; ?>
                    </ul>
                </div>
                <ul class="rotator-dots">
                    <?php echo $rotator['dots']; ?>
                </ul>
            </div>
        </main>
    </section>

    <ul id="rotator-images" class="m-0 rotator-images" style="">
        <?php echo $rotator['images']; ?>
    </ul>

    <?php include($path.'/library/includes/script.pack.php'); ?>
    <script src="/library/scripts/ehconstruction.js"></script>
    <script>
        var timer;

        $(function(){
            //rotatorInit();

            // $('#rotator-utilities').mouseenter(function(){
            //     clearTimeout(timer);
            // }).mouseleave(function(){
            //     timer = setTimeout(function(){
            //         rotate();
            //     }, 5000);
            // });
        });
    </script>
</body>
</html>