<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    userAgent($_SERVER['HTTP_USER_AGENT']);
    
    $p = $_GET['p'];
    
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
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E&amp;H Construction Projects | <?php echo $ProjName;?></title>
    
    <meta name="description" content="<?php echo $ProjDescShort; ?>">

    <?php include($path.'/library/includes/style.pack.php'); ?>  
    
</head>
<body>
    <div class="container_12" itemscope itemtype="http://schema.org/Thing">
        <?php include($path.'/library/includes/framework/head.inc.php'); ?>
        
        <h1 class="grid_9 page-header">Selected Projects</h1>
            
        <article class="grid_9">
            
            
            <div class="grid_9 alpha omega hero pos-r" style="min-height:300px;background:url(<?php echo $KeyImage; ?>)center center no-repeat;background-size:cover;">
                <h1 id="project" class="pos-a pos-sw-corner mb-0 pb-20 pl-20 text-shadow" style="font-size:3.5em;line-height:0.9em;" itemprop="name"><?php echo $ProjName;?></h1>
            </div>
            
            <div id="proj-navigator" class="grid_9 alpha omega bg-outer-space-50">
                <span><?php echo $PrevBtn; ?></span>
                <span id="ProjName"></span>
                <span><?php echo $NextBtn; ?></span>
            </div>
            
            <div role="main" class="grid_5 alpha">
                <span class="helper mt-10 d-b"><?php echo $ProjVendors; ?></span>
                
                <h2 class="little-line mb-0 mt-10" itemprop="description"><?php echo $ProjDescShort; ?></h2>
                <p class="mt-0"><?php echo $ProjDescLong; ?></p>
            </div>
            <div class="grid_4 omega">
                <ul id="ProjectGallery" class="gallery">
                    <?php echo $images;?>
                </ul>
            </div>
        </article>
    </div>
    
    <?php include($path.'/library/includes/framework/foot.inc.php'); ?>

    <?php include($path.'/library/includes/script.pack.php'); ?>
    <script>
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
    </script>
</body>
</html>