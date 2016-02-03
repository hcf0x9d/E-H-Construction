<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    userAgent($_SERVER['HTTP_USER_AGENT']);
    
    $u = $_GET['u'];
    
    include($path.'/library/includes/config/connect.inc.php');

    $database = "ehconstr_ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $sql = 'SELECT * FROM update_nfo u
            JOIN update_img i
            ON u.UID = i.fk_UID
            WHERE u.UpLink = "'.$u.'";';
            
    $data = mysql_query($sql) or die(mysql_error());
    
    $images = '';
    while ($row = mysql_fetch_array($data)) {
        $UpName = $row['UpName'];
        $UpDescShort = $row['UpDescShort'];
        $UpDescLong = $row['UpDescLong'];
        $UpVendors = $row['UpVendors'];
        
        $KeyImage = $row['UpKeyImgUrl'].$row['UpKeyImg'];
        $Image = $row['ImageLink'].'200/'.$row['ImageName'];
        $ImageTitle = $row['ImageTitle'];
        $ImageCaption = $row['ImageCaption'];
        
        $images .='<li><div class="img-cover anim lightbox"><i class="fa fa-search-plus c-white"></i></div><img src="'.$Image.'" class="" data-caption="'.$ImageCaption.'" data-title="'.$ImageTitle.'" /></li>';

    }
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E&amp;H Construction</title>
    
    <?php include($path.'/library/includes/style.pack.php'); ?>  
</head>
<body>
    <div class="container_12">
        <?php include($path.'/library/includes/framework/head.inc.php'); ?>
        
        <h1 class="grid_9 page-header">Selected Projects</h1>
            
        <article>    
            <div class="grid_9 alpha omega hero pos-r" style="min-height:300px;background:url(<?php echo $KeyImage; ?>)center center no-repeat;background-size:cover;">
                &nbsp;
            </div>
            <h1 class="ta-r mt-20 grid_4" style="font-size:3.5em;line-height:0.9em;"><?php echo $UpName; ?></h1>
            <div role="main" class="grid_5">
                <h2 class="little-line mb-0"><?php echo $UpDescShort; ?></h2>
                <p class="mt-0"><?php echo $UpDescLong; ?></p>
                <div class="clear"></div>
                <ul id="UpdateGallery" class="gallery w-100">
                    <?php echo $images;?>
                </ul>
            </div>
        </article>
    </div>
    
    <?php include($path.'/library/includes/framework/foot.inc.php'); ?>
</body>
<?php include($path.'/library/includes/script.pack.php'); ?>
</html>