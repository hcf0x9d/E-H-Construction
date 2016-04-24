<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    
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
        
        $KeyImage = $urlBase.'/'.$row['ProjKeyImgUrl'].$row['ProjKeyImg'];
        $Image = $urlBase.'/'.$row['ImageLink'].'480/'.$row['ImageName'];
        $ImageTitle = $row['ImageTitle'];
        $ImageCaption = $row['ImageCaption'];
        
        $images .='<li><img src="'.$Image.'" alt="'.$ImageTitle.'" /></li>';
        
    }
     // Find next and previous projects
    $sql = 'SELECT ProjLink FROM project_nfo WHERE PID = (SELECT max(PID) FROM project_nfo WHERE PID < '.$PID.');';
    $data = mysql_query($sql) or die(mysql_error());
    
    while($row = mysql_fetch_array($data)){
        $PrevProj = $row['ProjLink'];
    }
    
    $sql = 'SELECT ProjLink FROM project_nfo WHERE PID = (SELECT min(PID) FROM project_nfo WHERE PID > '.$PID.');';
    $data = mysql_query($sql) or die(mysql_error());
    while($row = mysql_fetch_array($data)){
        $NextProj = $row['ProjLink'];
    }
    if (!$NextProj == ''){
        $NextBtn = '<a href="'.$NextProj.'" class="c-white d-b w-100 pt-20 pb-20"><i class="fa fa-angle-right"></i></a>';
    }
    if (!$PrevProj == ''){
        $PrevBtn = '<a href="'.$PrevProj.'" class="c-white d-b w-100 pt-20 pb-20"><i class="fa fa-angle-left"></i></a>';
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
    <style>
        #ProjectGallery img{
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include($path.'/library/includes/framework/head.inc.php'); ?>
    <ul class="list-n w-100 d-ib ta-c bg-outer-space-50 d-t va-m mb-0 c-white mt-0" style="padding-top:82px;">
        <li class="d-tc va-m" style="width:15%;"><?php echo $PrevBtn; ?></li>
        <li class="d-tc va-m" style="width:70%;"><?php echo $ProjName; ?></li>
        <li class="d-tc va-m" style="width:15%;"><?php echo $NextBtn; ?></li>
    </ul>
    <article class="">    
        <div role="main" class="pl-20 pr-20">
            <h1 class="mb-0 mb-0 mt-20" style="font-size:3.5em;line-height:0.9em;"><?php echo $ProjName;?></h1>
            <span class="helper mt-10 d-b mb-0"><?php echo $ProjVendors; ?></span>
            <h2 class="little-line mb-0 mt-10"><?php echo $ProjDescShort; ?></h2>
            <p class="mt-0"><?php echo $ProjDescLong; ?></p>
        </div>
        <div class="mt-20">
            <ul id="ProjectGallery">
                <?php echo $images;?>
            </ul>
        </div>
    </article>
    
    <?php include($path.'/library/includes/framework/foot.inc.php'); ?>
</body>
<?php include($path.'/library/includes/script.pack.php'); ?>
</html>