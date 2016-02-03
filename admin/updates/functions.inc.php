<?php

session_start();
    
$UpdateId = $_GET['UpdateId'];

function ShowImages()
{
    if(isset($_GET['UpdateId']))
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include($path.'/library/includes/config/connect.inc.php');
        
        $UpdateId = $_GET['UpdateId'];
        $database = "ehconstruction";
        
        mysql_select_db("$database") or die(mysql_error());
        
        $sql = "SELECT ProjKeyImg FROM update_nfo WHERE UID = '$UpdateId';";
        
        $data = mysql_query($sql) or die(mysql_error());
        
        while ($row = mysql_fetch_array($data)) {
            $cover = $row['ProjKeyImg'];
        }
        $sql = "SELECT * FROM update_img WHERE fk_UID = '$UpdateId';";
        
        $data = mysql_query($sql) or die(mysql_error());
        
        while ($row = mysql_fetch_array($data)) {
            $ImageName = $row['ImageName'];
            $ImageLink = $row['ImageLink'];
            $ImageTitle = $row['ImageTitle'];
            $ImageCaption = $row['ImageCaption'];
            $ImageID = $row['IID'];
            if($ImageName == $cover){
                $item = '<li class="list-n p-20 img-row pos-r grid_4 cover-selected" id="'.$ImageID.'" data-file="'.$ImageName.'" data-url="'.$ImageLink.'">';
            } else {
                $item = '<li class="list-n p-20 img-row pos-r grid_4" id="'.$ImageID.'" data-file="'.$ImageName.'" data-url="'.$ImageLink.'">';
            }
            $item .= '
                <div class="grid_4 alpha omega pos-r" style="height:200px;background:url('.$ImageLink.'200/'.$ImageName.') center center no-repeat;">
                    <div class="pos-a mark-removal" style="bottom:10px;right:10px;z-index:1000;">X</div>
                    <input type="button" class="set-cover" id="" name="" value="Set as Project Cover" onClick="setCover(\''.$UpdateId.'\',\''.$ImageID.'\',\''.$ImageLink.'\',\''.$ImageName.'\');">
                </div>
                <div class="grid_4 alpha omega">
                    '.$ImageName.'<br>
                    <input class="meta-item" type="text" name="ImageTitle" placeholder="Image Title" value="'.$ImageTitle.'" />
                    <textarea class="meta-item" name="ImageCaption" id="" cols="30" rows="4" placeholder="Caption">'.$ImageCaption.'</textarea>
                </div>
            </li>';
            
            echo $item;
        }
        mysql_close();
        //header("Location: index.php");   
    }
}


function adminUpdateList()
{
    
 $path = $_SERVER['DOCUMENT_ROOT'];
    
    include($path.'/library/includes/config/functions.inc.php');
    userAgent($_SERVER['HTTP_USER_AGENT']);
    
    include($path.'/library/includes/config/connect.inc.php');

    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $sql = 'SELECT * FROM update_nfo;';
            
    $data = mysql_query($sql) or die(mysql_error());
    
    $cards = '';
    
    while ($row = mysql_fetch_array($data)) {
        $UID = $row['UID'];
        $UpName = $row['UpName'];
        $UpLink = $row['UpLink'];
        $UpDescShort = $row['UpDescShort'];
        $UpDate = date('l jS F, Y',strtotime($row['DateAdded']));
        $KeyImage = $row['UpKeyImgUrl'].'480/'.$row['UpKeyImg'];
        
        $card = '
        <li class="list-n d-t update-row pos-r" data-update="'.$UID.'">
            <div class="d-tc">
                <a href="index.php?updateID='.$UID.'"><h3 class="mb-0">'.$UpName.'</h3></a>
                <p class="mt-0 mb-5">'.$UpDescShort.'</p>
                <input type="checkbox" class="" value="Set as Featured" >
            </div>
            <div class="d-tc" style="width:30px;">
                <a class="mark-removal">X</a>
            </div>
        </li>';
        
        $cards .= $card;
    }
    echo $cards;
    mysql_close();
}

