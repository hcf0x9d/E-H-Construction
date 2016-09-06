<?php

include '../models/config.model.php';

// Currently just userAgent
include BASE_URI.'/library/includes/config/functions.inc.php';

$project = projectDetail();

// $p = $_GET['p'];

// Return the data

// Page Variables
$metaTitle = 'E&amp;H Construction Projects | ';
$metaDescr = 'Selected sustainable luxury home projects by E&amp;H Construction';
$metaImage = 'IMAGE';

// HTML DocHead
include BASE_URI.'/partials/dochead.inc.php';



/*
    include($path.'/library/includes/config/connect.inc.php');

    $database = "ehconstr_ehconstruction";
    mysql_select_db("$database") or die(mysql_error());

    $sql = 'SELECT * FROM project_nfo p
            JOIN project_img i
            ON p.PID = i.fk_PID
            WHERE p.ProjLink = "'.$p.'";';

    $data = mysql_query($sql) or die(mysql_error());

    $images = '';
    while ($row = mysql_fetch_array($data)) {
        $PID = $row['PID'];
        $ProjName = $row['ProjName'];
        $ProjDescShort = $row['ProjDescShort'];
        $ProjDescLong = $row['ProjDescLong'];
        $ProjVendors = $row['ProjVendors'];

        $KeyImage = $row['ProjKeyImgUrl'].$row['ProjKeyImg'];
        $ImageName = $row['ImageName'];
        $Image = $row['ImageLink'].'200/'.$row['ImageName'];
        $ImageTitle = $row['ImageTitle'];
        $ImageCaption = $row['ImageCaption'];

        $images .='<li><div class="img-cover anim lightbox"><i class="fa fa-search-plus c-white"></i></div><img src="'.$Image.'" class="" data-caption="'.$ImageCaption.'" data-title="'.$ImageTitle.'" alt="'.$ImageTitle.'" data-name="'.$ImageName.'" itemprop="image" /></li>';
    }

     // Find next and previous projects
    $sql = 'SELECT ProjLink, ProjName FROM project_nfo WHERE PID = (SELECT max(PID) FROM project_nfo WHERE PID < '.$PID.');';
    $data = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($data)){
        $PrevProj = $row['ProjLink'];
        $PrevName = $row['ProjName'];
    }
    $sql = 'SELECT ProjLink, ProjName FROM project_nfo WHERE PID = (SELECT min(PID) FROM project_nfo WHERE PID > '.$PID.');';
    $data = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($data)){
        $NextProj = $row['ProjLink'];
        $NextName = $row['ProjName'];
    }

    if (!$NextProj == ''){
        $NextBtn = '<a class="anim" href="'.$NextProj.'" data-name="'.$NextName.'"><i class="fa fa-angle-right"></i></a>';
    }
    if (!$PrevProj == ''){
        $PrevBtn = '<a class="anim" href="'.$PrevProj.'" data-name="'.$PrevName.'"><i class="fa fa-angle-left"></i></a>';
    } else {
        $PrevBtn = '<a href="javascript:void(0);" style="background: rgba(255,255,255,0) !important;cursor: default !important;">&nbsp;</a>';
    }
    */
?>

    <div class="container" itemscope itemtype="http://schema.org/Thing">
        <div class="col-md-3">
            <?php include BASE_URI.'/library/includes/framework/head.inc.php'; ?>
        </div>

        <h1 class="col-md-9 page-header">Selected Projects</h1>

        <article class="col-md-9">

            <!-- TODO: Make the background image a srcset so that we can utilize responsive images -->
            <div class="col-md-9 hero" style="min-height:300px;background:url(<?php echo $project['details']['hero'];?>)center center no-repeat;background-size:cover;">
                <h1 id="project" class="pos-a pos-sw-corner mb-0 pb-20 pl-20 text-shadow" style="font-size:3.5em;line-height:0.9em;" itemprop="name"><?php echo $project['details']['name'];?></h1>
            </div>

            <!-- TODO: Hook up the navigator -->
            <div id="proj-navigator" class="col-md-9 alpha omega bg-outer-space-50">
                <span><?php // echo $PrevBtn; ?></span>
                <span id="ProjName"></span>
                <span><?php // echo $NextBtn; ?></span>
            </div>

            <!-- TODO: Some display bugs on this page -->
            <div role="main" class="col-md-5">
                <span class="helper mt-10 d-b"><?php echo $project['details']['vendors'];?></span>

                <h2 class="little-line mb-0 mt-10" itemprop="description"><?php echo $project['details']['summary'];?></h2>
                <p class="mt-0"><?php echo $project['details']['description'];?></p>
            </div>
            <div class="col-md-4 omega">
                <!-- TODO: Gallery display issues abound -->
                <ul id="ProjectGallery" class="gallery">
                    <?php print_r($project['images']);?>
                </ul>
            </div>
        </article>
    </div>

    <?php
        include BASE_URI.'/library/includes/framework/foot.inc.php';
        include BASE_URI.'/library/includes/script.pack.php';
    ?>
    <!-- <script>
        $(function(){
            $('#ProjName').fadeOut(0);
            $('#proj-navigator a').mouseenter(function(){
                var n = $(this).data('name')
                var c = $('#ProjName').text();

                if(n != c){
                $('#ProjName').fadeOut(250, function(){
                    $('#ProjName').empty().text(n);
                    $('#ProjName').stop(true,false).fadeIn(250);
                });
                }
            });
            $('#proj-navigator').mouseleave(function(){
                $('#ProjName').stop(true,false).fadeOut(250, function(){
                    $(this).empty();
                });
            });
        });
    </script> -->
</body>
</html>