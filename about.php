<?php $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    userAgent($_SERVER['HTTP_USER_AGENT']);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>E&amp;H Construction | Sustainable custom home builders and craftsmen</title>
    
    <meta name="description" content="About Brent Heath and the E&amp;H Construction crew's 20 years of experience building sustainable custom homes .">
    
    <?php include($path.'/library/includes/style.pack.php'); ?>  
</head>
<body>
    <div class="container_12">
        <?php include($path.'/library/includes/framework/head.inc.php'); ?>
        
        <h1 class="grid_9 page-header">About E&amp;H Construction</h1>
            
        <article>    
            <div class="grid_9 hero" style="min-height:300px;background:url(../../images/projects/2014/05/randolph1.jpg)center center no-repeat;background-size:cover;">
                &nbsp;
            </div>
            <div class="grid_4">
                <h1 class="ta-r mt-20" style="font-size:3.5em;line-height:0.9em;">Sustainable Builders &amp; Craftsmen</h1>
            </div>
            <div role="main" class="grid_5">
                <h2 class="little-line mb-0">E&amp;H Construction</h2>
                <p class="mt-0">We take great pride in the quality and service we can provide the home owner and architects. Many of our projects have been on difficult and challenging sites, constructed on steep slopes, sensitive sites and waterfronts involving specialized shoring and construction techniques.</p>
                <p>With over twenty years of "hands on" construction experience, we have diligently worked with homeowners, architects, neighbors, subcontractors, government officials and the community to make sure there is a successful outcome for all.  We at EH Construction prides ourselves on the quality and diversity of the homes we have constructed. We have overcome many of the challenges presented by the talented architects that we have built homes with.  Some of these challenges have included slide, drainage and seismic issues.  Home designs that utilize as much of the site as feasible and permissible, often require the seasoned experience necessary to execute bringing in materials, and keeping neighbors at ease.</p>
                <p>Traditional, contemporary, large or small we can make your dream a reality.</p>
            </div>
        </article>
    </div>
    
    <?php include($path.'/library/includes/framework/foot.inc.php'); ?>
    <?php include($path.'/library/includes/script.pack.php'); ?>
</body>
</html>