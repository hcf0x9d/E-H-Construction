<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/functions.inc.php');
    userAgent($_SERVER['HTTP_USER_AGENT']);
    
    include($path.'/library/includes/config/connect.inc.php');

    $database = "ehconstr_ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $sql = 'SELECT ProjName, ProjLink, ProjKeyImg, ProjKeyImgUrl, ProjDescShort FROM project_nfo WHERE ProjFeatured = "1" ORDER BY PID DESC;';
            
    $data = mysql_query($sql) or die(mysql_error());
    
    $i = 1;

    $captions = '';    
    $images = '';    
    $dots = '';    

    while ($row = mysql_fetch_array($data)) {
        $ProjName = $row['ProjName'];
        $ProjLink = $row['ProjLink'];
        $ProjDescShort = $row['ProjDescShort'];
        
        if(strlen($ProjDescShort)>100)
        {
            $ProjDescShort=substr($ProjDescShort,0,100) . '...';
        }
        
        $KeyImage = $row['ProjKeyImgUrl'].$row['ProjKeyImg'];
        
        $captions .= '<li data-group="group'.$i.'">
                        <h2 class="c-outer-space mb-0 mt-0 little-line futura-book">'.$ProjName.'</h2>
                        <p class="mt-0 mb-0 c-natural-gray">'.$ProjDescShort.'</p>
                        <p class="mt-10 mb-0"><a href="/project/'.$ProjLink.'" class="link">Go to project</a></p>
                     </li>';
        $images .= '<li data-group="group'.$i.'" style="background: url('.$KeyImage.') center center no-repeat;background-size:cover;"></li>';
        
        $dots .='<li class="anim" data-selector="'.$i.'" onclick="rotateContent(\''.$i.'\');clearTimeout(timer);">'.$i.'</li>';
        
        $i++;
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>E&amp;H Construction</title>
	<meta name="description" content="Seattle based luxury home builders, E&amp;H Construction build sustainable, custom homes in the Seattle, Bothell, Bellevue and Redmond areas.">
	
    <style>
        /* For the rotator */
        .rotator-captions li{
            display:none;
            
        }
        #rotator-images li{
            display: none;  
            position: absolute; 
            left: 0;
            top: 0;
            width:100%;
            height:100%;
        }
        #rotator-images li.current{
            display: block; 
        }
        .rotator-captions li.current{
            display: block; 
            width:100%;
            height:100%;  
        }
    </style>
    <?php include($path.'/library/includes/style.pack.php'); ?>  
</head>
<body>
    <div class="container_12">
        <?php include($path.'/library/includes/framework/head.inc.php'); ?>
        
        <div class="grid_6">&nbsp;</div>
        <div class="grid_3 body-height pos-r">
            <div class="pos-a pos-se-corner w-100 mb-20" id="rotator-utilities">
                <div class="card mb-5 p-20">
                    <ul class="list-n rotator-captions m-0">
                        <?php echo $captions; ?>
                    </ul>
                </div>
                <ul class="h-list rotator-dots m-0 fl-r">
                    <?php echo $dots; ?>
                </ul>
            </div>
        </div>
    </div>
    <ul id="rotator-images" class="m-0" style="position: absolute;width: 100%;height: 100%;top: 0;z-index:-10;">
        <?php echo $images; ?>
    </ul>

    <?php include($path.'/library/includes/script.pack.php'); ?>

    <script>
        var timer;

        $(function(){
            rotatorInit();

            $('#rotator-utilities').mouseenter(function(){
                clearTimeout(timer);
            }).mouseleave(function(){
                timer = setTimeout(function(){
                    rotate();
                }, 5000);
            });
        });
    </script>
</body>
</html>