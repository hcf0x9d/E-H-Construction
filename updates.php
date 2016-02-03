<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    
    userAgent($_SERVER['HTTP_USER_AGENT']);

function updateList()
{
    
 $path = $_SERVER['DOCUMENT_ROOT'];
    
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
        $KeyImage = $row['UpKeyImgUrl'].'480/'.$row['UpKeyImg'];
        
        $card = '
        <div class="grid_9 card pos-r d-t">
            <div class="d-tc va-m" style="background:url('.$KeyImage.')center center no-repeat;background-size:cover;width:200px;">
            </div>
            <div class="d-tc pl-20 pos-r va-m pt-40 pb-20">
                <h2 class="c-outer-space little-line mt-0 mb-0">'.$UpName.'</h2>
                <span class="helper c-natural-gray mt-0 mb-10 d-b" style="font-size:1rem;">'.$UpDate.'</span>
                <p class="c-natural-gray mt-0 mb-0">'.$UpDescShort.'</p>
                <a href="/update/'.$UpLink.'" class="link">Read more</a>
            </div>
        </div>';
        
        $cards .= $card;
    }
    echo $cards;
    mysql_close();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E&amp;H Construction</title>
    
    <?php include('/library/includes/style.pack.php'); ?>  
</head>
<body>
    <div class="container_12">
        <?php include('/library/includes/framework/head.inc.php'); ?>
        
        <h1 class="grid_9 page-header">Selected Projects</h1>
        
        <?php updateList(); ?>
        
    </div>
    
    <?php include($path.'/library/includes/framework/foot.inc.php'); ?>
</body>
<?php include($path.'/library/includes/script.pack.php'); ?>
</html>