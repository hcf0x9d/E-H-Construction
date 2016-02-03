<?php
    
    $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    userAgent($_SERVER['HTTP_USER_AGENT']);

    include($path.'/library/includes/config/connect.inc.php');

    $database = "ehconstr_ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $sql = 'SELECT ProjName, ProjLink, ProjKeyImg, ProjKeyImgUrl FROM project_nfo;';
            
    $data = mysql_query($sql) or die(mysql_error());
    
    $cards = '';
    
    while ($row = mysql_fetch_array($data)) {
        $ProjName = $row['ProjName'];
        $ProjLink = $row['ProjLink'];
        $KeyImage = $row['ProjKeyImgUrl'].'480/'.$row['ProjKeyImg'];
        
        $card = '
        <a href="/project/'.$ProjLink.'" class="grid_3 picture-card pos-r d-b c-white mb-20" style="height:200px;background:url('.$KeyImage.')center center no-repeat;background-size:cover;">
            <h2 class="pos-a pos-sw-corner p-20 m-0" style="z-index:10">'.$ProjName.'</h2>
            <div class="pos-a anim card-cover"></div>
        </a>';
        
        $cards .= $card;
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E&amp;H Construction | Selected Projects</title>
    <meta name="description" content="Selected sustainable luxury home projects by E&amp;H Construction">
    
    <?php include($path.'/library/includes/style.pack.php'); ?>  
</head>
<body>
    <div class="container_12">
        <?php include($path.'/library/includes/framework/head.inc.php'); ?>
        
        <h1 class="grid_9 page-header">Selected Projects</h1>
        <div class="grid_9">
            <?php echo $cards; ?>
        </div>
    </div>
    
    <?php include($path.'/library/includes/framework/foot.inc.php'); ?>

    <?php include($path.'/library/includes/script.pack.php'); ?>
    <script>
        $(function(){
            $('.picture-card:nth-child(3n+1)').addClass('alpha');
            $('.picture-card:nth-child(3n+3)').addClass('omega');
        });
    </script>
</body>
</html>