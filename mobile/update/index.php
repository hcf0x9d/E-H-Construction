<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    
    $u = $_GET['u'];
    
    include($path.'/library/includes/config/connect.inc.php');

    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $sql = 'SELECT * FROM update_nfo u
            JOIN update_img i
            ON u.UID = i.fk_UID
            WHERE u.UpLink = "'.$u.'";';
            
    $data = mysql_query($sql) or die(mysql_error());
    
    $images = '';
    while ($row = mysql_fetch_array($data)) {
        $UID = $row['UID'];
        $UpName = $row['UpName'];
        $UpDescShort = $row['UpDescShort'];
        $UpDescLong = $row['UpDescLong'];
        $UpVendors = $row['UpVendors'];
        
        $Image = $urlBase.'/'.$row['ImageLink'].'480/'.$row['ImageName'];
        $ImageTitle = $row['ImageTitle'];
        $ImageCaption = $row['ImageCaption'];
        
        $images .='<li><img src="'.$Image.'" /></li>';

    }
     // Find next and previous updates
    $sql = 'SELECT UpLink FROM update_nfo WHERE UID < '.$UID.';';
    $data = mysql_query($sql) or die(mysql_error());
    
    while($row = mysql_fetch_array($data)){
        $PrevProj = $row['ProjLink'];
    }
    
    $sql = 'SELECT UpLink FROM update_nfo WHERE UID > '.$UID.';';
    $data = mysql_query($sql) or die(mysql_error());
    while($row = mysql_fetch_array($data)){
        $NextProj = $row['ProjLink'];
    }
    if (!$NextUpdate == ''){
        $NextBtn = '<a href="'.$NextUpdate.'" class="c-white d-b w-100 pt-20 pb-20"><i class="fa fa-angle-right"></i></a>';
    }
    if (!$PrevUpdate == ''){
        $PrevBtn = '<a href="'.$PrevUpdate.'" class="c-white d-b w-100 pt-20 pb-20"><i class="fa fa-angle-left"></i></a>';
    } else {
        $PrevBtn = '<a href="javascript:void(0);" class="c-white d-b w-100 pt-20 pb-20">&nbsp;</a>';
    }
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>E&amp;H Construction</title>
    
    <?php include($path.'/library/includes/style.pack.php'); ?>  
</head>
<body>
    <?php include($path.'/library/includes/framework/head.inc.php'); ?>
        <ul class="list-n w-100 d-ib ta-c bg-outer-space-50 d-t va-m mb-0 c-white mt-0" style="padding-top:82px;">
            <li class="d-tc va-m" style="width:15%;"><?php echo $PrevBtn; ?></li>
            <li class="d-tc va-m" style="width:70%;"><?php echo $UpName; ?></li>
            <li class="d-tc va-m" style="width:15%;"><?php echo $NextBtn; ?></li>
        </ul>
        <article class="">    
            <div role="main" class="pl-20 pr-20">
                <h1 class=""><?php echo $UpName; ?></h1>
                <h2 class="little-line mb-0"><?php echo $UpDescShort; ?></h2>
                <p class="mt-0"><?php echo $UpDescLong; ?></p>
            </div>
            <div class="mt-20">
                <ul id="UpdateGallery">
                    <?php if($images){echo $images;};?>
                </ul>
            </div>
        </article>
        <ul class="list-n w-100 d-ib ta-c bg-outer-space-50 d-t va-m mb-0 c-white mt-60" style="">
            <li class="d-tc va-m" style="width:15%;"><?php echo $PrevBtn; ?></li>
            <li class="d-tc va-m" style="width:70%;">&nbsp;</li>
            <li class="d-tc va-m" style="width:15%;"><?php echo $NextBtn; ?></li>
        </ul>
    </div>
    
    <?php include($path.'/library/includes/framework/foot.inc.php'); ?>
</body>
<?php include($path.'/library/includes/script.pack.php'); ?>
</html>