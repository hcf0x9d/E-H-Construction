<?php
    
    $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    
    include($path.'/library/includes/config/connect.inc.php');

    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $sql = 'SELECT UpName, UpLink, UpKeyImg, UpKeyImgUrl, DateAdded, UpDescShort FROM update_nfo;';
            
    $data = mysql_query($sql) or die(mysql_error());
    
    $cards = '';
    
    while ($row = mysql_fetch_array($data)) {
        $UpName = $row['UpName'];
        $UpLink = $row['UpLink'];
        $UpDescShort = $row['UpDescShort'];
        $UpDate = date('l jS F, Y',strtotime($row['DateAdded']));
        $KeyImage = $urlBase.'/'.$row['UpKeyImgUrl'].'480/'.$row['UpKeyImg'];
        
        $card = '
        <a href="/update/'.$UpLink.'" class="picture-card pos-r d-b mb-10 c-white" style="height:200px;background:url('.$KeyImage.')center center no-repeat;background-size:cover;">
            <h2 class="pos-a pos-sw-corner p-20 m-0" style="z-index:10">'.$UpName.' <i class="fa fa-angle-right"></i></h2>
            <div class="pos-a anim card-cover"></div>
        </a>';
        
        $cards .= $card;
    }
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>E&amp;H Construction</title>
    
    <?php include('/library/includes/style.pack.php'); ?>  
</head>
<body>
    <?php include('/library/includes/framework/head.inc.php'); ?>
    
    <h1 class="page-header pl-20" style="margin-top:102px;font-size:1em;">Selected Projects</h1>
    <?php echo $cards; ?>
    
    <?php include($path.'/library/includes/framework/foot.inc.php'); ?>
</body>
<?php include($path.'/library/includes/script.pack.php'); ?>
</html>