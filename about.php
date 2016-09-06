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

            <h1 class="col-md-9 page-header">About E&amp;H Construction</h1>

            <article>
                <div class="col-md-9 hero" style="min-height:300px;background:url(../../images/projects/2014/05/randolph1.jpg)center center no-repeat;background-size:cover;">
                    &nbsp;
                </div>
                <header class="col-md-4">
                    <h1 class="headline">
                        Sustainable Builders &amp; Craftsmen
                    </h1>
                </header>
                <main class="col-md-5">
                    <h2 class="subheadline little-line mod-nomt">E&amp;H Construction</h2>
                    <p>
                        We take great pride in the quality and service we can provide the home owner and architects.
                        Many of our projects have been on difficult and challenging sites, constructed on steep slopes,
                        sensitive sites and waterfronts involving specialized shoring and construction techniques.
                    </p>
                    <p>
                        With over twenty years of "hands on" construction experience, we have diligently worked with
                        homeowners, architects, neighbors, subcontractors, government officials and the community to
                        make sure there is a successful outcome for all.  We at EH Construction prides ourselves on the
                        quality and diversity of the homes we have constructed. We have overcome many of the challenges
                        presented by the talented architects that we have built homes with.  Some of these challenges
                        have included slide, drainage and seismic issues.  Home designs that utilize as much of the site
                        as feasible and permissible, often require the seasoned experience necessary to execute bringing
                        in materials, and keeping neighbors at ease.
                    </p>
                    <p>
                        Traditional, contemporary, large or small we can make your dream a reality.
                    </p>
                </main>
            </article>
        </div>
    </div>

    <?php include BASE_URI.'/library/includes/framework/foot.inc.php'; ?>
    <?php include BASE_URI.'/library/includes/script.pack.php'; ?>
</body>
</html>