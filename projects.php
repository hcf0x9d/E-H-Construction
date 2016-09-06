<?php

include 'models/config.model.php';

// Currently just userAgent
include 'library/includes/config/functions.inc.php';

// Page Variables
$metaTitle = 'E&amp;H Construction | Selected Projects';
$metaDescr = 'Selected sustainable luxury home projects by E&amp;H Construction';
$metaImage = 'IMAGE';

// HTML DocHead
include 'partials/dochead.inc.php';

?>

    <section class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include('/library/includes/framework/head.inc.php'); ?>
            </div>

            <h1 class="col-md-9 page-header">Selected Projects</h1>

            <ul class="col-md-9">
                <?php projectList(); ?>
            </ul>
        </div>
    </section>

    <?php include BASE_URI.'/library/includes/framework/foot.inc.php'; ?>

    <?php include BASE_URI.'/library/includes/script.pack.php'; ?>
</body>
</html>