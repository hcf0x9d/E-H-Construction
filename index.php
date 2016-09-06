<?php

include 'models/config.model.php';

// Currently just userAgent
include 'library/includes/config/functions.inc.php';

// Page Variables
$metaTitle = 'Title';
$metaDescr = 'Description';
$metaImage = 'IMAGE';

// HTML DocHead
include 'partials/dochead.inc.php';

$rotator = homeRotator();

?>

    <section class="container full-height">
        <div class="row">
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
        </div>
    </section>

    <ul id="rotator-images" class="m-0 rotator-images" style="">
        <?php echo $rotator['images']; ?>
    </ul>

    <?php include($path.'/library/includes/script.pack.php'); ?>
    <script src="/library/scripts/ehconstruction.js"></script>

</body>
</html>