// Add or update a listing    
if(isset($_POST['a']) && !empty($_POST['a'])) {
    $action = $_POST['a'];
    switch($action) {
        case 'add' : addUpdate(); break;
        case 'update' : updateUpdate(); break;
        case 'remImg' : removeImage(); break;
        case 'upMeta' : updateMeta(); break;
        case 'remUp' : removeUpdate(); break;
        case 'setCover' : setCover(); break;
    }
}
function clean($string)
{
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
 
function addUpdate()
{
    if(!empty($_POST['t']))
        {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include($path.'/library/includes/config/connect.inc.php');
        $database = "ehconstruction";
        mysql_select_db("$database") or die(mysql_error());
        
        $ProjName = mysql_real_escape_string($_POST['t']);
        $ProjLink = clean($ProjName);
        $ProjVendors = mysql_real_escape_string($_POST['v']);
        $ProjDescShort = mysql_real_escape_string($_POST['s']);
        $ProjDescLong = mysql_real_escape_string($_POST['l']);
           
        $sql = "INSERT INTO update_nfo (ProjFeatured, ProjLink, ProjName,ProjKeyImg,ProjKeyImgUrl,ProjVendors,ProjDescShort,ProjDescLong,DateAdded) VALUES ('0','$ProjLink','$ProjName','','','$ProjVendors','$ProjDescShort','$ProjDescLong',NULL);";
        
        $addProj = mysql_query($sql) or die(mysql_error());
        
        if(!$addProj){
            die('Could not enter data: '.mysql_error());
        } else {
            $sql = "SELECT * FROM update_nfo WHERE ProjName = '$ProjName';";
            
            $data = mysql_query($sql) or die(mysql_error());
            
            while ($row = mysql_fetch_array($data)) {
                $UID = $row['UID'];
            }
            
            mysql_close();
    
            echo "$UID";
               
        }
        // add some stuff to the session for temporary retrieval
        $_SESSION['proj']=$_POST['t'];
    } else {
        return 0;
    }
    mysql_close();
}

function updateUpdate()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $UID = $_POST['UID'];
    $ProjName = mysql_real_escape_string($_POST['t']);
    $ProjLink = clean($ProjName);
    $ProjVendors = mysql_real_escape_string($_POST['v']);
    $ProjDescShort = mysql_real_escape_string($_POST['s']);
    $ProjDescLong = mysql_real_escape_string($_POST['l']);
       
    $sql = "UPDATE update_nfo SET ProjName='$ProjName', ProjLink='$ProjLink', ProjVendors='$ProjVendors', ProjDescShort='$ProjDescShort', ProjDescLong='$ProjDescLong' WHERE UID='$UID';";
    
    $addProj = mysql_query($sql) or die(mysql_error());
    
    if(!$addProj){
        die('Could not enter data: '.mysql_error());
    } else {
        $sql = "SELECT * FROM update_nfo WHERE ProjName = '$ProjName';";
        
        $data = mysql_query($sql) or die(mysql_error());
        
        while ($row = mysql_fetch_array($data)) {
            $UID = $row['UID'];
        }
        
        mysql_close();
        
        echo "$UID";
    }
    // add some stuff to the session for temporary retrieval
    $_SESSION['proj']=$_POST['t'];
    
}

function removeImage()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    
    //mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
    mysql_select_db("$database") or die(mysql_error());
                
    $key = $_POST['k'];
    $file = $_POST['f'];
    $link = $_POST['l'];
                    
    $sql = "DELETE FROM update_img WHERE IID = '$key';";
        
    $data = mysql_query($sql) or die(mysql_error());
    
    // check if the query was executed
    if($data == true){
       // everything ok
       unlink($link.$file);
       unlink($link.'200/'.$file);
       unlink($link.'480/'.$file);
       
       print(1);
    } else {
       // error happened
       print(0);
    }
    
    mysql_close();
}

function removeUpdate()
{
    $UpdateId = $_POST['k'];
    
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    
    ////////////////////////////////////////////////////////////////////////
    // Step 1, find the images associated with the project and remove them
    ////////////////////////////////////////////////////////////////////////
    
    //mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
    mysql_select_db("$database") or die(mysql_error());
    
    $sql = "SELECT ImageLink, ImageName FROM update_img WHERE fk_UID = '$UpdateId';";
    // get the file names and remove each one...
    $data = mysql_query($sql) or die(mysql_error());
    while ($row = mysql_fetch_array($data)) {
        $link = $row['ImageLink'];
        $file = $row['ImageName'];
        
        unlink($link.$file);
        unlink($link.'200/'.$file);
        unlink($link.'480/'.$file);
    }
    
    // delete by image records in the database fk_UID
    $sql = "DELETE FROM update_img WHERE fk_UID = '$UpdateId';";
        
    $data = mysql_query($sql) or die(mysql_error());
    
    // check if the query was executed
    if($data == true){
       // everything ok
       print(1);
    } else {
       // error happened
       print(0);
    }
    
    ////////////////////////////////////////////////////////////////////////
    // Step 2, remove the project from the database
    ////////////////////////////////////////////////////////////////////////
    
    //mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
    mysql_select_db("$database") or die(mysql_error());
                
                    
    $sql = "DELETE FROM update_nfo WHERE UID = '$UpdateId';";
        
    $data = mysql_query($sql) or die(mysql_error());
    
    // check if the query was executed
    if($data == true){
       // everything ok
       print(1);
       if($_GET['UpdateId'] == $UpdateId){
           // if we were looking at this project, refresh the page
           header("Location: index.php");
       }
       
    } else {
       // error happened
       print(0);
    }
    
    mysql_close();
}

function updateMeta()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $key = $_POST['k'];
    $meta = $_POST['c'];
    $val = mysql_real_escape_string($_POST['v']);
                    
    $sql = "UPDATE update_img SET $meta='$val' WHERE IID = '$key';";
        
    $data = mysql_query($sql) or die(mysql_error());
    
    // check if the query was executed
    if($data == true){
       // everything is Ok, the data was inserted
       print(1);
    } else {
       // error happened
       print(0);
    }
    
    mysql_close();
}

function setCover()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $UID = $_POST['p'];
    $ImgLink = $_POST['l'];
    $ImgName = $_POST['f'];
       
    $sql = "UPDATE update_nfo SET ProjKeyImg='$ImgName', ProjKeyImgUrl='$ImgLink' WHERE UID='$UID';";
    
    $data = mysql_query($sql) or die(mysql_error());
    
    if($data == true){
       
       print(1);
    } else {
       // error happened
       print(0);
    }
    // add some stuff to the session for temporary retrieval
    //$_SESSION['proj']=$_POST['t'];
    mysql_close();
}

?>