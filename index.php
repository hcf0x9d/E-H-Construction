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

    <section class="container full-height mod-full-bleed">
        <div class="col-md-3">
            <?php include BASE_URI.'/library/includes/framework/head.inc.php'; ?>
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

    <?php include BASE_URI.'/library/includes/script.pack.php'; ?>
    <script src="/library/scripts/ehconstruction.js"></script>
    <script>
        var sliderSet = new Slider('rotator-images-item', 'rotator-card-captions-item', 'rotator-dots');
        var slideData = document.querySelectorAll('.rotator-card-captions-item');

        // slideData.forEach(function (v, i) {
        //     sliderSet.slides.push(v.dataset.project);
        // });
        for (var i = 0; i < slideData.length; i++) {
            sliderSet.slides.push($(slideData[i]).attr('data-project'));
        }

        sliderSet.run();

    </script>
</body>
</html>