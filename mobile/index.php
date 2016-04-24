<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/functions.inc.php');
    
    include($path.'/library/includes/config/connect.inc.php');

    $database = "ehconstr_ehconstruction";
    
    mysql_select_db("$database") or die(mysql_error());
    
    $sql = 'SELECT ProjName, ProjLink, ProjKeyImg, ProjKeyImgUrl, ProjDescShort
            FROM project_nfo WHERE ProjFeatured = "1" ORDER BY PID DESC;';
            //WHERE ProjFeatured = "1";';
            
    $data = mysql_query($sql) or die(mysql_error());
    
    $i = 1;
    
    while ($row = mysql_fetch_array($data)) {
        $ProjName = $row['ProjName'];
        $ProjLink = $row['ProjLink'];
        $ProjDescShort = $row['ProjDescShort'];
        
        $KeyImage = $urlBase.'/'.$row['ProjKeyImgUrl'].$row['ProjKeyImg'];
        
        $captions .= '<li data-group="group'.$i.'" class="p-10">
                        <h2 class="c-white mb-0 mt-0 little-line futura-book">'.$ProjName.'</h2>
                        <p class="mt-5 mb-0"><a href="/project/'.$ProjLink.'" class="link">Go to project</a></p>
                     </li>';

        $images .= '<li data-group="group'.$i.'" style="background: url('.$KeyImage.') center center no-repeat;background-size:cover;"></li>';
        
        $dots .='<li class="anim" data-selector="group'.$i.'" onclick="rotateContent(\'group'.$i.'\');clearTimeout(timer);">'.$i.'</li>';
        
        $i++;
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>E&amp;H Construction</title>
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
    <div class="body-height pos-r">
    <?php include($path.'/library/includes/framework/head.inc.php'); ?>
    
        <div class="pos-a pos-sw-corner w-100 bg-blackish-70" id="rotator-utilities" style="z-index:10;">
                <ul class="list-n rotator-captions m-0 fl-l d-b">
                    <?php echo $captions; ?>
                    <!--
                    <li data-group="group1" class="p-10">
                        <h2 class="c-white mb-0 mt-0 little-line futura-book">37th Street</h2>                        
                        <p class="mt-5 mb-0"><a href="/project/37th-Street" class="link">Go to project</a></p>
                    </li>
                    <li data-group="group2" class="p-10">
                        <h2 class="c-white mb-0 mt-0 little-line futura-book">Randolph Residence</h2>
                        <p class="mt-5 mb-0"><a href="/project/Randolph-Residence" class="link">Go to project</a></p>
                    </li>
                    -->
                </ul>
                <ul class="h-list rotator-dots m-0 fl-r pos-a pos-se-corner p-10">
                    <?php echo $dots; ?>
                    <!--
                    <li class="anim" data-selector="group1" onclick="rotateContent('group1');clearTimeout(timer);">1</li>
                    <li class="anim" data-selector="group2" onclick="rotateContent('group2');clearTimeout(timer);">2</li>
                    -->
                </ul>
        </div>
    </div>
    <ul id="rotator-images" class="m-0" style="position: absolute;width: 100%;height: 100%;top: 0;z-index:-10;">
        <?php echo $images; ?>
        <!--
        <li data-group="group1" style="background: url(<?php echo $urlBase; ?>/images/projects/2014/05/480/37thStreet1.jpg) center center no-repeat;background-size:cover;"></li>
        <li data-group="group2" style="background: url(<?php echo $urlBase; ?>/images/projects/2014/05/480/randolph4.jpg) center center no-repeat;background-size:cover;"></li>
        -->
    </ul>
</body>

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
</html>